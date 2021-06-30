<?php
//Starto la sessione
session_start();
$host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
$database = 'd53jiomn4btlbs';
$user = 'vnnfvmmusrzflv';
$psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
$dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
if (!$dbconn)
    echo "Connessione NON effettuata";
else {
    $email = $_POST['emailutente'];
    $password = $_POST['password'];
}
$sql = <<<EOF
      SELECT * from PersonaIscritta;
EOF;
$ret = pg_query($dbconn, $sql);
if (!$ret) {
    echo pg_last_error($dbconn);
    exit;
}
static $i = 0;
//Filtro tutte le mail e le password presenti nel DB, appena ne trovo due di uguali restituisco una stringa concatenata al nome e cognome
while ($row = pg_fetch_row($ret))
    if ($row[2] == strtolower($email) && $row[5] == $password) {
        echo "Benvenuto " . $row[0] . " " . $row[1];
        //Passo la variabile chiamata emailsessione alla sessione dandogli in pasto il parametro della seconda colonna del DataBase
        $_SESSION["emailsessione"] = $row[2];
        //Passo anche nome e cognome nella sessione
        $_SESSION["nomesessione"] = $row[0];
        $_SESSION["cognomesessione"] = $row[1];
        $i = $i + 1;
        ?>
        <br>
        Esegui il <a href="logout.php">logout</a>
        <?php
    }
if ($i == 0) {
    echo "Password o E-Mail errata. Nel caso non fossi registrato, registrati."; ?>
    <br> <br>
    Clicca <a href="PaginaLogin.php">qui</a> per tornare alla pagina di login
    <?php
}
?>
    <br>
    Clicca <a href="home.php">qui</a> per tornare alla Home
<?php pg_close($dbconn);
?>