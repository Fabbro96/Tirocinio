<?php
session_start();
$host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
$database = 'd53jiomn4btlbs';
$user = 'vnnfvmmusrzflv';
$psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
$dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
if (!$dbconn)
    echo "Connessione NON effettuata";
else {
    $query = "SELECT * FROM corso";
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
<h3>Pagina disiscrizione corsi</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
    <select name="personecorso" id="idpersonecorso">
        <?php while ($row = pg_fetch_row($result)) {
            ?>
            <option><?php echo $row[0] . ";" . $row[6]; ?></option>
        <?php } ?>
    </select>
    <br>
    <input type="submit" name="esegui" onclick="fun()" class="submit">
</form>
<script>
    function fun() {
        var nomecorsoemail = document.getElementById("idpersonecorso").value;
        nomecorsoemail = nomecorsoemail.split(";");
        const nomeCorso = nomecorsoemail[0];
        const emailPersona = nomecorsoemail[1];
    }
</script>
<?php
//METODO PER USARE I VALORI USATI IN PHP NELLA PAGINA STESSA//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['personecorso'];
    if (empty($name)) {
        echo "Name is empty";
    } else {
        $temp = explode(" ", $name);
        $nomeCorso = $temp[0];
        $emailPersona = $temp[1];
        echo $nomeCorso . " " . $emailPersona . " ha pagato? ";
        $query = "DELETE FROM corso WHERE (nome='$nomecorso' AND emailPersona='$emailPersona')";
        $res = pg_query($dbconn, $query);
    }
}
?>
