<?php session_start();

$bool = ($_SESSION['emailsessione'] != "admin@admin.com");
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
} else {
    ?>
    <html lang="html">
    <head>
        <title>Pagina Admin</title>
    </head>
    <body>
    <style>
        .box {
        }

        .box select {
            background-color: darkblue;
            color: white;
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
            background: #76b852; /* fallback for old browsers */
            background: -webkit-linear-gradient(right, #77ee77, greenyellow);
            background: -moz-linear-gradient(right, #77ee77, greenyellow);
            background: -o-linear-gradient(right, #77ee77, greenyellow);
            background: linear-gradient(to left, #77ee77, greenyellow);
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
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

        /*CSS per il bottone submit*/
        .button {
            background-color: lightskyblue;
            border: yellow
            color: white;
            padding: 7px 7px;
            text-align: center;
            text-decoration: aliceblue;
            display: block;
            font-size: 15px;
            font-family: "Roboto", sans-serif;
        }

        .button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: dodgerblue;
            width: 80px;
            border: 0;
            padding: 10px;
            color: white;
            font-size: 14px;
            cursor: auto;
        }

        .button:hover, .form button:active, .form button:focus {
            background: blue;
        }

        h1 {
            font-family: "Roboto", sans-serif;
            font-size: 44px;
            align-content: center;
        }
    </style>

    <ul>
        <li class="active"><a href="homeAdmin.php">Pannello Admin</a></li>
        <li><a href="listaUtenti.php">Visualizza tutti gli studenti</a></li>
        <li><a href="listaInsegnanti.php">Visualizza tutti gli insegnanti</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
    </ul>
    </body>
    <br>
    <h3>
        Cosa desideri fare? Scegli da una opzione indicata nella lista qui sotto!
    </h3>
    <form action="" method="post">
        <label for="idopzioni"></label>
        <div class="box">
            <select id="idopzioni" class="elenco">
                <option selected disabled>--SELEZIONA UNA OPZIONE--</option>
                <option value="registrazioneUtente.php">Registra uno studente</option>
                <option value="pagamentoMese.php">Modifica lo stato del pagamento di un utente</option>
                <option value="inserimentoCorso.php">Inserisci un corso</option>
                <option value="disiscriviutentedacorso.php">Disiscrivi un utente da un corso</option>
                <option value="inserimentoInsegnante.php">Registra un insegnante</option>
                <option value="frequenzaCorsoPersona.php">Iscrivi un utente ad un corso</option>
                <option value="modificacorso.php">Modifica un corso</option>
            </select>
        </div>
        <br>
        <button class="button" type="submit" onclick="myFun()" id="buttonclick"> Esegui</button>
        <script>
            //Creo una variabile booleano a cui passo il valore in PHP di bool (é un ospite o é un utente con giá una sessione aperta?)
            var booleano = "<?php echo $bool; ?>";

            // When a click
            function myFun() {
                let selectElem = document.getElementById('idopzioni')
                var index = selectElem.selectedIndex;
                if (index === 0)
                    alert("Prego di selezionare una opzione")
                else if (index === 1) {
                    window.location = "registrazioneUtente.php";
                    alert("Reindirizzamento in corso..");
                } else if (index === 2) {
                    window.location = "pagamentoMese.php";
                    alert("Reindirizzamento in corso..");
                } else if (index === 3) {
                    window.location = "inserimentoCorso.php";
                    alert("Reindirizzamento in corso..");
                } else if (index === 4) {
                    window.location = "disiscriviutentedacorso.php";
                    alert("Reindirizzamento in corso..");
                } else if (index === 5) {
                    window.location = "inserimentoInsegnante.php";
                    alert("Reindirizzamento in corso..");
                } else if (index === 6) {
                    window.location = "frequenzaCorsoPersona.php";
                    alert("Reindirizzamento in corso..");
                } else if (index === 7) {
                    window.location = "modificacorso.php";
                    alert("Reindirizzamento in corso..");
                }
            }
        </script>
    </html>
<?php } ?>