<?php
include_once '../plainheader.php';
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
                echo "<input type='text' class='username_tf' name='uid' placeholder='THM Kennung' value='$uid' />";
            }else {
                echo '<input type="text" class="username_tf" name="uid" placeholder="THM Kennung" />';
            }
            ?>
        </div>



        <div class="passwort">
            <!-- <b id= "passwortText">Passwort: </b> -->
            <input type="password" class="password_tf" name="pwd" placeholder="Passwort" />
        </div>


        <!-- Weiterleitung, falls Passwort vergessen. -->

        <a href="https://www.thm.de/its/campusnetz/benutzerkonto/passwort-vergessen.html"
           style="color:blue; margin-top:50px" target="_blank">Passwort vergessen</a>

        <input type="submit" name="submit" value="Anmelden" />

        <?php
        if (!isset($_GET['error'])){
        }
        else{
            $errorCheck = $_GET['error'];
            if($errorCheck == "emptyfield"){
                echo "<p class='error' style='color:red' >You did not fill in all necessary fields!</p>";
            }
            else if($errorCheck == "wronglogin"){
                echo "<p class='error' style='color:red'>Username does not exist!</p>";
            }
            else if($errorCheck == "wrongpassword"){
                echo "<p class='error' style='color:red'>Password wrong!</p>";
            }
        }
        ?>

    </form>
</div>

<a href="../index.php" id="abbrechenButton">Abbrechen</a>


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
