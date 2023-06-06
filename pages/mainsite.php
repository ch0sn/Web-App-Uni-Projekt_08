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
    <h1>    Willkommen <?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'];?></h1>
    <br>
    <p id="willkommensText">zu der "Besseres Moodle Für Alle" Website !</p>
</div>

<!-- 2. Panel (Schwarzes Brett) -->
<div class="schwarzesbrett">
    <br>
    <h1>Schwarzes Brett</h1>
    <br>
    <ul>
        <li>Meldung des Tages</li>
        <br>
        <br>
        <br>
        <li>Aktuelle Termine</li>
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

    <ul>
        <li>FB 01: B - Bauwesen (Gi)</li>
        <br>
        <li>FB 02: EI - Elektro- und Informationstechnik</li>
        <br>
        <li>FB 03: ME - Maschinenbau und Energietechnik (Gi)</li>
        <br>
        <li>FB 04: LSE - Life Science Engineering (Gi)</li>
        <br>
        <li>FB 05: GES - Gesundheit</li>
        <br>
        <li>FB 06: MNI - Mathematik, Naturwissenschaften und Informatik (Gi)</li>
        <br>
        <li>FB 07: W - Wirtschaft (Gi)</li>
        <br>
        <li>FB 11: IEM - Informationstechnik - Elektrotechnik - Mechatronik (Fb)</li>
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




<script>
    /* Ausfahr-Effekt der FilterArea. */
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight){
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
</script>


</body>
</html>

