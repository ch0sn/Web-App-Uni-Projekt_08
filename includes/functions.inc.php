<?php

function emptyField($firstname, $lastname, $email, $username, $pwd, $pwdRepeat, $role)
{
    $result = false;
    if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat) || empty($role)) {
        $result = true;
    }
    return $result;
}

function invalidUid($username)
{
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    return $result;
}

function invalidEmail($email)
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat)
{
    $result = false;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    return $result;
}

function uidExists($conn, $username)
{
    $sql = "SELECT * FROM users WHERE usersUid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../pages/signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else{
        return false;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $firstname, $lastname, $email, $username, $pwd, $role)
{
    $sql = "INSERT INTO users (usersFirstName, usersLastName, usersEmail, usersUid, usersPwd, usersRole) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $email, $username, $hashedPwd, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: ../pages/login.php");
}

function loginUser($conn, $username, $pwd)
{
    $uidExists = uidExists($conn, $username);

    if ($uidExists === false) {
        header("location: ../pages/login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../pages/login.php?error=wrongpassword&uid=$username");
        exit();
    }
    else if($checkPwd === true){
    session_start();
        $sql = "SELECT usersID, usersFirstName, usersLastName, usersRole FROM users WHERE usersUid = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
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

            // Redirect the user to the mainsite after successful login
            header("Location: ../pages/mainsite.php");
            exit();
        } else {
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

    $sql = "INSERT INTO courses (coursesName, courseSubjectArea, courseSemesterNr, courseSeason, coursePwd, courseTeacher, courseContent) VALUES (?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../pages/KursseiteEdit.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($coursepwd, PASSWORD_DEFAULT);
    $courseEmptyContent = "[{}]";

    mysqli_stmt_bind_param($stmt, "sssssss",$coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $hashedPwd, $courseteacherid,$courseEmptyContent);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    header("Location: ../pages/KursseiteEdit.php?courseCreated=successful&courseName=$coursename");
    exit();
}

function createCourseWOPwd($conn, $coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $courseteacherid) {

    $sql = "INSERT INTO courses (coursesName, courseSubjectArea, courseSemesterNr, courseSeason, courseTeacher, courseContent) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    $courseEmptyContent = "[{}]";

    mysqli_stmt_bind_param($stmt, "ssssss",$coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $courseteacherid, $courseEmptyContent);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['courseID'] = getCourseID($conn,$coursename);
    $_SESSION['courseName'] = $coursename;

    header("Location: ../pages/KursseiteEdit.php?courseCreated=successful&courseid=" . $_SESSION['courseID']);
    exit();
}

function getCourseID($conn, $coursename)
{
    // SQL-Abfrage zum Abrufen des Kursinhalts
    $sql = "SELECT coursesId FROM courses WHERE coursesName = ?;";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Überprüfen, ob die SQL-Anweisung erfolgreich vorbereitet wurde
        // Falls nicht, kannst du hier entsprechenden Fehlercode hinzufügen oder eine geeignete Fehlerbehandlung durchführen
        return false;
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "s", $coursename);
    mysqli_stmt_execute($stmt);

    // Kursinhalt aus der Datenbank abrufen
    mysqli_stmt_bind_result($stmt, $coursesId);

    // Fetchen des Ergebnisses
    mysqli_stmt_fetch($stmt);

    // Schließen des Statements
    mysqli_stmt_close($stmt);

    // Kursinhalt zurückgeben
    return $coursesId;
}


function updateCourseContent($conn, $courseid, $contentArray)
{
    $courseid = $_SESSION['courseID'];

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
    $courseid = $_SESSION['courseID'];

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
    echo $courseContent;
}


/* function updateTeacherDataUpload($conn, $id, $idCourse, $dataName, $dataBlob)
{
    // SQL-Abfrage zum Aktualisieren der Tabelle
    $sql = "UPDATE tableName SET idCourse = ?, dataName = ?, dataBlob = ? WHERE id = ?;";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Überprüfen, ob die SQL-Anweisung erfolgreich vorbereitet wurde
        // Falls nicht, kannst du hier entsprechenden Fehlercode hinzufügen oder eine geeignete Fehlerbehandlung durchführen
        return false;
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "issb", $idCourse, $dataName, $dataBlob, $id);
    mysqli_stmt_send_long_data($stmt, 2, $dataBlob); // Übergeben des BLOB-Datentyps
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Erfolgreiches Update
    return true;
} */


