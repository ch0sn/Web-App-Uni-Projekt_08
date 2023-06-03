global$conn; <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="SignUp_Style.css">
    <link rel="icon" type="image/x-icon" href="/Icons/40px_BM_Favicon.png">
</head>

<body>
    <!-- Navbar-Sektion beginnt. -->
    <nav>
        <!-- Logo wird in Navbar hinzugefügt. -->
        <a class="barTopLogo" href="Startseite.html"><img src="/Icons/thm_logo.svg" alt="THM Logo Icon" height=75> </a>

    </nav>

    <!-- linke Bar -->
    <div class="barLeft">
    </div>


    <section class="signup-form">

        <h1>Sign Up</h1>
        <form action="Loginseite/signup.php" method="post">
        <!-- Logindateneingabe -->
            <input type="text" name="name" placeholder="Name..." />
            <input type="text" name="email" placeholder="THM-Email..." />
            <input type="text" name="uid" placeholder="THM-Kennung..." />
            <input type="password" name="pwd" placeholder="Passwort..." />
            <input type="password" name="pwdrepeat" placeholder="Passwort wiederholen..." />
            <button class="signup-Button" type="submit" name="submit">Registrieren</button>
        </form>
    </section>

    <ul class="infoBar">

        <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

        <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

        <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

        <img src="/Icons/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

        <script>
            var button = document.querySelector('.bitcoinLogo');
            button.addEventListener('click', function () {
                document.documentElement.scrollTop = 0;
            });
        </script>

    </ul>
    </div>

</body>

</html>