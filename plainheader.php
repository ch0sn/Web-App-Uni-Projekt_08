

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/Grunddesign.css">
    <link rel="icon" type="image/x-icon" href="img/40px_BM_Favicon.png">

</head>
<body>
<!-- Navbar-Sektion beginnt. -->
<nav>
    <!-- Logo wird in Navbar hinzugefügt. -->
    <?php
    $currentURL = $_SERVER['REQUEST_URI'];
    /* Standard Login und Sign-Up */
    if ($currentURL == '/Web-App-Uni-Projekt/pages/login.php' || $currentURL == '/Web-App-Uni-Projekt/pages/signup.php') {
        echo "<a class='barTopLogo' href='../index.php'><img src='../img/thm_logo.svg' alt='THM Logo Icon' height=75> </a>";
    }
    /* bei fehlgeschlagenen Login und/oder Sign-Up */
    else if ($currentURL == '/Web-App-Uni-Projekt/pages/login.php?error=emptyfield' || $currentURL == '/Web-App-Uni-Projekt/pages/login.php?error=wronglogin') {
        echo "<a class='barTopLogo' href='../index.php'><img src='../img/thm_logo.svg' alt='THM Logo Icon' height=75> </a>";
    }
    /* wenn man auf der Index-Seite schon ist */
    else if ($currentURL == '/Web-App-Uni-Projekt/index.php'){
        echo "<a class='barTopLogo' href='index.php'><img src='../img/thm_logo.svg' alt='THM Logo Icon' height=75> </a>";
    }else{
        echo "<a class='barTopLogo' href='../index.php'><img src='../img/thm_logo.svg' alt='THM Logo Icon' height=75> </a>";
    }

    ?>
</nav>