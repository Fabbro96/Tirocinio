<?php
$host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
$database = 'd53jiomn4btlbs';
$user = 'vnnfvmmusrzflv';
$psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
$dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
if (!$dbconn)
{
    echo pg_last_error($dbconn);
    echo "Connessione NON effettuata";
}

else {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = strtolower($_POST['email']);
    $datanascita=date('Y-m-d',strtotime($_POST['datadinascita']));
    $numerotelefono = $_POST['prefissi'] . $_POST['numerotelefono'];
    $password = $_POST['password'];
    $repsw = $_POST['repassword'];
    $v = $password == $repsw;
}
$sql = <<<EOF
      SELECT email from PersonaIscritta;
EOF;

$ret = pg_query($dbconn, $sql);
if (!$ret) {
    echo pg_last_error($dbconn);
    exit;
}
$attenzione = 0; //Uso questa variabile per gestire diversi tipi di errori
if ($nome == "" || $cognome == "" || $email == "" || $numerotelefono == "" || $password == "" || !$v)
    $attenzione = 1;
while ($row = pg_fetch_row($ret))
    if ($row[0] == $email)
        $attenzione = 2;
if ($attenzione == 0) {
    $query = "INSERT INTO personaiscritta(nome,cognome,email,numero_telefono,datanascita,password) VALUES ('$nome','$cognome','$email','$numerotelefono','$datanascita','$password')";
    $res = pg_query($dbconn, $query);
    echo "Grazie per la sua registrazione! Ora potrá effettuare il login tramite email e password.";
} else if ($attenzione == 2)
    echo "Attenzione, l'email inserita é giá presente nel DataBase. Ti preghiamo di utilizzarne una diversa.";
pg_close($dbconn);
