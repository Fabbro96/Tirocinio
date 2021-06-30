<?php
$host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
$database = 'd53jiomn4btlbs';
$user = 'vnnfvmmusrzflv';
$psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
$dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
if (!$dbconn)
    echo "Connessione NON effettuata";
else {
    $query = "SELECT * FROM Corso";
    $result = pg_query($dbconn, $query);
} ?>

<html>
<head>
    <title>Iscrizione al corso</title>
</head>
<body>

</body>
<h3>Benvenuti nella pagina di scelta dei corsi disponibili</h3>
<form action="inserimentocorsi.php" method="post">
    <select name=prefissi id="prefissi">
        <?php while ($row = pg_fetch_row($result)) { ?>
            <option><?php echo $row[0]; ?></option>
            <?php /*endwhile; */?>
        <?php } ?>
    </select>
</html>


<!--UPDATE PersonaIscritta PI
SET PI.nomeCorso=''-->