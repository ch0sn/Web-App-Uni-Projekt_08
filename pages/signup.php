<?php
include_once '../plainheader.php';
?>
<body>
<!-- Sign Up-spezifische Titel und Css-Verlinkung -->
<title>Sign Up</title>
<link rel="stylesheet" href="../css/SignUp_Style.css">


<div class="barLeft">
</div>

<section class="signup-box">
    <h1>Registrierung</h1>
    <form action="../includes/signup.inc.php" method="post">
        <!-- Logindateneingabe -->
        <?php
            if(isset($_GET['firstname'])){
                $first = $_GET['firstname'];
               echo " <input type='text'  name='firstname'  id='vorname' placeholder='Vorname...' value='$first'/> ";
            }
            else {
                echo " <input type='text'  name='firstname' id='vorname' placeholder='Vorname...'/> ";

            }

        if(isset($_GET['lastname'])){
            $last = $_GET['lastname'];
            echo " <input type='text'  name='lastname' placeholder='Nachname...' value='$last'/> ";
        }
        else {
            echo " <input type='text' name='lastname' placeholder='Nachname...' /> ";
        }

        if(isset($_GET['uid'])){
            $uid = $_GET['uid'];
            echo " <input type='text'  name='uid' placeholder='Benutzername...' value='$uid'/> ";
        }
        else {
            echo " <input type='text' name='uid' placeholder='Benutzername...' /> ";
        }

        if(isset($_GET['email'])){
            $email = $_GET['email'];
            echo " <input type='text' name='email' placeholder='THM-Email...' value='$email'/> ";
        }
        else {
            echo " <input type='text' name='email' placeholder='THM-Email...' /> ";
        }
        ?>

        <input type="password" name="pwd" placeholder="Passwort..." />
        <input type="password" name="pwdrepeat" placeholder="Passwort wiederholen..." />

        <?php
        if(isset($_GET['role'])){
            $role = $_GET['role'];
            if($role == "student") {
                echo "<input type='radio' name='role' id='role_student' value='student' checked/> ";
                echo '<label for="role_student">Student</label>';
                echo "<input type='radio' name='role' id='role_dozent' value='dozent'/> ";
                echo '<label for="role_dozent">Dozent</label>';
            }
            else if ($role == "dozent") {
                echo "<input type='radio' name='role' id='role_student' value='student'/> ";
                echo '<label for="role_student">Student</label>';
                echo "<input type='radio' name='role' id='role_dozent' value='dozent' checked/> ";
                echo '<label for="role_dozent">Dozent</label>';
            }
            else {
                echo "<input type='radio' name='role' id='role_student' value='student'/> ";
                echo '<label for="role_student">Student</label>';
                echo "<input type='radio' name='role' id='role_dozent' value='dozent'/> ";
                echo '<label for="role_dozent">Dozent</label>';
            }
        }
        else {
            echo "<input type='radio' name='role' id='role_student' value='student'/> ";
            echo '<label for="role_student">Student</label>';
            echo "<input type='radio' name='role' id='role_dozent' value='dozent'/> ";
            echo '<label for="role_dozent">Dozent</label>';
        }
        ?>

        <div>
        <button class="signup-Button" type="submit" name="submit" id="submit">Registrieren</button>
        </div>

        <div class="fehlerbenachrichtigung">
        <?php
        if (!isset($_GET['error'])){
        }
        else{
            $errorCheck =$_GET['error'];
            if($errorCheck == "emptyfield"){
                echo "<p class='error' style='color:red' >Fehler: Es wurden nicht alle Felder ausgefüllt!</p>";
            }
            else if($errorCheck == "invalidUsername"){
                echo "<p class='error' style='color:red'>Fehler: Es wurden nicht berechtigte Zeichen benutzt.</p> <i>Nutzen Sie nur das Alphabet und Zahlen.</i>";
            }
            else if($errorCheck == "invalidEmail"){
                echo "<p class='error' style='color:red'>Fehler: ungültige Email-Adresse!</p><i>Es muss mit \"@thm.de\" enden.</i>";
            }
            else if($errorCheck == "invalidPWMatch"){
                echo "<p class='error' style='color:red'>Fehler: Passwort stimmt nicht überein!</p><i>Bitte nochmal eingeben.</i>";
            }
            else if($errorCheck == "usernameTaken"){
                echo "<p class='error' style='color:red'>Fehler: Benutzername ist vergeben!</p>";
            }
        }
        ?>
        </div>

        <div id="abbrechenButtonDiv">
        <a href="../index.php" id="abbrechenButton">Abbrechen</a>
        </div>
    </form>
</section>



<footer id="footer">
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
