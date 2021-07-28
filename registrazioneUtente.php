<?php session_start(); ?>
    <script>
        function checkEmpty() {
            var cknome = document.getElementById("inputnome").value;
            var ckcognome = document.getElementById("inputcognome").value;
            var ckemail = document.getElementById("inputemail").value;
            var ckpassword = document.getElementById("inputpassword").value;
            var ckrepassword = document.getElementById("inputrepassword").value;
            var cknumerotel = document.getElementById("inputnumerotelefono").value;
            const concatenate = ckpassword == ckrepassword;

            if (cknome == "") {
                alert("Prego, inserire il nome");
                return false;
            } else if (ckcognome == "") {
                alert("Prego, inserire il cognome");
                return false;
            } else if (ckemail == "") {
                alert("Prego, inserire la mail");
                return false;
            } else if (cknumerotel == "") {
                alert("Prego, inserire il numero di telefono");
                return false;
            } else if (ckpassword == "") {
                alert("Prego, inserire il password");
                return false;
            } else if (ckrepassword == "") {
                alert("Prego, inserire la conferma della password");
                return false;
            } else if (!concatenate) {
                alert("Le password non corrispondono");
                return false;
            }
        }
    </script>
<?php
//QUI BISOGNA RE-INDIRIZZARE NEL CASO NON FOSSE ACCEDUTO COME ADMIN-->ATTENZIONE, VEDE NOME E COGNOME (ADMIN ADMIN)
$bool = $_SESSION['emailsessione'] != "admin@admin.com";
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
} ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF - 8">
        <title>Pagina di registrazione</title>
    </head>
    <body>

    <style>
        /*CSS per definire i blocchi di link accessibili*/
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: black;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: wheat;
            text-align: center;
            padding: 14px 16px;
            text-decoration: aquamarine;
        }

        /*CSS per l'effetto della pagina aperta */
        li a . active {
            background -color: blue;
            color: wheat;
        }

        /*CSS per l'effetto di quando passi sopra al titolo*/
        li a:hover:not(.active) {
            background -color: #555;
            color: white;
        }

        .obbligatorio {
            border: solid red;
            border -radius: 4px;
        }

        /*CSS per il bottone submit*/
        .submit {
            background -color: darkblue;
            border: blue;
            color: white;
            padding: 10px 10px;
            margin: 4px 2px;
        }


        /*CSS per il bottone reset*/
        .reset {
            background -color: red;
            border: #555555;
            color: black;
            padding: 10px 10px;
        }

        h4 {
            color: red;
        }
    </style>

    <ul>
        <li><a href="PaginaLogin . php"> Login</a></li>
        <li><a href="PaginaRegistrazione . html" class="active"> Registrazione</a></li>
        <li><a href="visualizzaCorsi . php"> Corsi</a></li>
        <li><a href="#About"> About</a></li>
    </ul>

    <center>
        <h3> Benvenuti nella pagina di registrazione </h3>
        <h4> Attenzione!I bordi contrassegnati in rosso sono per contrassegnare i campi che devono essere univoci
            all'interno del DataBase.</h4>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
                    <td>Nome:</td>
                    <td>
                        <input type="text" name="nome" id="inputnome">
                    </td>
                </tr>

                <tr>
                    <td>Cognome:</td>
                    <td>
                        <input type="text" name="cognome" id="inputcognome">
                    </td>
                </tr>

                <tr>
                    <td>Data di Nascita:</td>
                    <td>
                        <input type="date" name="datadinascita" min="1920-01-01" max="2010-12-31">

                    </td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="email" name="email" id="inputemail" class="obbligatorio">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="prefissi">Scegli il prefisso:</label>
                    </td>
                    <td>
                        <select name=prefissi id="prefissi">
                            <option selected disabled>--SELEZIONA IL PREFISSO--</option>
                            <option value="+1">+1 USA/Canada</option>
                            <option value="+30">+30 Grecia</option>
                            <option value="+31">+31 Paesi Bassi</option>
                            <option value="+32">+32 Belgio</option>
                            <option value="+33">+33 Francia</option>
                            <option value="+34">+34 Spagna</option>
                            <option value="+350">+350 Gibilterra</option>
                            <option value="+351">+351 Portogallo</option>
                            <option value="+352">+352 Lussemburgo</option>
                            <option value="+353">+353 Irlanda</option>
                            <option value="+354">+354 Islanda</option>
                            <option value="+355">+355 Albania</option>
                            <option value="+356">+356 Malta</option>
                            <option value="+357">+357 Cipro</option>
                            <option value="+358">+358 Finlandia</option>
                            <option value="+359">+359 Bulgaria</option>
                            <option value="+36">+36 Ungheria</option>
                            <option value="+34">+34 Spagna</option>
                            <option value="+370">+370 Lituania</option>
                            <option value="+371">+371 Lettonia</option>
                            <option value="+372">+372 Estonia</option>
                            <option value="+373">+373 Moldavia</option>
                            <option value="+374">+374 Armenia</option>
                            <option value="+375">+375 Bielorussia</option>
                            <option value="+376">+376 Andorra</option>
                            <option value="+377">+377 Principato di Monaco</option>
                            <option value="+378">+378 San Marino</option>
                            <option value="+380">+380 Ucraina</option>
                            <option value="+381">+381 Serbia</option>
                            <option value="+382">+382 Montenegro</option>
                            <option value="+383">+383 Kosovo</option>
                            <option value="+385">+385 Croazia</option>
                            <option value="+386">+386 Slovenia</option>
                            <option value="+387">+387 Bosnia ed Erzegovina</option>
                            <option value="+389">+389 Macedonia del Nord</option>
                            <option value="+39">+39 Italia</option>
                            <option value="+40">+40 Romania</option>
                            <option value="+41">+41 Svizzera</option>
                            <option value="+420">+420 Repubblica Ceca</option>
                            <option value="+421">+421 Slovacchia</option>
                            <option value="+423">+423 Liechtenstein</option>
                            <option value="+43">+43 Austria</option>
                            <option value="+44">+44 Regno Unito</option>
                            <option value="+45">+45 Danimarca</option>
                            <option value="+46">+46 Svezia</option>
                            <option value="+47">+47 Norvegia</option>
                            <option value="+48">+48 Polonia</option>
                            <option value="+49">+49 Germania</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Numero di telefono:</td>
                    <td>
                        <input type="tel" name="numerotelefono" id="inputnumerotelefono">
                    </td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" id="inputpassword">
                    </td>
                </tr>

                <tr>
                    <td>Ridigitare la password</td>
                    <td>
                        <input type="password" name="repassword" id="inputrepassword">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="buttonRegistrazione" onclick="return checkEmpty()" class="submit">
                            Registra utente
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="reset" name="buttonReset" class="reset">Reset dei campi</button>
                    </td>
                </tr>
                <td>
                    Sei giá registrato? <a href="PaginaLogin.php">Esegui il login</a>
                </td>
            </table>
        </form>
    </center>
    </body>
    </html>