function insertTeacherData($conn, $idCourse, $dataName, $base64Image)
{

    $idCourse = $_SESSION['courseID'];

    // Base64-Bild in einen Blob umwandeln
    $blobData = base64_decode($base64Image);

    // SQL-Abfrage zum Einfügen der Daten in die Tabelle
    $sql = "INSERT INTO coursesteacherdata (idCourse, dataName, dataBlob) VALUES (?, ?, ?)";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Fehlerbehandlung bei der Vorbereitung der SQL-Anweisung
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "iss", $idCourse, $dataName, $blobData);
    mysqli_stmt_execute($stmt);

    // Überprüfen, ob das Einfügen erfolgreich war
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Data inserted successfully";
    } else {
        echo "Failed to insert data";
    }

    // Statement schließen
    mysqli_stmt_close($stmt);
}


function getTeacherData($conn, $idCourse, $dataName)
{

    $idCourse = $_SESSION['courseID'];

    // SQL-Abfrage zum Abrufen des Kursinhalts
    $sql = "SELECT dataBlob FROM coursesteacherdata WHERE idCourse = ? AND dataName = ?;";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Fehlerbehandlung bei der Vorbereitung der SQL-Anweisung
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "is", $idCourse, $dataName);
    mysqli_stmt_execute($stmt);

    // Ergebnis abrufen
    $result = mysqli_stmt_get_result($stmt);

    // Überprüfen, ob ein Ergebnis vorhanden ist
    if (mysqli_num_rows($result) > 0) {
        // Blob-Daten aus dem Ergebnis abrufen
        $row = mysqli_fetch_assoc($result);
        $dataBlob = $row['dataBlob'];

        // Blob-Daten als Base64-codierten String senden
        echo 'data:image/png;base64,' . base64_encode($row['dataBlob']) . '';
    } else {

        $bindParamsString = var_export(array("is", $idCourse, $dataName), true);

        // Kein Ergebnis gefunden
        echo "No data found " . $idCourse . " " . $dataName . $bindParamsString;
    }

    // Statement schließen
    mysqli_stmt_close($stmt);
}


function getAllTeacherData($conn, $idCourse)
{

    $idCourse = $_SESSION['courseID'];

    // SQL-Abfrage zum Abrufen des Kursinhalts
    $sql = "SELECT dataBlob FROM coursesteacherdata WHERE idCourse = ?";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Fehlerbehandlung bei der Vorbereitung der SQL-Anweisung
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "i", $idCourse, $dataName);
    mysqli_stmt_execute($stmt);

    // Ergebnis abrufen
    $result = mysqli_stmt_get_result($stmt);

    // Überprüfen, ob ein Ergebnis vorhanden ist
    if (mysqli_num_rows($result) > 0) {
        // Blob-Daten aus dem Ergebnis abrufen
        $row = mysqli_fetch_assoc($result);
        $dataBlob = $row['dataBlob'];

        // Blob-Daten als Base64-codierten String senden
        echo 'data:image/png;base64,' . base64_encode($row['dataBlob']) . '';
    } else {

        $bindParamsString = var_export(array("is", $idCourse, $dataName), true);

        // Kein Ergebnis gefunden
        echo "No data found " . $idCourse . " " . $dataName . $bindParamsString;
    }

    // Statement schließen
    mysqli_stmt_close($stmt);
}


function getCourseNameById($conn, $id)
{

    $id = $_SESSION['courseID'];

    // SQL-Abfrage zum Abrufen des Kursnamens basierend auf der Kurs-ID
    $sql = "SELECT coursesName FROM courses WHERE id = ?;";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Überprüfen, ob die SQL-Anweisung erfolgreich vorbereitet wurde
        // Falls nicht, kannst du hier entsprechenden Fehlercode hinzufügen oder eine geeignete Fehlerbehandlung durchführen

        return false;
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Kursnamen aus der Datenbank abrufen
    mysqli_stmt_bind_result($stmt, $courseName);

    // Fetchen des Ergebnisses
    mysqli_stmt_fetch($stmt);

    // Schließen des Statements
    mysqli_stmt_close($stmt);

    // Kursnamen zurückgeben
    return $courseName;
}
