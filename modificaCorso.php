<?php
session_start();
$bool = !isset($_SESSION['nomesessione']) || !isset($_SESSION['cognomesessione']);
if ($bool === true) {
    //NON SEI AUTENTICATO, COME FAI A SCEGLIERE UN CORSO? VAI A HOME
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
        $query_corso = "SELECT nome FROM corso";
        $query_insegnante = "SELECT numero_sicurezza FROM insegnante";
        $result_corso = pg_query($dbconn, $query_corso);
        $result_insegnante = pg_query($dbconn, $query_insegnante);
    }
}

//QUI BISOGNA RE-INDIRIZZARE NEL CASO NON FOSSE ACCEDUTO COME ADMIN-->ATTENZIONE, VEDE NOME E COGNOME (ADMIN ADMIN)
$bool = $_SESSION['emailsessione'] == 'admin@admin.com';
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");' . $_SESSION['emailsessione'];
    echo 'window.location.href = "home.php";';
    echo '</script>';
}
?>

<html>
<head>
    <title>Pagina controllo pagamenti</title>
</head>
<body>


<h3>Pagina per modificare un corso</h3>
<div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td>
                    <select name="corso" id="idcorso">
                        <?php while ($row = pg_fetch_row($result_corso)) { ?>
                            <option><?php echo $row[0]; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nome:</td>
                <td>
                    <input type="text" name="nome" id="idnome">
                </td>
            </tr>

            <tr>
                <td>Stile:</td>
                <td>
                    <input type="text" name="stile" id="idstile">
                </td>
            </tr>

            <tr>
                <td>Fascia d'etá:</td>
                <td>
                    <input type="text" name="fascia" id="idfascia">
                </td>
            </tr>


            <tr>
                <td>Inizio:</td>
                <td>
                    <input type="date" name="iniziocorso" id="idinizio">
                </td>
            </tr>
            <tr>
                <td>Fine:</td>
                <td>
                    <input type="date" name="finecorso" min="iniziocorso" max="2100-12-31">
                </td>
            </tr>

            <tr>
                <td>Costo:</td>
                <td>
                    <input type="text" name="costo" id="idcosto">
                </td>
            </tr>

            <tr>
                <td>Insegnante:</td>
                <td>
                    <select name="insegnante" id="idinsegnante">
                        <?php while ($row = pg_fetch_row($result_insegnante)) { ?>
                            <option><?php echo $row[0]; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="Esegui"> <br>
                    <button type="reset" name="buttonReset" class="reset">Reset dei campi</button>
                </td>
            </tr>
        </table>
    </form>
</div>


<?php
//METODO PER USARE I VALORI USATI IN PHP NELLA PAGINA STESSA//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $corsoSelezionato = $_POST['corso'];
    $nomeCorso = $_POST['nome'];
    $stile = $_POST['stile'];
    $fascia = $_POST['fascia'];
    $datainizio = $_POST['iniziocorso'];
    $datafine = $_POST['finecorso'];
    $costo = $_POST['costo'];
    $insegnante = $_POST['insegnante'];
    if ($nomeCorso != null && $stile != null && $fascia != null && $datainizio != null && $costo != null && $insegnante != null) {
        $query = "UPDATE corso SET nome = '$nomeCorso',stile = '$stile', fascia_persone = '$fascia' , inizio = '$datainizio',fine = '$datafine' ,costo = '$costo' , numeroInsegnante = '$insegnante'  WHERE (nome='$corsoSelezionato')";
        $res = pg_query($dbconn, $query);
        if (!(error_get_last() != null)) {
            echo '<script>';
            echo ' location.href="modificacorso.php"';
            echo '</script>';
        }
    }
}
?>
</body>
</html>

