<?php session_start();
?>
    <style>
        body {
            background: #76b852; /* fallback for old browsers */
            background: -webkit-linear-gradient(right, lightskyblue, lightblue);
            background: -moz-linear-gradient(right, lightskyblue, lightblue);
            background: -o-linear-gradient(right, lightskyblue, lightblue);
            background: linear-gradient(to left, lightskyblue, lightblue);
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .bottone {
            background-color: lightskyblue;
            border: yellow
            color: white;
            padding: 7px 7px;
            text-align: center;
            text-decoration: aliceblue;
            display: block;
            font-size: 15px;
            font-family: Arial, fantasy;
        }

        .bottone {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: dodgerblue;
            width: auto;
            border: 0;
            padding: 10px;
            color: white;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: auto;
        }

        .bottone:hover, .form button:active, .form button:focus {
            background: blue;
        }

        .radio {
            top: 0;
            left: 0;
            background: #c9ded6;
            border-radius: 50%;
        &::after {
             display: block;
             content: '';
             position: absolute;
             opacity: 0;
             border-radius: 50%;
             background: #fff;
         }
        }

    </style>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td>Nome:</td>
                <td>
                    <input type="text" name="nome_evento" id="inputnome">
                </td>
            </tr>

            <tr>
                <td>Data del evento:</td>
                <td>
                    <input type="date" name="dataevento" id="iddata" min="2021-09-31">
                </td>
            </tr>

            <tr>
                <td>Luogo:</td>
                <td>
                    <input type="text" name="luogo" id="inputluogo">
                </td>
            </tr>

            <tr>
                <td>Orario:</td>
                <td>
                    <input type="time" name="orario" id="inputorario">
                </td>
            </tr>
            <tr>
                <td>
                    <?php $tipo = "Shooting";
                    if (isset($_SESSION['nomesessione']) && isset($_SESSION['cognomesessione'])) { ?>
                        <div class="radiobutton">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
                                <label>
                                    <input type="radio" name="radio" value="shooting" class="radio"> Photo shooting
                                </label>
                                <label>
                                    <input type="radio" name="radio" value="privateEvent" class="radio"> Evento Privato
                                </label>
                            </form>
                        </div>
                        <?php
                    } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="btnEvento" onclick="return fun()" class="bottone"> Prenota
                </td>
            </tr>
            <script>
                function fun() {
                    let i = 0;
                    const rbs = document.querySelectorAll('input[name="radio"]');
                    let nome = document.getElementById("inputnome").value;
                    let data = document.getElementById("iddata").value;
                    let luogo = document.getElementById("inputluogo").value;
                    let orario = document.getElementById("inputorario").value;
                    let selectedValue;
                    if (nome === "") {
                        alert("Inserisci il nome");
                        return false;
                    }
                    if (data === "") {
                        alert("Inserisci la data");
                        return false;
                    }
                    if (luogo === "") {
                        alert("Inserisci il luogo");
                        return false;
                    }
                    if (orario === "") {
                        alert("Inserisci l'orario");
                        return false;
                    }
                    <?php if (isset($_SESSION['nomesessione']) && isset($_SESSION['cognomesessione'])) { ?>
                    for (const rb of rbs) {
                        if (rb.checked) {
                            i++;
                            selectedValue = rb.value;
                            break;
                        }
                    }
                    if (i === 0) {
                        alert("Scegli una opzione");
                        return false;
                    }<?php }?>
                }
            </script>
        </table>
    </form>

<?php
if (isset($_SESSION['emailsessione']))
    $email_persona = $_SESSION['emailsessione'];
else
    $email_persona = 'ospite';

if (isset($_POST['btnEvento'])) {
    error_reporting(0);
    $host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
    $database = 'd53jiomn4btlbs';
    $user = 'vnnfvmmusrzflv';
    $psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
    $dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
    if (!$dbconn) {
        echo pg_last_error($dbconn);
        echo "Connessione NON effettuata";
    } else {
        $nome = $_POST['nome_evento'];
        $dataevento = date('Y-m-d', strtotime($_POST['dataevento']));
        $luogo = $_POST['luogo'];
        $orario = $_POST['orario'];
    }
    $attenzione = 0; //Uso questa variabile per gestire diversi tipi di errori
    if ($nome == "" || $dataevento == "" || $luogo == "" || $orario == "")
        $attenzione = 1;
    $query_duplicati = "SELECT data,nome  FROM evento";
    $risultato = pg_query($dbconn, $query_duplicati);
    while ($row = pg_fetch_row($risultato)) {
        if ($row[0] === $dataevento || $row[1] === $nome)
            $attenzione = 2;
    }
    if ($attenzione == 0) {
        $query = "INSERT INTO evento(data,nome,luogo,orario,tipo,email_persona) VALUES ('$dataevento','$nome','$luogo','$orario','$tipo','$email_persona')";
        $res = pg_query($dbconn, $query);
        echo '<script>';
        echo 'alert("Evento prenotato con successo!");';
        echo '</script>';

    } else if ($attenzione == 2) {
        echo '<script type="text/javascript">';
        echo 'alert("Data e/o nome giá presente nel DataBase . Ti preghiamo di utilizzarne una/o diversa/o");';
        echo '</script>';
    }
    pg_close($dbconn);
}
?>