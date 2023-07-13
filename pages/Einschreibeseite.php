

    <title>Einsschreiben_MUSTER</title>
    <link rel="stylesheet" href="../css/Einschreibeseite.css">
    <link rel="stylesheet" href="../css/GrunddesignKursseiten.css">


    <div class="BodyCourseClass">
        <h1 id="enrollmentOptionsId">Einschreibeschlüsseleingabe</h1>
        <?php
       // echo '<p id="courseNameBodyId">'. getCourseNameById($_GET['courseid']).'</p> ';
       // echo '<p id="teacherNameId">'.getCourseTeacherName(getCourseTeacherByCourseId($_GET['courseid'])).'</p>';

        echo '<form action="../includes/enrollment.inc.php?userid='. $_SESSION["usersID"]. '&courseid=' . $_GET["courseid"] . '"' .'method="post" >
              <div><input type="password" name="loginKeyPanel" id="loginKeyPanel" placeholder="Einschreibeschlüssel"/></div>';

        if (!isset($_GET['pwkey'])){
        }
        else{
            $enrolled = $_GET['pwkey'];
            if($enrolled== "false"){
                echo '<p id="errorMsg">Geben Sie den Einschreibeschlüssel an.</p>';
            }
        }

        echo '<div id="enrollButtonDiv"><input type="submit" value="Einschreiben" id="enrollButtonId"/></div>
              </form>';

        echo '<div id="cancelButtonDiv2"><a href="mainsite.php" id="cancelButtonId">Abbrechen</a></div>';

        ?>
    </div>
    
    <ul class="infoBar">

        <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>

        <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>

        <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>

        <img src="/img/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">

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