<?php
if(!isset($_SESSION['loggedin'])){
    include_once '../header.php';
}else{
    header("Location: index.php");
    exit();
}
?>

    <title>Kursbereich</title>
    <link rel="stylesheet" href="../css/Kursseite.css">
    <link rel="stylesheet" href="../css/GrunddesignKursseiten.css">

    <!-- linke Bar -->
    <div class="barLeft">
    </div>

    <div class="gridCoursesClass">

        <div class="HeaderCourseClass">

            <div class="abmeldeClass">
                <input type="checkbox" id="abmelde_Checkbox">
                <label for="abmelde_Checkbox"><img src="/img/64px_exit.png" alt="abmelden"/> </label>

            </div>

            <h1 id="courseNameHeaderId">WK_1100 Einführung in die Wirtschaftsinfromatik SoSe23</h1>



            <p id= "coursePathId">Startseite
                / Kurse / Bachelor-Studiengang / Wirtschaftsinfromatik /
                1. Semester / Einführung in dieWirtschaftsinfromatik / Einschreiben</p>



        </div>

        <div class="BodyCourseClass">


        </div>

    </div>

</div>
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