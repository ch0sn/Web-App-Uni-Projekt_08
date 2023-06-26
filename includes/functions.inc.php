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
        $result = false;
        return $result;
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
        $sql = "SELECT usersFirstName, usersLastName FROM users WHERE usersUid = ?";
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
            $firstName = $row['usersFirstName'];
            $lastName = $row['usersLastName'];
            $role = $row['usersRole'];

            // Store the first name, last name, role and "logged in" status in the session
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['role'] = $role;
            $_SESSION['loggedin'] = $uidExists["usersUid"];

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

function updateCourseContent($conn, $courseid, $contentArray)
{
    
    
    // Das Array wird in einen JSON-String konvertiert
    $jsonContent = json_encode($contentArray);

    // SQL-Abfrage zum Aktualisieren des Kurses
    $sql = "UPDATE courses SET courseContent = ? WHERE coursesId = ?;";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Überprüfen, ob die SQL-Anweisung erfolgreich vorbereitet wurde
        // Falls nicht, kannst du hier entsprechenden Fehlercode hinzufügen oder eine geeignete Fehlerbehandlung durchführen

        

        return false;
        
    }
    
    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "si", $jsonContent, $courseid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Erfolgreiches Update
    return true;
}

function getCourseContent($conn, $courseid)
{
    // SQL-Abfrage zum Abrufen des Kursinhalts
    $sql = "SELECT courseContent FROM courses WHERE coursesId = ?;";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Überprüfen, ob die SQL-Anweisung erfolgreich vorbereitet wurde
        // Falls nicht, kannst du hier entsprechenden Fehlercode hinzufügen oder eine geeignete Fehlerbehandlung durchführen

        return false;
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "i", $courseid);
    mysqli_stmt_execute($stmt);

    // Kursinhalt aus der Datenbank abrufen
    mysqli_stmt_bind_result($stmt, $courseContent);

    // Fetchen des Ergebnisses
    mysqli_stmt_fetch($stmt);

    // Schließen des Statements
    mysqli_stmt_close($stmt);

    // Kursinhalt zurückgeben
    return $courseContent;
}