<?php
     include 'plainheader.php';
?>
<!-- Index-spezifische Titel und Css-Verlinkung -->
<link rel="stylesheet" href="css/index_Style.css">
<title>Willkommen</title>


<div class="barLeft">
</div>

<section class="choices">

    <h1>Willkommen</h1>

    <p>Das ist die "Besseres Moodle Für Alle" Seite! <br>
    Registrieren Sie sich oder falls Sie schon ein Account haben, melden Sie sie sich gerne an!</p>

    <a href="pages/login.php"><b>Anmelden</b></a>

    <a href="pages/signup.php"><b>Registrieren</b></a>



</section>



<ul class="infoBar">

    <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

    <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

    <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

    <img src="img/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

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
