<?php
session_start();
$bool = !isset($_SESSION['nomesessione']) || !isset($_SESSION['cognomesessione']);
if ($bool === true) {
    echo '<script>';
    echo 'alert("Devi essere admin per entrare in questa pagina");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
} else {
    $host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
    $database = 'd53jiomn4btlbs';
    $user = 'vnnfvmmusrzflv';
    $psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
    $dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
    if (!$dbconn)
        echo "Connessione NON effettuata";
    else {
        $query = "SELECT * FROM personaiscritta";
        $result = pg_query($dbconn, $query);
    }
}

/*$boolo = $_SESSION['emailsessione'] == 'admin@admin.com';
if ($boolo === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");' . $_SESSION['emailsessione'];
    echo 'window.location.href = "home.php";';
    echo '</script>';
}*/
?>
<html>
<head>
    <title>Pagina controllo pagamenti</title>
</head>
<body>


<h3>Pagina controllo pagamenti</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
    <select name="persone_pagamenti" id="idpagamenti">
        <?php while ($row = pg_fetch_row($result)) {
            if (strtolower($row[0]) === "admin" || strtolower($row[1]) === "admin") ?>
                <option><?php echo $row[0] . " " . $row[1] . " email: " . $row[2]; ?></option>
        <?php } ?>
    </select>
    <br><br>

    <select name="mese">
        <option selected disabled>--SELEZIONA IL MESE--</option>
        <option value="Gennaio">Gennaio</option>
        <option value="Febbraio">Febbraio</option>
        <option value="Marzo">Marzo</option>
        <option value="Aprile">Aprile</option>
        <option value="Maggio">Maggio</option>
        <option value="Giugno">Giugno</option>
        <option value="Luglio">Luglio</option>
        <option value="Agosto">Agosto</option>
        <option value="Settembre">Settembre</option>
        <option value="Ottobre">Ottobre</option>
        <option value="Novembre">Novembre</option>
        <option value="Dicembre">Dicembre</option>
    </select>
    <input name="anno" type="number" min="1960" max="2099" step="1" value="2021"/><br>
    <div class="radiobutton">
        <form class="mb-3">
            <label>
                <input type="radio" name="radio" value="true">Sí
            </label>
            <label>
                <input type="radio" name="radio" value="false">No
            </label>
            <br><br>
            <input type="submit" name="esegui" onclick="fun()" class="submit">
        </form>
    </div>
</form>
<script>
    function fun() {
        const rbs = document.querySelectorAll('input[name="radio"]');
        var nomecognome = document.getElementById("idpagamenti").value;
        nomecognome = nomecognome.split(" ");
        const nome = nomecognome[0];
        const cognome = nomecognome[1];
        let selectedValue;
        for (const rb of rbs) {
            if (rb.checked) {
                selectedValue = rb.value;
                break;
            }
        }
    }
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valore = $_POST['radio'];
    $_SESSION['haPagato'] = $valore;
    $tmp = explode(": ", $_POST['persone_pagamenti']);
    $email = $tmp[1];
    $anno = $_POST['anno'];
    $mese = $_POST['mese'];
    $query = "SELECT * FROM pagamentomensile_persona";
    $risultato = pg_query($dbconn, $query);
    static $i = 0;
    while ($row = pg_fetch_row($risultato))
        if ($row[0] === $email && $row[2] === $mese && $row[3] === $anno) {
            $query = "UPDATE pagamentomensile_persona SET hapagato = '$valore' WHERE (email='$email' AND mese='$mese' AND anno='$anno')";
            $i++;
        }
    if ($i === 0)
        $query = "INSERT INTO pagamentomensile_persona(email,hapagato,mese,anno) VALUES('$email','$valore','$mese','$anno')";
    pg_query($dbconn, $query);
}
?>
</body>
</html>

