<?php session_start() ?>
<script>
    function checkEmpty() {
        var cknome = document.getElementById("inputnome").value;
        var ckcorso = document.getElementById("inputcorso").value;
        if (cknome == "") {
            alert("Prego, inserire il nome del corso");
            return false;
        } else if (ckcorso == "") {
            alert("Prego, inserire lo stile del corso");
            return false;
        }
    }
</script>
<?php
//QUI BISOGNA RE-INDIRIZZARE NEL CASO NON FOSSE ACCEDUTO COME ADMIN-->ATTENZIONE, VEDE NOME E COGNOME (ADMIN ADMIN)
$bool = $_SESSION['emailsessione'] == 'admin@admin.com';
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");' . $_SESSION['emailsessione'];
    echo 'window.location.href = "home.php";';
    echo '</script>';
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pagina di inserimento corsi</title>
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
    <h3>Pagina di inserimento dei corsi</h3>

    <h4> Attenzione! I bordi contrassegnati in rosso sono per contrassegnare i campi che devono essere univoci
        all'interno del DataBase.</h4>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td>Nome:</td>
                <td>
                    <input type="text" name="nome" id="inputnome" class="obbligatorio">
                </td>
            </tr>

            <tr>
                <td>Stile:</td>
                <td>
                    <input type="text" name="stile" id="inputcorso" class="obbligatorio">
                </td>
            </tr>
            <tr>
                <td>Fascia d'etá:</td>
                <td>
                    <input type="text" name="nome" id="inputnome" class="obbligatorio">
                </td>
            </tr>

            <tr>
                <td>Inizio:</td>
                <td>
                    <input type="date" name="stile" id="inputcorso" class="obbligatorio">
                </td>
            </tr>
            <tr>
                <td>Volte a settimana:</td>
                <td>
                    <input type="text" name="nome" id="inputnome" class="obbligatorio">
                </td>
            </tr>

            <tr>
                <td>Costo:</td>
                <td>
                    <input type="text" name="stile" id="inputcorso" class="obbligatorio">
                </td>
            </tr>

            <tr>
                <td>
                    <button type="submit" name="buttonAggiunta" onclick="return checkEmpty()" class="submit">
                        Aggiungi corso
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="reset" name="buttonReset" class="reset">Reset dei campi</button>
                </td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>


<?php
if (isset($_POST['stile'])) {
    $host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
    $database = 'd53jiomn4btlbs';
    $user = 'vnnfvmmusrzflv';
    $psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
    $dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
    if (!$dbconn) {
        echo pg_last_error($dbconn);
        echo "Connessione NON effettuata";
    } else {
        $nome = $_POST['nome'];
        $stile = $_POST['stile'];
    }
    $sql = <<<EOF
      SELECT * from corso;
EOF;

    $ret = pg_query($dbconn, $sql);
    if (!$ret) {
        echo pg_last_error($dbconn);
        exit;
    }
    $attenzione = 0;
    if ($nome == "" || $stile == "")
        $attenzione = 1;
    while ($row = pg_fetch_row($ret))
        if ($row[0] == $nome)
            $attenzione = 2;
//Inserisce il corso, aspetta 5 secondi e reindirizza a URL
    header("Refresh: 5; url= http://localhost/TestPHP/inserimentocorso.html");
    if ($attenzione == 0) {
        $query = "INSERT INTO corso(nome,etamedia,stile) VALUES ('$nome',null,'$stile')";
        $res = pg_query($dbconn, $query);
        echo "Corso " . strtolower($nome) . " con stile " . strtolower($stile) . " inserito con successo";
    } else if ($attenzione == 2)
        echo "Attenzione, il corso é giá presente nel DataBase.";
    pg_close($dbconn);

} ?>











