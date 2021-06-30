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

    /*CSS per l'effetto della pagina aperta*/
    li a.active {
        background-color: blue;
        color: wheat;
    }

    /*CSS per l'effetto di quando passi sopra al titolo*/
    li a:hover:not(.active) {
        background-color: #555;
        color: white;
    }

    /*CSS per i campi obbligatori da inserire*/
    .input {
        border: 2px solid red;
        border-radius: 4px;
    }

    /*CSS per il bottone submit*/
    .submit {
        background-color: dodgerblue;
        border: blue;
        color: white;
        padding: 10px 10px;
        text-decoration: wheat;
        margin: 4px 2px;
    }

    /*CSS per il bottone reset*/
    .reset {
        background-color: red;
        border: #555555;
        color: black;
        padding: 10px 10px;

    }

</style>

<ul>
    <li><a href="PaginaLogin.html" class="active">Login</a></li>
    <li><a href="PaginaRegistrazione.html">Registrazione</a></li>
    <li><a href="Corsi.php">Corsi</a></li>
    <li><a href="#About">About</a></li>
</ul>

<center>
    <h4>Pagina di login</h4>
    <form action="login.php" method="post">
        <table>
            <tr>
                <td>E-Mail utente:</td>
                <td>
                    <input type="email" name="emailutente" id="inputemail" placeholder="Email" class="input">
                </td>
            </tr>

            <tr>
                <td>Password</td>
                <td>
                    <input type="password" name="password" id="inputpassword" placeholder="password" class="input">
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

            <td>
                Devi ancora iscriverti? <a href="PaginaRegistrazione.html">Registrati</a>
            </td>
        </table>
    </form>
</center>
<br>
Clicca <a href="home.php">qui</a> per tornare alla home
<br>
Esegui il <a href="logout.php">logout</a>
</body>
</html>