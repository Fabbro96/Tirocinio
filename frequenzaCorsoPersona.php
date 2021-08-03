<?php session_start();
error_reporting(0);
$bool = $_SESSION['emailsessione'] == 'admin@admin.com';
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
        $query_persona = "SELECT nome, cognome, email FROM personaiscritta";
        $result_corso = pg_query($dbconn, $query_corso);
        $result_persona = pg_query($dbconn, $query_persona);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frequenza di un corso da parte di una persona</title>
</head>
<body>

<style>
    .obbligatorio {
        border: solid red;
        border-radius: 4px;
    }

    /*CSS per il bottone submit*/
    .submit {
        background-color: darkblue;
        border: blue;
        color: white;
        padding: 10px 10px;
        margin: 4px 2px;
    }

    /*CSS per il bottone reset*/
    .reset {
        background-color: red;
        border: #555555;
        color: black;
        padding: 10px 10px;

    }

    h4 {
        color: red;
    }
</style>

<?php $bool = !isset($_SESSION['nomesessione']) || !isset($_SESSION['cognomesessione']);
if ($bool === true || (strtolower($_SESSION['nomesessione']) != "admin" && strtolower($_SESSION['cognomesessione']) != "admin")) {
    echo '<script> alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");
window.location.href = "home.php";</script>';
} ?>

<center>
    <h3>Pagina delle frequenze</h3>

    <h4> Attenzione! I bordi contrassegnati in rosso sono per contrassegnare i campi che devono essere univoci
        all'interno del DataBase.</h4>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td>Data di iscrizione:</td>
                <td>
                    <input type="date" name="dataiscrizione">
                </td>
            </tr>

            <tr>
                <td>Nome corso:</td>
                <td>
                    <select name="corso" id="idcorso">
                        <?php while ($row = pg_fetch_row($result_corso)) { ?>
                            <option><?php echo $row[0]; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Nome persona:</td>
                <td>
                    <select name="nomepersona" id="idnomepersona">
                        <?php while ($row = pg_fetch_row($result_persona)) { ?>
                            <option><?php echo $row[0] . " " . $row[1] . ",email: " . $row[2]; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Volte a settimana:</td>
                <td>
                    <input type="number" name="numerovolte" id="idnumerovolte" max="7" min="1" value="3">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="send">
                </td>
            </tr>
        </table>
    </form>
</center>


</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeCorso = $_POST['corso'];
    $tmp = $_POST['nomepersona'];
    $splittato = explode(": ", $tmp);
    $mailPersona = $splittato[1];
    $volteSettimana = $_POST['numerovolte'];
    $dataIscrizione = $_POST['dataiscrizione'];
    //echo "Data iscrizione: " . $dataIscrizione . " nome_corso: " . $nomeCorso . " email: " . $mailPersona . " frequenza: " . $volteSettimana;
    if (!(empty($nomeCorso) || empty($mailPersona) || empty($volteSettimana) || empty($dataIscrizione))) {
        $querydue = "INSERT INTO frequenza_corso_persona(data_iscrizione, nome_corso, email_persona, frequenza_settimanale)
        VALUES ('$dataIscrizione','$nomeCorso','$mailPersona','$volteSettimana')";
        $risultato = pg_query($dbconn, $querydue);
    }
}
pg_close($dbconn);
?>

















