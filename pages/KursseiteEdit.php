<?php
    include "../header.php";
?>
<title>Kurssseite bearbeiten</title>
<link rel="stylesheet" href="../css/KurssseiteEdit.css">
<link rel="stylesheet" href="../css/GrunddesignKursseiten.css">

<script>document.addEventListener("DOMContentLoaded", function() {
  // Disable all clickable elements on the page except for the popup form
  var elementsToDisable = document.querySelectorAll(
    "a, li, label, textarea, button, input, img"
  );

  for (var i = 0; i < elementsToDisable.length; i++) {
    if (!elementsToDisable[i].closest(".popup-form")) {
      elementsToDisable[i].setAttribute("disabled", "disabled");
      elementsToDisable[i].classList.add("blur-effect");
    }
  }

  // Enable the website and remove the blur effect when the button is clicked
  document.getElementById("course_completion_btn").addEventListener("click", function() {
    // Remove the disabled attribute from the elements
    for (var i = 0; i < elementsToDisable.length; i++) {
      elementsToDisable[i].removeAttribute("disabled");
        elementsToDisable[i].classList.remove("blur-effect");
    }
    // Hide the popup form

      var popupForm = document.querySelector(".popup-form");
      popupForm.style.visibility = 'hidden';
      popupForm.style.pointerEvents = 'none';
  });
});</script>


<!-- linke Bar -->
<div class="barLeft">
</div>

<div class="gridCoursesClass">

    <div class="HeaderCourseClass">
            

    </div>

    <div class="BodyCourseClass">


    </div>

</div>

<form class='popup-form' action="../includes/courseEdit.inc.php" method="post" >
    <h1>Kurserstellung</h1>
    <!-- Kursname-Eingabefeld -->
    <input type='text' id="course_name" name="course_name" placeholder="Kursname eingeben"/>
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

    <button id="course_completion_cancel_btn"><a href="../pages/mainsite.php">Abbrechen</a></button>

</form>
    
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