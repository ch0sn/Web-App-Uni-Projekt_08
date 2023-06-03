<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>BMFA-Startseite</title>
    <link rel="stylesheet" href="Startseite_Style.css">
    <link rel="stylesheet" href="../Grunddesign.css">
    <link rel="icon" type="image/x-icon" href="/Icons/40px_BM_Favicon.png">

    <?php
    include '../config.php';
    ?>

</head>
<body>
    <!-- Navbar-Sektion beginnt. -->
    <nav>
        <!-- Logo wird in Navbar hinzugefügt. -->
        <a  class="barTopLogo" href="Startseite.html"><img src="/Icons/thm_logo.svg" alt="THM Logo Icon" height=75> </a>

        <!-- Ungeordnete Listen-Layout Sektion -->
        <ul>
            <!-- 1. Listeneintrag "Kurse" in der ungeordneten Listenlayouts als "expandable_li_K" -->
                <li class="expandable_li_K">
                    <input type="checkbox" id="kurse_checkbox">
                    <label for="kurse_checkbox">Kurse <img src="/Icons/WhiteDownArrow.png" alt="whitearrowdown"/></label>
                    <!-- ungeordneten Listen-Layout als Dropdown für "Kurse" -->
                    <ul class="dropdown_K">
                        <li><a href="#">Kurs1</a></li>
                        <li><a href="#">Kurs2</a></li>
                        <li><a href="#">Kurs3</a></li>
                    </ul>
                </li>

                

            <!-- 2. Listeneintrag "Tools" in der ungeordneten Listenlayouts als "expandable_li_T" -->
                <li class="expandable_li_T">
                    <input type="checkbox" id="tools_checkbox">
                    <label for="tools_checkbox">Tools <img src="/Icons/WhiteDownArrow.png" alt="whitearrowdown"/></label>
                    <!-- ungeordneten Listen-Layout als Dropdown für "Tools" -->
                    <ul class="dropdown_T">
                        <li><a href="https://webmail.thm.de/rc/?_task=mail&_mbox=INBOX#" target="_blank">Webmail</a></li>
                        <li> <a href="https://www.thm.de/organizer/" target="_blank">Organizer</a></li>
                        <li> <a href="https://www.thm.de/zqe/unsere-aufgaben/meinungsportal.html" target="_blank">Feedback</a></li>
                        <li> <a href="https://www.thm.de/site/hochschule/service/infocenter-thm.html" target="_blank">Support</a></li>
                    </ul>
                </li>

            <!-- 3. Listeneintrag "Tools" in der ungeordneten Listenlayouts als "expandable_li_F" -->
                <li class="expandable_li_F">
                    <input type="checkbox" id="forum_checkbox">
                    <label for="forum_checkbox">Forum <img src="/Icons/WhiteDownArrow.png" alt="whitearrowdown"/></label>
                    <!-- ungeordneten Listen-Layout als Dropdown für "Forum" -->
                    <ul class="dropdown_F">
                        <li><a href="https://www.thm.de/site/hochschule/campus/aktuelles.html" target="_blank">News</a></li>
                        <li><a href="https://www.asta.thm.de/" target="_blank">ASTA</a></li>
                        <li><a href="#" target="_blank">Lerngruppe</a></li>
                    </ul>
                </li>

            <!-- 4. Listeneintrag "Suchfeld" -->
            <div class="searchBar">
                <label for="suche"></label><input type="search" id="suche" placeholder="Suchfeld">
                <button type="submit"> </button>
            </div>

            <!-- 5. Listeneintrag "Profilbereich" -->
            <li class="expandable_li_P">
                <label>Goethe, Johann Wolfgang</label>
                <img class= "profilePic" src="/Icons/32px_user_whitemode.png" alt="usericon_whitemode"/>
                <input type="checkbox" id="profile_checkbox">
                <label id="profileArrow" for="profile_checkbox" > <img src="/Icons/WhiteDownArrow.png" alt="whitearrowdown"/></label>
                <!-- ungeordneten Listen-Layout als Dropdown für "Profilbereich" -->
                <ul class="dropdown_P">
                    <li><a href="#" target="_blank">Profil</a></li>
                    <li><a href="#" target="_blank">Mitteilungen</a></li>
                    <li><a href="#" target="_blank">Einstellungen</a></li>
                    <li><a href="#" target="_blank">Abmelden</a></li>
                </ul>
            </li>

            <!-- 6. Listeneintrag "Darkmode-Symbol/Button" -->
            <div class="darkmode">
                <a href="#"> <img src="/Icons/16px_moon.png" alt="moon icon"/> </a>
            </div>
        </ul>
    </nav>

    <!-- linke Bar -->
    <div class="barLeft">
    </div>

    <!-- 1. Panel (Willkommen) -->
    <div class="willkommensblock">
        <br>
        <h1>Willkommen</h1>
        <br>
        <p id="willkommensText">Herzlichen Willkommen zu der "Besseres Moodle Für Alle" Website !</p>
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
        <button type="button" class="collapsible"><img src="/Icons/24px_filter.png" alt="filter"/></button>

        <!-- Filter-content for Collapsible -->
        <div class="filterContent">
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
            <img src="/Icons/bitcoin.svg" class="bitcoinLogo" alt="THM Logo Icon" height="32px" width="32px">
            <script>
                const button = document.querySelector('.bitcoinLogo');
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

