<?php session_start();
?>
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
                                    <input type="radio" name="radio" value="shooting"> Photo shooting
                                </label>
                                <label>
                                    <input type="radio" name="radio" value="privateEvent"> Evento Privato
                                </label>
                            </form>
                        </div>
                        <script>
                            function fun() {
                                const rbs = document.querySelectorAll('input[name="radio"]');
                                let selectedValue;
                                for (const rb of rbs) {
                                    if (rb.checked) {
                                        selectedValue = rb.value;
                                        break;
                                    }
                                }
                            }
                        </script>
                        <?php
                        $tipo = $_POST['radio'];
                    } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="btnEvento" onclick="return checkEmpty()" class="submit"> Prenota
                </td>
            </tr>
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
    $sql = <<<EOF
      SELECT email from PersonaIscritta;
EOF;

    $ret = pg_query($dbconn, $sql);
    if (!$ret) {
        echo pg_last_error($dbconn);
        exit;
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