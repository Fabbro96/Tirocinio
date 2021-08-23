<?php
session_start();
error_reporting(0);
if ($_SESSION['emailsessione'] != 'admin@admin.com') {
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
} ?>

<style>
    .box {
    }

    .box select {
        background-color: #00A5E3;
        color: black;
        padding: 5px;
        border: none;
        box-shadow: blue;
        -webkit-appearance: button;
        outline: none;
    }

    .box::before {
        position: absolute;
        text-align: center;
        color: grey;
        background-color: grey;
        pointer-events: none;
    }

    .box select option {
        padding: 30px;
    }

    .month {
    }

    .month select {
        background-color: #95999c;
        color: black;
        padding: 5px;
        border: none;
        box-shadow: blue;
        -webkit-appearance: button;
        outline: none;
    }

    .month::before {
        position: absolute;
        text-align: center;
        color: grey;
        background-color: grey;
        pointer-events: none;
    }

    .month select option {
        padding: 30px;
    }

    body {
        color: white;
        background: #76b852; /* fallback for old browsers */
        background: -webkit-linear-gradient(right, navajowhite, #00cc66);
        background: -moz-linear-gradient(right, navajowhite, #00cc66);
        background: -o-linear-gradient(right, navajowhite, #00cc66);
        background: linear-gradient(to left, navajowhite, #00cc66);
        font-family: "Roboto", sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    h3 {
        color: darkblue;
    }

    .button {
        font-family: "Roboto", sans-serif;
        outline: 0;
        background: lightblue;
        width: auto;
        border: 0;
        padding: 10px;
        color: black;
        font-size: 14px;
        cursor: auto;
    }

    .button:hover, .form button:active, .form button:focus {
        background: cornflowerblue;
    }

</style>

<html lang="html">
<head>
    <title>Pagina controllo pagamenti</title>
</head>
<body>

<h3>Pagina controllo pagamenti</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
    <div class="month">
        <select name="persone_pagamenti" id="idpagamenti">
            <?php while ($row = pg_fetch_row($result)) {
                if (strtolower($row[0]) === "admin" || strtolower($row[1]) === "admin") ?>
                    <option><?php echo $row[0] . " " . $row[1] . " email: " . $row[2]; ?></option>
            <?php } ?>
        </select>
    </div>
    <br>
    <div class="box">
        <select name="mese" id="idmese">
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
        <input name="anno" type="number" min="1960" max="2099" step="1" value="2021"/><br></div>
    <div class="radiobutton" id="radio">
        <form class="mb-3">
            <label>
                <input type="radio" name="radio" value="true">Sí
            </label>
            <label>
                <input type="radio" name="radio" value="false">No
            </label>
            <br><br>
            <input type="submit" name="esegui" onclick="return fun()" class="button">
        </form>
    </div>
</form>
<script>
    function fun() {
        const rbs = document.querySelectorAll('input[name="radio"]');
        var nomecognome = document.getElementById("idpagamenti").value;
        var ckmese = document.getElementById("idmese").value;
        if (ckmese === "--SELEZIONA IL MESE--") {
            alert("Prego, selezionare il mese");
            return false;
        } else {
            nomecognome = nomecognome.split(" ");
            const nome = nomecognome[0];
            const cognome = nomecognome[1];
            let booleano = false;
            let selectedValue;
            for (const rb of rbs) {
                if (rb.checked) {
                    selectedValue = rb.value;
                    booleano = true;
                    break;
                }
            }
            if (!booleano) {
                alert("Prego, selezionare un valore");
                return false;
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
pg_close($dbconn);
?>
</body>
</html>

