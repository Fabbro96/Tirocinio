<?php
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
if ($attenzione == 0) {
    /*$prequery="SELECT datanascita FROM personaiscritta"; p JOIN corso c on c.nome = p.nome ";
    $doquery=pg_query($dbconn,$prequery);
    echo $doquery;*/
    $query = "INSERT INTO corso(nome,etamedia,stile) VALUES ('$nome',null,'$stile')";
    $res = pg_query($dbconn, $query);
    echo "Grazie per la sua registrazione! Ora potrá effettuare il login tramite email e password.";
} else if ($attenzione == 2)
    echo "Attenzione, il corso é giá presente nel DataBase.";
pg_close($dbconn);
?>