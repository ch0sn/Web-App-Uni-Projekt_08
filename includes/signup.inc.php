<?php

global $conn;
if (isset($_POST["submit"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];
    $role = $_POST["role"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyField($firstname,$lastname,$email,$username,$pwd,$pwdRepeat,$role) !== false){
        header("Location: ../pages/signup.php?error=emptyfield&firstname=$firstname&lastname=$lastname&uid=$username&email=$email&role=$role");
        exit();
    }
    if(invalidUid($username) !== false){
        header("Location: ../pages/signup.php?error=invalidUsername&firstname=$firstname&lastname=$lastname&email=$email&role=$role");
        exit();
    }
    if(invalidEmail($email) !== false){
        header("Location: ../pages/signup.php?error=invalidEmail&firstname=$firstname&lastname=$lastname&uid=$username&role=$role");
        exit();
    }
    if(pwdMatch($pwd, $pwdRepeat) !== false){
        header("Location: ../pages/signup.php?error=invalidPWMatch&firstname=$firstname&lastname=$lastname&uid=$username&email=$email&role=$role");
        exit();
    }
    if(uidExists($conn, $username) !== false){
        header("Location: ../pages/signup.php?error=usernameTaken&firstname=$firstname&lastname=$lastname&email=$email&role=$role");
        exit();
    }

    createUser($conn, $firstname, $lastname, $email, $username, $pwd, $role);

}
else {
    header("Location: ../pages/signup.php");
    exit();
}