<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kursbereich</title>
    <link rel="stylesheet" href="Kursseite.css">
    <link rel="stylesheet" href="../Grunddesign.css">
    <link rel="stylesheet" href="../GrunddesignKursseiten.css">
    <link rel="icon" type="image/x-icon" href="/Icons/40px_BM_Favicon.png">

</head>

<body>

    <!-- Navbar-Sektion beginnt. -->
    <nav>
        <!-- Logo wird in Navbar hinzugefügt. -->
        <a class="barTopLogo" href="Startseite.html"><img src="/Icons/thm_logo.svg" alt="THM Logo Icon" height=75> </a>

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

    <div class="gridCoursesClass">

        <div class="HeaderCourseClass">

            <div class="abmeldeClass">
                <input type="checkbox" id="abmelde_Checkbox">
                <label for="abmelde_Checkbox"><img src="/Icons/64px_exit.png" alt="abmelden"/> </label>

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