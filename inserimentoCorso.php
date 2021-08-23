<?php session_start();
error_reporting(0);
$bool = $_SESSION['emailsessione'] != "admin@admin.com";
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");';
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
        $query = "SELECT numero_sicurezza FROM insegnante";
        $result = pg_query($dbconn, $query);
    } ?>

    <script>
        function checkEmpty() {
            let nome = document.getElementById("inputnome").value;
            let corso = document.getElementById("inputstile").value;
            let fascia = document.getElementById("inputfascia").value;
            let inizio = document.getElementById("inputinizio").value;
            let fine = document.getElementById("inputfine").value;
            let dilung = inizio.toString().length;
            let dflung = fine.toString().length;
            let costo = document.getElementById("inputcosto").value;
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
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Pagina di inserimento corsi</title>
    </head>
    <body>

    <style>
        .box {
        }

        .box select {
            background-color: greenyellow;
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
            color: white;
            background: #76b852; /* fallback for old browsers */
            background: -webkit-linear-gradient(right, darkblue, darkslategrey);
            background: -moz-linear-gradient(right, darkblue, darkslategrey);
            background: -o-linear-gradient(right, darkblue, darkslategrey);
            background: linear-gradient(to left, darkblue, darkslategrey);
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h3 {
            color: yellowgreen;
        }

        .obbligatorio {
            border: solid red;
            border -radius: 4px;
        }

        .button {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: dodgerblue;
            width: auto;
            border: 0;
            padding: 10px;
            color: white;
            font-size: 14px;
            cursor: auto;
        }

        .button:hover, .form button:active, .form button:focus {
            background: blue;
        }

        .reset {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: indianred;
            width: auto;
            border: 0;
            padding: 10px;
            color: white;
            font-size: 14px;
            cursor: auto;
        }

        h4 {
            color: indianred;
        }
    </style>

    <center>
        <h3>Pagina di inserimento dei corsi</h3>

        <h4> Attenzione! I bordi contrassegnati in rosso sono per contrassegnare i campi che devono essere univoci
            all'interno del DataBase.</h4>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
                    <td>Nome:</td>
                    <td>
                        <input type="text" name="nome" id="inputnome" class="obbligatorio" placeholder="Nome del corso">
                    </td>
                </tr>

                <tr>
                    <td>Stile:</td>
                    <td>
                        <input type="text" name="stile" id="inputstile" placeholder="Stile del corso">
                    </td>
                </tr>
                <tr>
                    <td>Fascia d'etá:</td>
                    <td>
                        <input type="text" name="fascia" id="inputfascia" placeholder="Fascia d'etá degli iscritti">
                    </td>
                </tr>

                <tr>
                    <td>Data d'nizio:</td>
                    <td>
                        <input type="date" name="inizio" id="inputinizio">
                    </td>
                </tr>
                <tr>
                    <td>Data di fine:</td>
                    <td>
                        <input type="date" name="fine" id="inputfine">
                    </td>
                </tr>
                <tr>
                    <td>Numero di sicurezza del insegnante:</td>
                    <td>
                        <div class="box">
                            <select name="numeroinsegnante" id="idnumero">
                                <?php while ($row = pg_fetch_row($result)) { ?>
                                    <option><?php echo $row[0]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Costo di una lezione:</td>
                    <td>
                        <input type="text" name="costo" id="inputcosto" placeholder="Costo in euro">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="buttonAggiungi" class="button" onclick="return checkEmpty()">
                            Aggiungi corso
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="reset" name="buttonReset" class="reset">Reset dei campi</button>
                    </td>
                </tr>
            </table>
        </form>
    </center>
    </body>
    </html>


    <?php
    if (isset($_POST['buttonAggiungi'])) {
            $nome = $_POST['nome'];
            $stile = $_POST['stile'];
            $fascia = $_POST['fascia'];
            $inizio = $_POST['inizio'];
            $fine = $_POST['fine'];
            $numeroinsegnante = $_POST['numeroinsegnante'];
            $costo = (int)$_POST['costo'];
        //}
        $sql = "SELECT * from corso";
        $ret = pg_query($dbconn, $sql);
        if (!$ret) {
            echo pg_last_error($dbconn);
            exit;
        }
        static $attenzione = 0;
        while ($row = pg_fetch_row($ret))
            if ($row[0] == $nome)
                $attenzione = 2;
        if ($attenzione == 0) {
            $query = "INSERT INTO corso VALUES ('$nome', '$stile', '$fascia', '$inizio','$costo', '$numeroinsegnante', '$fine')";
            pg_query($dbconn, $query);
            echo '<script>';
            echo 'alert("Corso aggiunto con successo");';
            echo '</script>';
            echo '<br>';
        } else {
            echo '<script>';
            echo 'alert("Attenzione, il corso é giá presente nel DataBase.");';
            echo '</script>';
            echo '<br>';
        }
        pg_close($dbconn);
    }
} ?>











