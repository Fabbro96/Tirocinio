<?php

session_start();
$bool = !isset($_SESSION['nomesessione']) || !isset($_SESSION['cognomesessione']);
if ($bool === true) {
    //NON SEI AUTENTICATO, COME FAI A SCEGLIERE UN CORSO? VAI A HOME
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

//QUI BISOGNA RE-INDIRIZZARE NEL CASO NON FOSSE ACCEDUTO COME ADMIN-->ATTENZIONE, VEDE NOME E COGNOME (ADMIN ADMIN)
$bool = $_SESSION['emailsessione'] == 'admin@admin.com';
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
}
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
                <option><?php echo $row[0] . " " . $row[1]; ?></option>
        <?php } ?>
    </select>

    <div class="radiobutton">
        <form class="mb-3">
            <label>
                <input type="radio" name="radio" value="si">Sí
            </label>
            <label>
                <input type="radio" name="radio" value="no">No
            </label>
            <br>
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
//METODO PER USARE I VALORI USATI IN PHP NELLA PAGINA STESSA//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['persone_pagamenti'];
    $valore = $_POST['radio'];
    if (empty($name)) {
        echo "Name is empty";
    } else {
        $temp = explode(" ", $name);
        $nome = $temp[0];
        $cognome = $temp[1];
        $_SESSION['haPagato'] = $valore;
        echo $nome . " " . $cognome . " ha pagato? " . strtoupper($valore);
        $query = "UPDATE personaiscritta SET hapagato = '$valore' WHERE (nome='$nome' AND cognome='$cognome')";
        $res = pg_query($dbconn, $query);
    }
}
?>
</body>
</html>

