<?php

function emptyField($firstname,$lastname,$email,$username,$pwd,$pwdRepeat,$role){
    $result = false;
    if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat) || empty($role)){
        $result = true;
    }
    return $result;
}

function invalidUid($username) {
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    return $result;
}

function invalidEmail($email) {
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result = false;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    return $result;
}

function uidExists($conn, $username){
    $sql = "SELECT * FROM users WHERE usersUid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../pages/signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        return false;
    }

    mysqli_stmt_close($stmt);

}

function createUser($conn, $firstname, $lastname, $email, $username, $pwd, $role){
    $sql = "INSERT INTO users (usersFirstName, usersLastName, usersEmail, usersUid, usersPwd, usersRole) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss",$firstname, $lastname, $email, $username, $hashedPwd, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../pages/login.php");
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn,$username);

    if($uidExists === false){
        header("location: ../pages/login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd,$pwdHashed);

    if($checkPwd === false){
        header("location: ../pages/login.php?error=wrongpassword&uid=$username");
        exit();
    }
    else if($checkPwd === true){
    session_start();
        $sql = "SELECT usersID, usersFirstName, usersLastName, usersRole FROM users WHERE usersUid = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../pages/login.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

        if ($resultData->num_rows === 1) {
            // Fetch the first name, last name and role from the result
            $row = $resultData->fetch_assoc();
            $usersIdNr = $row['usersID'];
            $firstName = $row['usersFirstName'];
            $lastName = $row['usersLastName'];
            $role = $row['usersRole'];

            // Store the first name, last name, role and "logged in" status in the session
            $_SESSION['usersID'] =$usersIdNr;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['role'] = $role;
            $_SESSION['loggedin'] = $uidExists["usersUid"];

            include "includes/mainsite.inc.php";

            // Redirect the user to the mainsite after successful login
            header("Location: ../pages/mainsite.php");
            exit();
        }
        else{
            // Redirect the user to the index page when no successful login
            header("Location: ../index.php");
            exit();
        }
    }
}

function getUserId ($firstName, $lastName){
    global $conn;

    $sql = "SELECT usersID FROM users WHERE usersFirstName = ? AND usersLastName = ?";
    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt,"ss", $firstName, $lastName);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $usersId = $row["usersID"];

        return $usersId;
    }else{
        return null;
    }
    mysqli_close($stmt);
}

function createCourse($conn, $coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $coursepwd, $courseteacherid) {

    $sql = "INSERT INTO courses (coursesName, courseSubjectArea, courseSemesterNr, courseSeason, coursePwd, courseTeacher) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../pages/KursseiteEdit.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($coursepwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss",$coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $hashedPwd, $courseteacherid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    header("Location: ../pages/KursseiteEdit.php?courseCreated=successful&courseName=$coursename");
    exit();
}

function createCourseWOPwd($conn, $coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $courseteacherid) {

    $sql = "INSERT INTO courses (coursesName, courseSubjectArea, courseSemesterNr, courseSeason, courseTeacher) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss",$coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $courseteacherid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);



    header("Location: ../pages/KursseiteEdit.php?courseCreated=successful&courseid=$coursename");
    exit();
}

function checkCourses(){

}