<?php
if (isset($_POST['buttonRegistrazione'])) {
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
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = strtolower($_POST['email']);
        $datanascita = date('Y-m-d', strtotime($_POST['datadinascita']));
        $numerotelefono = $_POST['prefissi'] . $_POST['numerotelefono'];
        $password = $_POST['password'];
        $repsw = $_POST['repassword'];
        $v = $password == $repsw;
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
    if ($nome == "" || $cognome == "" || $email == "" || $numerotelefono == "" || $password == "" || !$v)
        $attenzione = 1;
    while ($row = pg_fetch_row($ret))
        if ($row[0] == $email)
            $attenzione = 2;
    if ($attenzione == 0) {
        $query = "INSERT INTO personaiscritta(nome,cognome,email,numero_telefono,datanascita,password) VALUES ('$nome','$cognome','$email','$numerotelefono','$datanascita','$password')";
        $res = pg_query($dbconn, $query);
        echo '<script>';
        echo 'alert("Grazie per la sua registrazione!Ora potrá effettuare il login tramite email e password");';
        echo '</script>';

    } else if ($attenzione == 2) {
        echo '<script type="text/javascript">';
        echo 'alert("Attenzione, l\'email inserita é giá presente nel DataBase . Ti preghiamo di utilizzarne una diversa");';
        echo '</script>';
    }
    pg_close($dbconn);
} ?>