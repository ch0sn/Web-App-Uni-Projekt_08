<?php

global $conn;
if (isset($_POST["submit"])) {
    if(empty($_POST["firstname"]) || empty($_POST["lastname"])
    || empty($_POST["email"]) || empty($_POST["uid"]) || empty($_POST["pwd"])
        || empty($_POST["pwdrepeat"]) ||empty($_POST["role"])) {
        header("Location: ../pages/signup.php?error=emptyinput");
        exit();
    }else{
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $username = $_POST["uid"];
        $pwd = $_POST["pwd"];
        $pwdRepeat = $_POST["pwdrepeat"];
        $role = $_POST["role"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if(invalidUid($username) !== false){
            header("Location: ../pages/signup.php?error=invalidUsername");
            exit();
        }
        if(invalidEmail($email) !== false){
            header("Location: ../pages/signup.php?error=invalidEmail");
            exit();
        }
        if(pwdMatch($pwd, $pwdRepeat) !== false){
            header("Location: ../pages/signup.php?error=invalidPWMatch");
            exit();
        }
        if(uidExists($conn, $username, $email) !== false){
            header("Location: ../pages/signup.php?error=usernameTaken");
            exit();
        }

        createUser($conn, $firstname, $lastname, $email, $username, $pwd, $role);

    }



}
else {
    header("Location: ../pages/signup.php");
    exit();
}