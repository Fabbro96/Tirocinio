<?php
error_reporting(0);
session_start();
if ($_SESSION['emailsessione'] != 'admin@admin.com') {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");' . $_SESSION['emailsessione'];
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
        $query = "SELECT nome_corso, email_persona FROM frequenza_corso_persona";
        $result = pg_query($dbconn, $query);
    }
    $sql = "SELECT * from corso";
    $ret = pg_query($dbconn, $sql);
    if (!$ret) {
        echo pg_last_error($dbconn);
        exit;
    }
} ?>
<style>
    .box {
    }

    .box select {
        background-color: grey;
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
        background: -webkit-linear-gradient(right, navajowhite, darkgrey);
        background: -moz-linear-gradient(right, navajowhite, darkgrey);
        background: -o-linear-gradient(right, navajowhite, darkgrey);
        background: linear-gradient(to left, navajowhite, darkgrey);
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
        background: orange;
        width: auto;
        border: 0;
        padding: 10px;
        color: black;
        font-size: 14px;
        cursor: auto;
    }

    .button:hover, .form button:active, .form button:focus {
        background: darkorange;
    }

</style>

<h3>Pagina disiscrizione corsi</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
    <div class="box">
        <select name="personecorso" id="idpersonecorso">
            <?php while ($row = pg_fetch_row($result)) {
                ?>
                <option><?php echo $row[0] . ";" . $row[1]; ?></option>
            <?php } ?>
        </select>
    </div>
    <br>
    <input type="submit" name="esegui" onclick="fun()" class="button">

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['personecorso'];
    $temp = explode(";", $name);
    $nomeCorso = $temp[0];
    $emailPersona = $temp[1];
    $query = "DELETE FROM frequenza_corso_persona WHERE (nome_corso='$nomeCorso' AND email_persona='$emailPersona')";
    echo '<script>';
    echo 'alert("Persona disiscritta con successo")';
    echo '</script>';
    pg_query($dbconn, $query);
    echo '<script>';
    echo 'window.location = "disiscriviutentedacorso.php";';
    echo '</script>';
}
?>
