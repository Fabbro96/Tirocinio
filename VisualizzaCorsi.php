<?php
$host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
$database = 'd53jiomn4btlbs';
$user = 'vnnfvmmusrzflv';
$psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
$dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
if (!$dbconn)
    echo "Connessione NON effettuata";
else {
    $query = "SELECT * FROM PersonaIscritta";
    $result = pg_query($dbconn, $query);
}

//EOF sta per "End of file"
$sql = <<<EOF
      SELECT * from corso;
EOF;

//This routine executes the query on the specified database connection. -> esegue la query sul database, restituisce tutti i campi delle persone iscritte
$ret = pg_query($dbconn, $sql);
if (!$ret) {
    echo pg_last_error($dbconn);
    exit;
} ?>

<!DOCTYPE html>
<html>
<title>
    Fetch data from database
</title>

<body>
<table align="center" border="1px" style="width: 200px; line-height: 25px">
    <tr>
        <th colspan="5">Tabella di corsi</th>
    </tr>
<!-- Creazione di una tabella con queste colonne -->
    <t>
        <th>Nome</th>
        <th>Etá media</th>
        <th>Stile</th>
    </t>
<!-- Cicla riga per riga. $row[posizione] serve per restituire l'elemento nella colonna posizione -->
    <?php while ($row = pg_fetch_row($ret)) { ?>
        <tr>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
<!-- Chiude la connessione-->
<?php pg_close($dbconn);?>
