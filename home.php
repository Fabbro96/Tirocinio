<?php session_start();
?>
<html>
<head>
    <title>Benvenuto nella home</title>
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

    .box {
    }

    .box select {
        background-color: darkred;
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

    h1 {
        font-family: "Roboto", sans-serif;
        font-size: 44px;
        align-content: center;
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
</style>


<ul>
    <li class="active"><a href="home.php">Home</a></li>
    <li><a href="paginaLogin.php">Login</a></li>
    <li><a href="logout.php">Logout</a></li>
    <li><a href="#About">About</a></li>
</ul>
</body>
<br>
<h1>Benvenuto nella home, <?php
    //Se é un ospite $bool = true
    $bool = !isset($_SESSION['nomesessione']) || !isset($_SESSION['cognomesessione']);
    $_SESSION['ospite'] = $bool;
    if ($bool === true) {
        $nome = "ospite";
        $cognome = " ";
    } else {
        $nome = $_SESSION['nomesessione'];
        $cognome = $_SESSION['cognomesessione'];
    }
    echo $nome . " " . $cognome; ?>
</h1>
<h3>
    <?php echo " Cosa desideri fare? Scegli da una opzione indicata nella lista qui sotto!"; ?>
</h3>
<form action="" method="post">
    <label for="idopzioni"></label>
    <div class="box">
        <select id="idopzioni" class="elenco">
            <option selected disabled>--SELEZIONA UNA OPZIONE--</option>
            <option value="listaCorsiIscritto">Visualizza la lista dei corsi ai quali sei iscritto</option>
            <option value="eventi">Prenota uno evento</option>
        </select>
    </div>
    <br>
    <br>
    <button class="button" type="submit" onclick="checkSelectedIndex()" id="button"> Esegui</button>
    <script>
        //Creo una variabile booleano a cui passo il valore in PHP di bool (é un ospite o é un utente con giá una sessione aperta?)
        booleano = "<?php echo $bool; ?>";
        let selectElem = document.getElementById('idopzioni')
        let bottone = document.getElementById('button')
        // When a click
        bottone.addEventListener('click', function (event) {
            var index = selectElem.selectedIndex;
            if (index === 0)
                alert("Prego di selezionare una opzione")
            else if (index === 1) {
                window.location = "visualizzaCorsiUtenti.php";
                alert("Reindirizzamento in corso..");
            }
            else if (index === 2) {
                window.location = "evento.php";
                alert("Reindirizzamento in corso..");
            } else {
                //Se ospite
                if (booleano)
                    alert("Prego di effettuare il login o la registrazione. Gli eventi privati sono accessibili solo agli utenti registrati.");
                else
                    alert("Accesso al evento in corso");
            }
        })
    </script>
</html>