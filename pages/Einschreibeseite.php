

    <title>Einsschreiben_MUSTER</title>
    <link rel="stylesheet" href="../css/Einschreibeseite.css">
    <link rel="stylesheet" href="../css/GrunddesignKursseiten.css">



    <div class="gridCoursesClass">


        <div class="BodyCourseClass">

            <h1 id="enrollmentOptionsId">Einschreibeoptionen</h1>
            <?php
            echo '<p id="courseNameBodyId">'. getCourseNameById($_GET['courseid']).'</p> ';
            echo '<p id="teacherNameId">'.getCourseTeacherName(getCourseTeacherByCourseId($_GET['courseid'])).'</p>';

            echo '<input type="password" id="loginKeyPanel"placeholder="Einschreibeschlüssel"/>';

            echo '<form action="../includes/enrollment.inc.php?userid='. $_SESSION["usersID"]. '&courseid=' . $_GET["courseid"] . '"' .'method="post" >
                <input type="submit" value="Einschreiben" id="enrollButtonId"/>
            </form>';

            echo '<a href="mainsite.php" id="cancelButtonId">Abbrechen</a>';
            ?>

        </div>

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