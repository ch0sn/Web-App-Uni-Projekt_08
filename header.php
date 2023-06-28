<?php
session_start();
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/Header_Nav_Style.css">
    <link rel="stylesheet" href="../css/Grunddesign.css">
    <link rel="icon" type="image/x-icon" href="../img/40px_BM_Favicon.png">

</head>
<body>
<!-- Navbar-Sektion beginnt. -->
<nav>
    <!-- Logo wird in Navbar hinzugefügt. -->
    <a  class="barTopLogo" href="../pages/mainsite.php"><img src="../img/thm_logo.svg" alt="THM Logo Icon" height=75> </a>


    <!-- Ungeordnete Listen-Layout Sektion -->
    <ul>
        <!-- 1. Listeneintrag "Kurse" in der ungeordneten Listenlayouts als "expandable_li_K" -->
        <li class="expandable_li_K">
            <input type="checkbox" id="kurse_checkbox">
            <label for="kurse_checkbox">Kurse <img src="../img/WhiteDownArrow.png" alt="whitearrowdown"/></label>
            <!-- ungeordneten Listen-Layout als Dropdown für "Kurse" -->
            <ul class="dropdown_K">
                <?php
                if(isset($_SESSION["role"]) && $_SESSION['role'] == "dozent") {
                    echo '<li><a href="../pages/KursseiteEdit.php">Kurs erstellen</a></li>';
                }
                ?>
            </ul>
          </li>

          <!-- 2. Listeneintrag "Tools" in der ungeordneten Listenlayouts als "expandable_li_T" -->
        <li class="expandable_li_T">
            <input type="checkbox" id="tools_checkbox">
            <label for="tools_checkbox">Tools <img src="../img/WhiteDownArrow.png" alt="whitearrowdown"/></label>
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
            <label for="forum_checkbox">Forum <img src="../img/WhiteDownArrow.png" alt="whitearrowdown"/></label>
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
            <button type="submit" id="searchButton"> </button>
        </div>

        <!-- 5. Listeneintrag "Profilbereich" -->
        <li class="expandable_li_P">
            <label><?php echo $_SESSION["firstName"].",".$_SESSION["lastName"];?></label>
            <img class= "profilePic" src="../img/32px_user_whitemode.png" alt="usericon_whitemode"/>
            <input type="checkbox" id="profile_checkbox">
            <label id="profileArrow" for="profile_checkbox" > <img src="../img/WhiteDownArrow.png" alt="whitearrowdown"/></label>
            <!-- ungeordneten Listen-Layout als Dropdown für "Profilbereich" -->
            <ul class="dropdown_P">
                <li><a href="#" target="_blank">Profil</a></li>
                <li><a href="#" target="_blank">Mitteilungen</a></li>
                <li><a href="#" target="_blank">Einstellungen</a></li>
                <li><a href="../includes/logout.inc.php">Abmelden</a></li>
            </ul>
        </li>

        <!-- 6. Listeneintrag "Darkmode-Symbol/Button" -->
        <div class="darkmode">
            <a href="#"> <img src="../img/16px_moon.png" alt="moon icon"/> </a>
            </div>
        </ul>
    </nav>

