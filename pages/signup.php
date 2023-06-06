<?php
include_once '../plainheader.php';
?>
<!-- Sign Up-spezifische Titel und Css-Verlinkung -->
<title>Sign Up</title>
<link rel="stylesheet" href="../css/SignUp_Style.css">


<div class="barLeft">
</div>

<section class="signup-box">
    <h1>Registrierung</h1>
    <form action="../includes/signup.inc.php" method="post">
        <!-- Logindateneingabe -->
        <input type="text"  name="firstname" placeholder="Vorname..."/>
        <input type="text" name="lastname" placeholder="Nachname..." />
        <input type="text" name="email" placeholder="THM-Email..." />
        <input type="text" name="uid" placeholder="THM-Kennung..." />
        <input type="password" name="pwd" placeholder="Passwort..." />
        <input type="password" name="pwdrepeat" placeholder="Passwort wiederholen..." />
        <input type="radio" name="role" id="role_student" value="student"/>
        <label for="role_student">Student</label>
        <input type="radio" name="role" id="role_dozent" value="dozent"/>
        <label for="role_dozent">Dozent</label>

        <button class="signup-Button" type="submit" name="submit" id="submit">Registrieren</button>
    </form>

    <?php
    if (!isset($_GET['error'])){
    }
    else{
        $errorCheck =$_GET['error'];
        if($errorCheck == "emptyinput"){
            echo "<p class='error' style='color:red' >You did not fill in all fields!</p>";
        }
        else if($errorCheck == "invalidUsername"){
            echo "<p class='error' style='color:red'>Invalid characters in the username!</p>";
        }
        else if($errorCheck == "invalidEmail"){
            echo "<p class='error' style='color:red'>Invalid email!</p>";
        }
        else if($errorCheck == "invalidPWMatch"){
            echo "<p class='error' style='color:red'>Passwords don't match!</p>";
        }
        else if($errorCheck == "usernameTaken"){
            echo "<p class='error' style='color:red'>Username is already taken!</p>";
        }
    }
    ?>
</section>

    <a href="../index.php" id="abbrechenButton">Abbrechen</a>

<footer>
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
</footer>



</body>

</html>
