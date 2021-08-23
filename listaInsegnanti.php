<?php
// Turn off all error reporting
error_reporting(0);
//Starto la sessione
session_start();
if ($_SESSION['emailsessione'] == 'admin@admin.com') {
    $host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
    $database = 'd53jiomn4btlbs';
    $user = 'vnnfvmmusrzflv';
    $psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
    $dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
    if (!$dbconn)
        echo "Connessione NON effettuata";
    else {
        $sql = "SELECT * FROM insegnante";
        $ret = pg_query($dbconn, $sql);
        if (!$ret) {
            echo pg_last_error($dbconn);
            exit;
        } ?>
        <!DOCTYPE html>
        <html>
        <title>
            Tabella degli insegnanti
        </title>

        <body>
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
                font-family: "Roboto", sans-serif;
                color: whitesmoke;
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
                font-family: "Roboto", sans-serif;
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
                font-family: "Roboto", sans-serif;
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
        <h1>Tabella degli insegnanti</h1>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>E-Mail</th>
                    <th>Numero di Sicurezza</th>
                    <th>Numero di Telefono</th>
                    <th>Specializzazione</th>
                    <th>Password</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <!-- Cicla riga per riga. $row[posizione] serve per restituire l'elemento nella colonna posizione -->
                <?php while ($row = pg_fetch_row($ret)) { ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2]; ?></td>
                        <td><?php echo $row[3]; ?></td>
                        <td><?php echo $row[4]; ?></td>
                        <td><?php echo $row[5]; ?></td>
                        <td><?php echo $row[6]; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        </body>
        </html>
    <?php }
} else {

    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
}
pg_close($dbconn); ?>
