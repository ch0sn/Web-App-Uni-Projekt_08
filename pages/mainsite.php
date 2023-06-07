<?php
if(!isset($_SESSION['loggedin'])){
    include_once '../header.php';
}else{
    header("Location: index.php");
    exit();
}
?>

<!-- Main-Seite spezifischer Titel und Einstellungen -->
<title>BMFA-Startseite</title>
<link rel="stylesheet" href="../css/MainSite_Style.css">

<!-- linke Bar -->
<div class="barLeft">
</div>



<!-- 1. Panel (Willkommen) -->
<div class="willkommensblock">
    <br>
    <h1>Willkommen <?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'];?></h1>
    <br>
    <p id="willkommensText">zu der "Besseres Moodle Für Alle" Website !</p>
</div>

<!-- 2. Panel (Schwarzes Brett) -->
<div class="blackboard">

    <h1>Schwarzes Brett</h1>
    <ul class="blackboard_content">
        <button type="button" name="notd" class="newsOfTheDay_collapsible">Meldung des Tages</button>
        <ul class="notd_content">
            <li><a href="#">Wartung kommenden Montag, den 07.Juni!</a></li>
        </ul>
        <button type="button" name="ue" class="upcomingEvents_collapsible">Aktuelle Termine</button>
            <ul class="ue_content">
                <li><p>[Projekt-Abgabe] WebTech-Abgabe: 16.Juli.2023</p></li>
            </ul>
    </ul>
</div>

<!-- 3. Panel (Kursbereich) -->
<div class="kursbereich">
    <br>
    <h1>Kursbereiche</h1>
    <!-- Collapsible button -->
    <button type="button" class="collapsible"><img src="../img/24px_filter.png" alt="filter"/></button>

    <!-- Filter-content for Collapsible -->
    <div class='filterContent'>
        <ul>
            <form>
                <li><input type="checkbox" id="enrolled">Angemeldet</input></li>
                <li><input type="radio" id="winter" name="semesterTime" value="winter"><label for="winter">Wintersemester</label></li>
                <li><input type="radio" id="summer" name="semesterTime" value="summer"><label for="summer">Sommersemester</label></li>
                <li><select id="semesternumber" name="semesternumber">
                        <option value selected="selected">Alle Semester</option>
                        <option value="#">1.Semester</option>
                        <option value="#">2.Semester</option>
                        <option value="#">3.Semester</option>
                        <option value="#">4.Semester</option>
                        <option value="#">5.Semester</option>
                    </select></li>
                <li><select id="fachbereich" name="fachbereich">
                        <option value selected="selected">Alle Fachbereiche</option>
                        <option value="#">B (01)</option>
                        <option value="#">EI (02)</option>
                        <option value="#">ME (03)</option>
                        <option value="#">LSE (04)</option>
                        <option value="#">GES (05)</option>
                        <option value="#">MNI (06)</option>
                        <option value="#">W (07)</option>
                        <option value="#">IEM (11)</option>
                    </select></li>
            </form>
        </ul>
    </div>

    <ul class="alleKurse">
        <button type="button" name="fb01" class="fb01Collapsible">FB 01: B - Bauwesen (Gi)</button>
        <div class='fb01_content'>
            <ul>
                <li><a href="#">Bachelor</a></li>
                <li><a href="#">Master</a></li>
            </ul>
        </div>

        <button type="button" name="fb02" class="fb02Collapsible">FB 02: EI - Elektro- und Informationstechnik</button>
        <form class="fb02_content">
            <ul>
                <li><a href="#">Bachelor</a></li>
                    <li><a href="#">Master</a></li>
            </ul>
        </form>

        <button type="button" name="fb03" class="fb03Collapsible">FB 03: ME - Maschinenbau und Energietechnik (Gi)</button>
        <div class='fb03_content'>
            <ul>
                <li><a href="#">Bachelor</a></li>
                <li><a href="#">Master</a></li>
            </ul>
        </div>

        <button type="button" name="fb04" class="fb04Collapsible">FB 04: LSE - Life Science Engineering (Gi)</button>
        <div class='fb04_content'>
            <form >
                <ul>
                    <li><a href="#">Bachelor</a></li>
                    <li><a href="#">Master</a></li>
                </ul>
            </form>
        </div>

        <button type="button" name="fb05" class="fb05Collapsible">FB 05: GES - Gesundheit</button>
        <div class='fb05_content'>
            <form >
                <ul>
                    <li><a href="#">Bachelor</a></li>
                    <li><a href="#">Master</a></li>
                </ul>
            </form>
        </div>

        <button type="button" name="fb06" class="fb06Collapsible">FB 06: MNI - Mathematik, Naturwissenschaften und Informatik (Gi)</button>
        <div class='fb06_content'>
            <form >
                <ul>
                    <li><a href="#">Bachelor</a></li>
                    <li><a href="#">Master</a></li>
                </ul>
            </form>
        </div>

        <button type="button" name="fb13" class="fb13Collapsible">FB 13: Mathematik, Naturwissenschaften und Datenverarbeitung (Fb)</button>
        <div class='fb13_content'>
            <form >
                <ul>
                    <li><a href="#">Bachelor</a></li>
                    <li><a href="#">Master</a></li>
                </ul>
            </form>
        </div>

    </ul>
</div>


<!-- untere Bar -->
<div>
    <ul class="infoBar">
        <li><a href="https://www.thm.de/site/impressum.html" target="_blank">Impressum</a></li>
        <li><a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Hilfe</a></li>
        <li><a href="https://www.thm.de/datenschutz/" target="_blank">Datenschutz</a></li>
        <img src="../img/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">
        <script>
            const button = document.querySelector(".bitcoinLogo");
            button.addEventListener('click', function () {
                document.documentElement.scrollTop = 0;
            });
        </script>
    </ul>
</div>


</body>
<script src="../js/mainsite_scripts.js"></script>
</html>

