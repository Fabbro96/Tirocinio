<?php session_start();
?>
<html>
<head>
    <title>Pagina Admin</title>
</head>
<body>
<style>
    /*CSS per definire i blocchi di link accessibili*/
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

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

    h1 {
        font-family: "Roboto", sans-serif;
        font-size: 44px;
        align-content: center;
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
        -webkit-transition: all 0.3 ease;
        transition: all 0.3 ease;
        cursor: auto;
    }

    .button:hover, .form button:active, .form button:focus {
        background: blue;
    }
</style>
<?php
//QUI BISOGNA RE-INDIRIZZARE NEL CASO NON FOSSE ACCEDUTO COME ADMIN-->ATTENZIONE, VEDE NOME E COGNOME (ADMIN ADMIN)
$bool = ($_SESSION['emailsessione'] != "admin@admin.com");
if ($bool === true) {
    echo '<script type="text/javascript">';
    echo 'alert("HEI MA COSA CI FAI QUI? NON SEI ADMIN");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
} ?>

<ul>
    <li><a href="Home.php">Home</a></li>
    <li class="active"><a href="homeAdmin.php">Pannello Admin</a></li>
    <li><a href="listaUtenti.php">Visualizza tutti gli studenti</a></li>
    <li><a href="listaInsegnanti.php">Visualizza tutti gli insegnanti</a></li>
    <li><a href="logout.php">LOGOUT</a></li>
    <li><a href="#About">About</a></li>
</ul>
</body>
<br>
<h3>
    Cosa desideri fare? Scegli da una opzione indicata nella lista qui sotto!
</h3>
<form action="" method="post">
    <label for="idopzioni"></label>
    <select id="idopzioni" class="elenco">
        <option selected disabled>--SELEZIONA UNA OPZIONE--</option>
        <option value="registrazioneUtente.php">Registra uno studente</option>
        <option value="hapagato.php">Modifica lo stato del pagamento di un utente</option>
        <option value="inserimentoCorso.php">Inserisci un corso</option>
        <option value="inserimentoInsegnante.php">Registra un insegnante</option>
        <option value="listautenti.php">Visualizza lista di tutti gli utenti</option>
    </select>
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
                window.location = "hapagato.php";
                alert("Reindirizzamento in corso..");
            } else if (index === 3) {
                window.location = "inserimentoCorso.php";
                alert("Reindirizzamento in corso..");
            } else if (index === 4) {
                window.location = "inserimentoInsegnante.php";
                alert("Reindirizzamento in corso..");
            } else if (index === 5) {
                window.location = "listautenti.php";
                alert("Reindirizzamento in corso..");
            }
        }
    </script>
</html>