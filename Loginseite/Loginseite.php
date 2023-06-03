<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="Loginseite_Style.css">
    <link rel="stylesheet" href="../Grunddesign.css">
    <link rel="icon" type="image/x-icon" href="/Icons/40px_BM_Favicon.png">
</head>

<body>

<?php

session_start();
$_SESSION['loggedin'] = false;
/* include '../config.php'; */

echo $_SESSION['loggedin'] 
?>
    
    <!-- Navbar-Sektion beginnt. -->
    <nav>
        <!-- Logo wird in Navbar hinzugefügt. -->
        <a class="barTopLogo" href="Startseite.html"><img src="/Icons/thm_logo.svg" alt="THM Logo Icon" height=75> </a>

    </nav>

    <!-- linke Bar -->
    <div class="barLeft">
    </div>


    <div class="login">




        <form method="POST" action="login.php">


            <h1>Willkommen zur Loginseite der BMFA!</h1>

            <!-- Logindateneingabe -->
            <div class="username">
                <!-- <b id= "kennungText">THM-Kennung: </b> -->
                <input type="text" class="username_tf" name="username" id= "username" placeholder="THM Kennung" />
            </div>



            <div class="password">
                <!-- <b id= "passwortText">Passwort: </b> -->
                <input type="password" class="password_tf" name="password" id= "password" required placeholder="Passwort" />
            </div>

            <!-- Weiterleitung, falls Passwort vergessen. -->
            <div>
                <a href="https://www.thm.de/its/campusnetz/benutzerkonto/passwort-vergessen.html" class="forgot_passwort" style="color:blue;" target="_blank">Passwort vergessen
                </a>
            </div>


            <input type="submit" value="Anmelden" />

        </form>







    </div>
    <ul class="infoBar">

        <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

        <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

        <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

        <img src="/Icons/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

        <script>
            var button = document.querySelector('.bitcoinLogo');
            button.addEventListener('click', function() {
                document.documentElement.scrollTop = 0;
            });
        </script>

    </ul>
    </div>

</body>

</html>