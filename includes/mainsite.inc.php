<?php

if(!isset($_SESSION['loggedin'])){
    header("Location: ../index.php");
    exit();
}
header("Location: ../pages/mainsite.php");
