<?php
include '../plainheader.php';
?>
<!-- Login-spezifische Titel und Css-Verlinkung -->
<title>Login</title>
<link rel="stylesheet" href="../css/Login_Style.css">


<!-- linke Bar -->
<div class="barLeft">
</div>


<div class="login">

    <h1>Anmelden</h1>
    <form action="../includes/login.inc.php" method="post">
        <!-- Logindateneingabe -->
        <div class="username">
            <!-- <b id= "kennungText">THM-Kennung: </b> -->

            <?php
            if (isset($_GET['uid'])){
                $uid = $_GET['uid'];
                echo "<input type='text' class='username_tf' name='uid' placeholder='Benutzername' value='$uid' />";
            }else {
                echo '<input type="text" class="username_tf" name="uid" placeholder="Benutzername" />';
            }
            ?>
        </div>



        <div class="passwort">
            <!-- <b id= "passwortText">Passwort: </b> -->
            <input type="password" class="password_tf" name="pwd" placeholder="Passwort" />
        </div>


        <!-- Weiterleitung, falls Passwort vergessen. -->
        <div id="forgotPW">
        <a href="https://www.thm.de/its/campusnetz/benutzerkonto/passwort-vergessen.html"
           target="_blank" id="forgotPW">Passwort vergessen</a>
        </div>

        <div>
        <input type="submit" name="submit" id="anmelde_btn" value="Anmelden" />
        </div>

        <div id="errorMessages">
        <?php
        if (!isset($_GET['error'])){
        }
        else{
            $errorCheck = $_GET['error'];
            if($errorCheck == "emptyfield"){
                echo "<p class='error' style='color:red' >Fehler: Es wurden nicht alle Felder ausgefüllt!</p>";
            }
            else if($errorCheck == "wronglogin"){
                echo "<p class='error' style='color:red'>Fehler: Benutzername existiert nicht!</p>";
            }
            else if($errorCheck == "wrongpassword"){
                echo "<p class='error' style='color:red'>Fehler: Passwort ist falsch!</p>";
            }
        }
        ?>
        </div>

        <div id="cancelButtonDiv">
        <a href="../index.php" id="abbrechenButton">Abbrechen</a>
        </div>
    </form>
</div>




<ul class="infoBar">

    <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

    <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

    <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

    <img src="../img/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

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
