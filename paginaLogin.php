<?php
session_start();
error_reporting(0); ?>
<script>
    function checkEmpty() {
        var email = document.getElementById("inputemail").value;
        var psw = document.getElementById("inputpassword").value;

        if (email == "") {
            alert("Prego, inserire la mail");
            return false;
        } else if (psw == "") {
            alert("Prego, inserire il password");
            return false;
        }
    }
</script>

<!DOCTYPE html>
<html>
<head>
    <title>Pagina di login</title>
</head>
<body>
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

    /*CSS per definire i blocchi di link accessibili*/
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    li {
        height: 25px;
        float: left;
        margin-right: 0px;
        border-right: 1px solid blue;
        padding: 0 20px;
    }

    li:last-child {
        border-right: none;
    }

    li a {
        text-decoration: none;
        color: darkblue;
        font: 25px/1 "Roboto", sans-serif;
        text-transform: uppercase;
        -webkit-transition: all 0.5s ease;
    }

    li a:hover {
        color: darkslategrey;
    }

    li.active a {
        font-weight: bold;
        color: darkred;
    }

    /*CSS per i campi obbligatori da inserire*/
    .input {
        border: 2px solid red;
        border-radius: 4px;
    }

    .input:hover {
        background-color: whitesmoke;
    }

    /*CSS per il bottone submit*/
    .submit {
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

    .submit {
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

    .submit:hover, .form button:active, .form button:focus {
        background: blue;
    }

    /*CSS per il bottone reset*/
    .reset:hover, .form button:active, .form button:focus {
        background: red;
    }

    .reset {
        background-color: orangered;
        color: black;
        padding: 10px 10px;

        font-family: "Roboto", sans-serif;
        text-transform: uppercase;
        outline: 0;
        width: auto;
        border: 0;
        font-size: 13px;
        -webkit-transition: all 0.3 ease;
        transition: all 0.3 ease;
        cursor: auto;

    }

    .returnToHome {
        width: 50%;
        text-align: left;
        text-decoration: underline;
        color: green;
        /*font-size: 0.75rem;*/
        font-family: "Roboto", sans-serif;
    }

</style>

<center>
    <ul>
        <li><a href="PaginaLogin.html" class="active">Login</a></li>
        <li><a href="PaginaRegistrazione.html">Registrazione</a></li>
        <li><a href="visualizzaCorsi.php">Corsi</a></li>
        <li><a href="#About">About</a></li>
    </ul>
    <br><br>

    <h1>Pagina di login</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td style="font-weight: bold">E-Mail utente:</td>
                <td>
                    <input type="email" name="emailutente" id="inputemail" placeholder="Email" class="input">
                </td>
            </tr>

            <tr>
                <td style="font-weight: bold">Password</td>
                <td>
                    <input type="password" name="password" id="inputpassword" placeholder="Password" class="input">
                </td>
            </tr>

            <a href="login.php">
                <tr>
                    <td>
                        <button type="submit" name="buttonLogin" class="submit" onclick="return checkEmpty()">
                            Esegui il login
                        </button>
                    </td>
                </tr>
            </a>

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
if (isset($_POST['buttonLogin'])) {
    $host = 'ec2-54-229-68-88.eu-west-1.compute.amazonaws.com';
    $database = 'd53jiomn4btlbs';
    $user = 'vnnfvmmusrzflv';
    $psw = 'a04bab57975e88eaf632c96187a3d1a415dad0d352939a3f3e0503a649c49ec2';
    $dbconn = pg_connect("host=$host dbname=$database user=$user password=$psw") or die("Connessione non disponibile");
    if (!$dbconn)
        echo "Connessione NON effettuata";
    else {
        $email = $_POST['emailutente'];
        $password = $_POST['password'];
    }
    $sql = <<<EOF
          SELECT * from PersonaIscritta;
EOF;
    $ret = pg_query($dbconn, $sql);
    if (!$ret) {
        echo pg_last_error($dbconn);
        exit;
    }
    static $i = 0;
    //Filtro tutte le mail e le password presenti nel DB, appena ne trovo due di uguali restituisco una stringa concatenata al nome e cognome
    while ($row = pg_fetch_row($ret))
        if ($row[2] == strtolower($email) && $row[5] == $password) {
            //Passo la variabile chiamata emailsessione alla sessione dandogli in pasto il parametro della seconda colonna del DataBase
            $_SESSION["emailsessione"] = $row[2];
            //Passo anche nome e cognome nella sessione
            $_SESSION["nomesessione"] = $row[0];
            $_SESSION["cognomesessione"] = $row[1];
            $nomeutente = $row[0];
            $i = $i + 1;
            $query = "SELECT hapagato FROM personaiscritta WHERE '$email'=email";
            $res = pg_query($dbconn, $query);
            if ($_SESSION["emailsessione"] === "admin@admin.com")
                echo '<script> window.location = "homeAdmin.php" </script>';
            ?>
            <br>
            <?php
            //Leggo il pagamento
            while ($pagamento = pg_fetch_row($res))
                //Il pagamento é stato effettuato? É in posizione 0 perché é l'unico parametro letto
                if ($pagamento[0] === 'no')
                    echo "ATTENZIONE, PAGAMENTO SCADUTO. SI PREGA DI PAGARE IL PRIMA POSSIBILE.";
            ?>
            <br><br><br>
            Salve, <?php echo $nomeutente ?>. <a href="logout.php">Per eseguire il logout clicca qui</a>
            <?php
        }
    if ($i == 0) {
        echo '<script>';
        echo 'alert("Password o E-Mail errata. Nel caso non fossi registrato, registrati.");';
        echo '</script>';
        echo '<br>';

    }
    pg_close($dbconn);

} ?>
