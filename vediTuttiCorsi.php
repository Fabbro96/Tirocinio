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
    Lista dei corsi
</title>
<script>
    $(window).on("load resize ", function () {
        var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
        $('.tbl-header').css({'padding-right': scrollWidth});
    }).resize();
</script>
<body>
<style>

    h1 {
        font-size: 30px;
        color: #fff;
        text-transform: uppercase;
        font-weight: 300;
        text-align: center;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        table-layout: fixed;
    }

    .tbl-header {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .tbl-content {
        /*Altezza della tabella*/
        height: 100%;
        overflow-x: auto;
        margin-top: 0px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    th {
        padding: 20px 15px;
        text-align: left;
        font-weight: 500;
        font-size: 12px;
        color: #fff;
        text-transform: uppercase;
    }

    td {
        padding: 15px;
        text-align: left;
        vertical-align: middle;
        font-weight: 300;
        font-size: 12px;
        color: #fff;
        border-bottom: solid 1px rgba(255, 255, 255, 0.1);
    }

    /* demo styles */
    @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
    body {
        background: -webkit-linear-gradient(left, #25c481, #25b7c4);
        background: linear-gradient(to right, #25c481, #25b7c4);
        font-family: 'Roboto', sans-serif;
    }

    section {
        margin: 50px;
    }

    /* follow me template */
    .made-with-love {
        margin-top: 40px;
        padding: 10px;
        clear: left;
        text-align: center;
        font-size: 10px;
        font-family: 'Roboto', sans-serif;
        color: #fff;
    }

    .made-with-love i {
        font-style: normal;
        color: #F50057;
        font-size: 14px;
        position: relative;
        top: 2px;
    }

    .made-with-love a {
        color: #fff;
        text-decoration: none;
    }

    .made-with-love a:hover {
        text-decoration: underline;
    }


    /* for custom scrollbar for webkit browser*/

    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }
</style>



<h1>Corsi disponibili</h1>
<div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Stile</th>
            <th>Etá media</th>
            <th>Data d'inizio</th>
            <th>Data di fine</th>
            <th>Costo mensile</th>
            <th>Numero di sicurezza Insegnante</th>
        </tr>
        </thead>
    </table>
</div>
<div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
        <?php
        $emailsessione = $_SESSION["emailsessione"];
        $query = "SELECT * FROM corso";
        $risultato = pg_query($dbconn, $query);
        while ($row = pg_fetch_row($risultato)) { ?>
        <tr>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
            <td><?php echo $row[3]; ?></td>
            <td><?php echo $row[6]; ?></td>
            <td><?php echo $row[4]; ?></td>
            <td><?php echo $row[5]; ?></td>
            <?php
            } ?>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
<!-- Chiude la connessione-->
<?php pg_close($dbconn); ?>

