<?php session_start();
error_reporting(0);
$bool = $_SESSION['emailsessione'] != 'admin@admin.com';
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");' . $_SESSION['emailsessione'];
    echo 'window.location.href = "home.php";';
    echo '</script>';
} else {
    $host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
    $database = 'd53jiomn4btlbs';
    $user = 'vnnfvmmusrzflv';
    $psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
    $dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
    if (!$dbconn) {
        echo pg_last_error($dbconn);
        echo "Connessione NON effettuata";
    } else {
        $query_corso = "SELECT nome FROM corso";
        $query_persona = "SELECT email FROM personaiscritta";
        $result_corso = pg_query($dbconn, $query_corso);
        $result_persona = pg_query($dbconn, $query_persona);
    }
}
?>

<script>
    function checkEmpty() {
        let data = document.getElementById("iddata").value.toString().length;
        let numero = document.getElementById("idnumerovolte").value;
        if (numero === "") {
            alert("Prego, inserire il numero di volte");
            return false;
        } else if (data === 0) {
            alert("Prego, inserire la data d'inizio");
            return false;
        }
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frequenza di un corso da parte di una persona</title>
</head>
<body>

<style>
    .box {
    }

    .box select {
        background-color: greenyellow;
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


    .nomecorso {
    }

    .nomecorso select {
        background-color: grey;
        color: black;
        padding: 5px;
        border: none;
        box-shadow: blue;
        -webkit-appearance: button;
        outline: none;
    }

    .nomecorso::before {
        position: absolute;
        text-align: center;
        color: grey;
        background-color: grey;
        pointer-events: none;
    }

    .nomecorso select option {
        padding: 30px;
    }

    body {
        color: white;
        background: #76b852; /* fallback for old browsers */
        background: -webkit-linear-gradient(right, darkblue, darkslategrey);
        background: -moz-linear-gradient(right, darkblue, darkslategrey);
        background: -o-linear-gradient(right, darkblue, darkslategrey);
        background: linear-gradient(to left, darkblue, darkslategrey);
        font-family: "Roboto", sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    h3 {
        color: yellowgreen;
    }

    .button {
        font-family: "Roboto", sans-serif;
        outline: 0;
        background: dodgerblue;
        width: auto;
        border: 0;
        padding: 10px;
        color: white;
        font-size: 14px;
        cursor: auto;
    }

    .button:hover, .form button:active, .form button:focus {
        background: blue;
    }
</style>

<center>
    <h3>Pagina delle frequenze</h3>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td>Data di iscrizione:</td>
                <td>
                    <input type="date" name="dataiscrizione" id="iddata">
                </td>
            </tr>

            <tr>
                <td>Nome corso:</td>
                <td>
                    <div class="nomecorso">
                        <select name="corso" id="idcorso">
                            <?php while ($row = pg_fetch_row($result_corso)) {
                                ?>
                                <option><?php echo $row[0]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Nome persona:</td>
                <td>
                    <div class="box">
                        <select name="persona" id="idpersona">
                            <?php while ($row = pg_fetch_row($result_persona)) {
                                ?>
                                <option><?php echo $row[0]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </td>
            </tr>

            <tr>
                <td>Volte a settimana:</td>
                <td>
                    <input type="number" name="numerovolte" id="idnumerovolte" max="7" min="1" value="3" checked>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="send" onclick="checkEmpty()" class="button">
                </td>
            </tr>
        </table>
    </form>
</center>


</body>
</html>
<?php
if (isset($_POST['send'])) {
    $nomeCorso = $_POST['corso'];
    $mailPersona = $_POST['persona'];
    $volteSettimana = $_POST['numerovolte'];
    $dataIscrizione = $_POST['dataiscrizione'];
    static $attenzione = 0;
    $query_test = "SELECT nome_corso,email_persona FROM frequenza_corso_persona";
    $result_test = pg_query($dbconn, $query_test);
    while ($row = pg_fetch_row($result_test)) {
        if ($row[0] == $nomeCorso && $row[1] == $mailPersona)
            $attenzione = 2;
    }
    if ($attenzione == 2) {
        echo '<script>';
        echo 'alert("Attenzione, i valori inseriti sono giá presenti nel database");';
        echo '</script>';
    } else if ($attenzione == 0 && $volteSettimana != "" && $dataIscrizione != "") {
        $querydue = "INSERT INTO frequenza_corso_persona(data_iscrizione, nome_corso, email_persona, frequenza_settimanale)
        VALUES ('$dataIscrizione','$nomeCorso','$mailPersona','$volteSettimana')";
        $risultato = pg_query($dbconn, $querydue);
        echo '<script>';
        echo 'alert("Valori inseriti correttamente");';
        echo '</script>';
    }
}
pg_close($dbconn);
?>

















