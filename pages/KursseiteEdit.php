<?php
    include "../header.php";

?>
<title>Kurssseite bearbeiten</title>
<link rel="stylesheet" href="../css/KurssseiteEdit.css">
<link rel="stylesheet" href="../css/GrunddesignKursseiten.css">


<!-- linke Bar -->
<div class="barLeft">
</div>

<div class="gridCoursesClass">

    <div class="HeaderCourseClass">
            

    </div>

    <div class="BodyCourseClass">


    </div>

</div>

<div class='popup-form'>
    <h1>Kurserstellung</h1>
    <!-- Kursname-Eingabefeld -->
    <input type='text' id="course_name" placeholder="Kursname eingeben"/>
    <!-- Fachbereich-Auswahl -->
    <select id="course_subjectarea" name="course_subjectarea">
        <option selected="selected">Alle Fachbereiche</option>
        <option value="B">B (01)</option>
        <option value="EI">EI (02)</option>
        <option value="ME">ME (03)</option>
        <option value="LSE">LSE (04)</option>
        <option value="GES">GES (05)</option>
        <option value="MNI">MNI (06)</option>
        <option value="MND">MND (13)</option>
    </select>
    <!-- Semester-Auswahl, wo der Kurs angeboten wird -->
    <select id="course_semesternumber" name="course_semesternumber">
        <option selected="selected">Alle Semester</option>
        <option value="1">1.Semester</option>
        <option value="2">2.Semester</option>
        <option value="3">3.Semester</option>
        <option value="4">4.Semester</option>
        <option value="5">5.Semester</option>
    </select>
    <!-- Semesterzeit-Auswahl -->
    <div class="rg_course_semestertime">
    <input type="radio" id="winter" name="course_semestertime" value="winter"><label for="winter">Wintersemester</label>
    <input type="radio" id="summer" name="course_semestertime" value="summer"><label for="summer">Sommersemester</label>
    </div>
    <!-- Einschreibeschlüssel-Eingabe -->
    <input type="password" id="course_pwd" placeholder="(optional) Einschreibeschlüssel eingeben">
    <!-- Einschreibeschlüssel-Eingabe -->
    <button type="submit" id="course_completion_btn">Erstellen</button>

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