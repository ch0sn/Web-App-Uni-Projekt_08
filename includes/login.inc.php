<?php

global $conn;
if (isset($_POST["submit"])) {
    if(empty($_POST["uid"]) || empty($_POST["pwd"])) {
        header("Location: ../pages/login.php?error=emptyinput");
        exit();
    }else{
        $username = $_POST["uid"];
        $pwd = $_POST["pwd"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        loginUser($conn,$username,$pwd);
    }



}
else {
    header("Location: ../pages/login.php");
    exit();
}