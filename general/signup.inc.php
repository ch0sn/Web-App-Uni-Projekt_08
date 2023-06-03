<?php

global $conn;
if (isset($_POST["submit"])){
    echo "It works";

    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.php';
    require_once 'functions_php.php';

    if (emptyInputSignUp($name,$email, $username,$pwd,$pwdRepeat) !== false) {
        header("location: Loginseite/signup.php?error=emptyInput");
        exit();
    }
    if (invalidUid($username) !== false) {
        header("location: Loginseite/signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: Loginseite/signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch( $pwd, $pwdRepeat) !== false) {
        header("location: Loginseite/signup.php?error=passwordsdontmatch");
        exit();
    }
    if (uidExists( $conn, $username, $email) !== false) {
        header("location: Loginseite/signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);

}
else {
    header("location: Loginseite/signup.php");
    exit();
}