<?php
session_start();
//error_reporting(0);
if ($_SESSION['emailsessione'] != 'admin@admin.com') {
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
    ?>

    <style>
        .box {
        }

        .box select {
            background-color: #00A5E3;
            color: black;
            padding: 5px;
            border: none;
            box-shadow: blue;
            -webkit-appearance: button;
            outline: none;
        }

        .box::before {
            position: absolute;
            text-align: center;
            color: grey;
            background-color: grey;
            pointer-events: none;
        }

        .box select option {
            padding: 30px;
        }

        body {
            color: black;
            background: #76b852; /* fallback for old browsers */
            background: -webkit-linear-gradient(right, navajowhite, #00cc66);
            background: -moz-linear-gradient(right, navajowhite, #00cc66);
            background: -o-linear-gradient(right, navajowhite, #00cc66);
            background: linear-gradient(to left, navajowhite, #00cc66);
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h3 {
            color: darkblue;
        }

        .button {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: lightblue;
            width: auto;
            border: 0;
            padding: 10px;
            color: black;
            font-size: 14px;
            cursor: auto;
        }

        .button:hover, .form button:active, .form button:focus {
            background: cornflowerblue;
        }

        .reset {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: indianred;
            width: auto;
            border: 0;
            padding: 10px;
            color: black;
            font-size: 14px;
            cursor: auto;
        }

        .reset:hover, .form button:active, .form button:focus {
            background: red;
        }
    </style>

    <script>
        function checkEmpty() {
            let nome = document.getElementById("idnome").value;
            let corso = document.getElementById("idstile").value;
            let fascia = document.getElementById("idfascia").value;
            let inizio = document.getElementById("idinizio").value;
            let fine = document.getElementById("idfine").value;
            let dilung = inizio.toString().length;
            let dflung = fine.toString().length;
            let costo = document.getElementById("idcosto").value;
            if (nome === "") {
                alert("Prego, inserire il nome del corso");
                return false;
            } else if (corso === "") {
                alert("Prego, inserire lo stile del corso");
                return false;
            } else if (fascia === "") {
                alert("Prego, inserire la fascia d'etá");
                return false;
            } else if (dilung === 0) {
                alert("Prego, inserire la data d'inizio");
                return false;
            } else if (dflung === 0) {
                alert("Prego, inserire la data di fine");
                return false;
            } else if (inizio >= fine) {
                alert("La data di inizio non puó essere antecedente o uguale a quella della fine");
                return false;
            } else if (costo === "") {
                alert("Prego, inserire il costo");
                return false;
            }
        }
    </script>

    <html lang="html">
    <head>
        <title>Pagina controllo pagamenti</title>
    </head>
    <body>


    <h3>Pagina per modificare un corso</h3>
    <div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
                    <td>Nome del corso:</td>
                    <td>
                        <div class="box">
                            <select name="corso" id="idcorso">
                                <?php while ($row = pg_fetch_row($result_corso)) { ?>
                                    <option><?php echo $row[0]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
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
                        <input type="date" name="finecorso" id="idfine" min="iniziocorso" max="2100-12-31">
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
                        <div class="box">
                            <select name="insegnante" id="idinsegnante">
                                <?php while ($row = pg_fetch_row($result_insegnante)) { ?>
                                    <option><?php echo $row[0]; ?></option>
                                <?php } ?>
                            </select>
                            <br>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <button type="submit" name="buttonAggiungi" onclick="checkEmpty()" class="button"> Esegui
                        </button>
                        <br><br>
                        <button type="reset" name="buttonReset" class="reset">Reset dei campi</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    </body>
    </html>

    <?php
    if (isset($_POST['buttonAggiungi'])) {
        $corsoSelezionato = $_POST['corso'];
        $nomeCorso = $_POST['nome'];
        $stile = $_POST['stile'];
        $fascia = $_POST['fascia'];
        $datainizio = $_POST['iniziocorso'];
        $datafine = $_POST['finecorso'];
        $costo = $_POST['costo'];
        $insegnante = $_POST['insegnante'];
        //echo $corsoSelezionato . " " . $nomeCorso . " " . $stile . " " . $datainizio . " " . $datafine . " " . $costo . " " . $insegnante;
        $drop = "ALTER TABLE frequenza_corso_persona DROP CONSTRAINT frequenza_corso_persona_nome_corso_fkey";
        pg_query($dbconn, $drop);
        $query = "UPDATE corso SET nome='$nomeCorso', stile='$stile', fascia_persone='$fascia', inizio='$datainizio', 
                  costoLezione='$costo', numeroinsegnante='$insegnante', fine='$datafine' WHERE nome='$corsoSelezionato' ";
        $foreign = "UPDATE frequenza_corso_persona SET nome_corso='$nomeCorso' WHERE nome_corso='$corsoSelezionato' ";
        /*$res = */
        pg_query($dbconn, $query);
        /*$resforeign =*/
        pg_query($dbconn, $foreign);
        $foreign_key="ALTER TABLE frequenza_corso_persona ADD CONSTRAINT frequenza_corso_persona_nome_corso_fkey FOREIGN KEY (nome_corso) REFERENCES corso";
        pg_query($dbconn, $foreign_key);
        echo '<script>';
        echo 'alert("Corso modificato con successo");';
        echo 'window.location = "modificacorso.php";';
        echo '</script>';
        pg_close($dbconn);
    }
}
?>