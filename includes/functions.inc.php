<?php
include_once "dbh.inc.php";

/*
 *
 */

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
    } else {
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
    } else if ($checkPwd === true) {
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

            $row = $resultData->fetch_assoc();
            $usersIdNr = $row['usersID'];
            $firstName = $row['usersFirstName'];
            $lastName = $row['usersLastName'];
            $role = $row['usersRole'];


            $_SESSION['usersID'] = $usersIdNr;

            $_SESSION['usersID'] =$usersIdNr;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['role'] = $role;
            $_SESSION['loggedin'] = $uidExists["usersUid"];



            header("Location: ../pages/mainsite.php");
            exit();
        } else {


            header("Location: ../index.php");
            exit();
        }
    }
}

function getUserId($firstName, $lastName)
{
    global $conn;

    $sql = "SELECT usersID FROM users WHERE usersFirstName = ? AND usersLastName = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $firstName, $lastName);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $usersId = $row["usersID"];

        return $usersId;
    } else {
        return null;
    }
    mysqli_close($stmt);
}

function createCourse($coursename, $coursesubjectarea, $coursesemesternr, $coursesemesterseason, $coursePassword, $courseteacherid)
{
    global $conn;
    $sql = "INSERT INTO courses (coursesName, courseSubjectArea, courseSemesterNr, courseSeason, coursePwd, courseTeacher, courseContent) VALUES (?,?,?,?,?,?,?);";
    $stmt = mysqli_prepare($conn, $sql);
    $courseEmptyContent = "[]";

    if (!$stmt) {
        header("Location: ../pages/KursseiteEdit.php?error=stmtfailed");
        exit();
    }
    if ($coursePassword == "") {
        mysqli_stmt_bind_param($stmt, "ssissis", $coursename, $coursesubjectarea, $coursesemesternr, $coursesemesterseason, $coursePassword, $courseteacherid, $courseEmptyContent);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $hashedPwd = password_hash($coursePassword, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssissis", $coursename, $coursesubjectarea, $coursesemesternr, $coursesemesterseason, $hashedPwd, $courseteacherid, $courseEmptyContent);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
        $_SESSION['courseID'] = getCourseID($conn, $coursename);
        $_SESSION['courseName'] = $coursename;
        $_SESSION['courseSubjectArea'] = $coursesubjectarea;
        $_SESSION['courseSemester'] = $coursesemesternr;
        $_SESSION['courseSemesterSeason'] = $coursesemesterseason;
        $_SESSION['courseTeacher'] = getCourseTeacherName($courseteacherid);

        enrollToNewCourses($conn, $courseteacherid, $_SESSION['courseID']);

        header("Location: ../pages/KursseiteEdit.php?courseid=" . $_SESSION['courseID'] . "&enrolled=yes");
        exit();
}

function enrollToNewCourses($conn, $userId, $courseId){

    $sql = "INSERT INTO enrollment (usersId ,coursesId) VALUES(?,?)";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $userId, $courseId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getCourseTeacherName($courseteacherid) {
    global $conn;

    $sql = "SELECT usersFirstName, usersLastName FROM users u, courses c WHERE u.usersID = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $courseteacherid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $courseTeacherFirstName, $courseTeacherLastName);

    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    return $courseTeacherFirstName . ", " . $courseTeacherLastName;
}

function getCourseTeacherByCourseId($courseid){
    global $conn;

    // SQL-Abfrage zum Abrufen des Kursinhalts
    $sql = "SELECT courseTeacher FROM courses WHERE coursesId = ?;";

    // Vorbereiten der SQL-Anweisung
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    // Parameter an die SQL-Anweisung binden und die Anweisung ausführen
    mysqli_stmt_bind_param($stmt, "i", $courseid);
    mysqli_stmt_execute($stmt);

    // Kursinhalt aus der Datenbank abrufen
    mysqli_stmt_bind_result($stmt, $courseTeacherID);

    // Fetchen des Ergebnisses
    mysqli_stmt_fetch($stmt);


    mysqli_stmt_close($stmt);

    return $courseTeacherID;
}

function getCourseID($conn, $coursename){

    $sql = "SELECT coursesId FROM courses WHERE coursesName = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $coursename);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $coursesId);

    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    return $coursesId;
}

function showEnrolledCourses($userId)
{
    global $conn;

    $sql = "SELECT c.coursesName, c.coursesId
            FROM enrollment e
            INNER JOIN courses c ON e.coursesId = c.coursesId
            WHERE e.usersId = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $courseName = $row['coursesName'];
        $courseId = $row['coursesId'];
        $_SESSION['courseID'] = $courseId;
        echo '<li><a href="../pages/KursseiteEdit.php?courseid=' . $courseId . '&enrolled=yes">' . $courseName . '</a></li>';
    }

    mysqli_stmt_close($stmt);
}

function showCoursesSearchBar($searchContent)
{
    session_start();
    global $conn;

    $sql = "SELECT enrollment.usersid, courses.coursesid, coursesName FROM courses LEFT JOIN enrollment
     ON courses.coursesid = enrollment.coursesid where coursesName like ? ";


    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    $searchPattern = "%" . $searchContent . "%";
    mysqli_stmt_bind_param($stmt, "s", $searchPattern);
    mysqli_stmt_execute($stmt);


    $result = mysqli_stmt_get_result($stmt);




    if (mysqli_num_rows($result) == 0) {   
        echo 'Keine Kurse gefunden!';        
    }
 
    while ($row = mysqli_fetch_assoc($result)) {
        
        $courseName = $row['coursesName'];
        $courseId = $row['coursesid'];
        $usersid = $row['usersid'];

        if ($usersid == $_SESSION['usersID']) {            
            echo '<li class="liSearchContent"><a href="../pages/KursseiteEdit.php?courseid=' .
            $courseId . '&enrolled=yes">' . $courseName . ' (eingeschrieben)' . '</a></li>';
        } else {
            echo '<li class="liSearchContent"><a href="../pages/KursseiteEdit.php?courseid=' .
            $courseId . '&enrolled=no">' . $courseName . '</a></li>';
        }
    }


    /* $boundParams = [$searchPattern];
    $boundParamsString = implode(', ', $boundParams);

    $modifiedSqlCommand = str_replace('?', $boundParamsString, $sql);
    echo $modifiedSqlCommand; */



    mysqli_stmt_close($stmt);
}


function getExistingCourseInfo($courseIdNr)
{
    global $conn;



    $sql = "SELECT coursesName, courseSubjectArea, courseSemesterNr , courseSeason , courseTeacher
            FROM courses WHERE coursesId = ?";


    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }



    mysqli_stmt_bind_param($stmt, "i", $courseIdNr);
    mysqli_stmt_execute($stmt);



    $result = mysqli_stmt_get_result($stmt);



    $row = mysqli_fetch_assoc($result);
    $courseName = $row['coursesName'];
    $courseSA = $row['courseSubjectArea'];
    $courseSemesterNumber = $row['courseSemesterNr'];
    $courseSeason = $row['courseSeason'];
    $courseTeacher = getCourseTeacherName($row['courseTeacher']);
    $_SESSION['courseID'] = getCourseID($conn, $courseName);

    echo '<h1>' . $courseName . '</h1>';
    echo '<p>' . 'Fachbereich: ' . $courseSA . ' | ' . $courseSeason .
        ' | ab dem: ' . $courseSemesterNumber . '.Semester | Dozent: ' . $courseTeacher . '</p>';
    echo '<title>'.$courseName.'</title>';

    mysqli_stmt_close($stmt);
}

function updateCourseContent($conn, $courseid, $contentArray){

    session_start();
    $courseid = $_SESSION['courseID'];



    $jsonContent = json_encode($contentArray);



    $sql = "UPDATE courses SET courseContent = ? WHERE coursesId = ?;";



    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }



    mysqli_stmt_bind_param($stmt, "si", $jsonContent, $courseid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);



    return true;
}

function getCourseContent($conn, $courseid){

    session_start();
    $courseid = $_SESSION['courseID'];



    $sql = "SELECT courseContent FROM courses WHERE coursesId = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $courseid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $courseContent);

    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

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

function insertTeacherData($conn, $idCourse, $dataName, $base64Image){

    session_start();

    $idCourse = $_SESSION['courseID'];

    $blobData = base64_decode($base64Image);

    $sql = "INSERT INTO coursesteacherdata (idCourse, dataName, dataBlob) VALUES (?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

    }

    mysqli_stmt_bind_param($stmt, "iss", $idCourse, $dataName, $blobData);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Data inserted successfully";
    } else {
        echo "Failed to insert data";
    }

    mysqli_stmt_close($stmt);
}

function getTeacherData($conn, $idCourse, $dataName){

    session_start();
    $idCourse = $_SESSION['courseID'];

    $sql = "SELECT dataBlob FROM coursesteacherdata WHERE idCourse = ? AND dataName = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

    }

    mysqli_stmt_bind_param($stmt, "is", $idCourse, $dataName);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $dataBlob = $row['dataBlob'];
        echo 'data:image/png;base64,' . base64_encode($row['dataBlob']) . '';
    } else {
        $bindParamsString = var_export(array("is", $idCourse, $dataName), true);
        echo "No data found " . $idCourse . " " . $dataName . $bindParamsString;
    }
    mysqli_stmt_close($stmt);
}

function getAllTeacherData($conn, $idCourse){

    session_start();
    $idCourse = $_SESSION['courseID'];

    $sql = "SELECT dataBlob FROM coursesteacherdata WHERE idCourse = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
    }

    mysqli_stmt_bind_param($stmt, "i", $idCourse, $dataName);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dataBlob = $row['dataBlob'];
        echo 'data:image/png;base64,' . base64_encode($row['dataBlob']) . '';
    } else {
        $bindParamsString = var_export(array("is", $idCourse, $dataName), true);
        echo "No data found " . $idCourse . " " . $dataName . $bindParamsString;
    }

    mysqli_stmt_close($stmt);
}

function getCourseNameById($id){

    global $conn;

    $sql = "SELECT coursesName FROM courses WHERE coursesId = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $courseName);

    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    return $courseName;
}

/* Anzeige der möglichen Kurse mit Unterscheidung, ob User eingeschrieben ist oder nicht */
function showAvailableCourses($courseSubjectArea, $firstName, $lastName){

    global $conn;

    $sql = "SELECT coursesId, coursesName FROM courses WHERE courseSubjectArea = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $courseSubjectArea);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $userIdNr = getUserId($firstName, $lastName);

    while ($row = mysqli_fetch_assoc($result)) {
        $coursesIDNr = $row['coursesId'];
        $courseName = $row['coursesName'];
        if (checkEnroll($userIdNr, $coursesIDNr)){
            echo '<li><a href="../pages/KursseiteEdit.php?courseid='. $coursesIDNr.'&enrolled=yes">'.$courseName .'</a></li>';
        }else{
            echo '<li><a href="../pages/KursseiteEdit.php?courseid='. $coursesIDNr.'&enrolled=no">'.$courseName .'</a></li>';

        }
    }

    mysqli_stmt_close($stmt);
}

/* Überprüfung, ob ein User in einem Kurs eingeschrieben ist anhand Kurs-Id */
function checkEnroll($userID, $courseID){

    global $conn;

    $sql = "SELECT enrollmentId FROM enrollment e WHERE e.usersId = ? AND e.coursesId = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $userID, $courseID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $checkedEnroll);

    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    if ($checkedEnroll) {
        return true;
    } else {
        return false;
    }
}

/* Eintrag in die "enrollment" Tabelle mit User-Id und Kurs-Id*/
function enrollToCourse($usersId, $coursesId){

    global $conn;

    $sql = "INSERT INTO enrollment (usersId, coursesId) VALUES (?,?) ";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $usersId, $coursesId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

/* Boolean Rückgabe, ob ein Kurs ein Passwort hat*/
function availableCoursePwd($courseid){
    global $conn;
    $sql = "SELECT coursePwd FROM courses WHERE coursesId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i",$courseid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $availablePW);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if(empty($availablePW)){
        return false;
    }else {
        return true;
    }

}

/* Rückgabe des Passwortes vom Kurs abhängig von der Kurs-ID*/
function getCoursePW($courseid){

    global $conn;
    $sql = "SELECT coursePwd FROM courses WHERE coursesId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i",$courseid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $checkPW);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $checkPW;

}


function delistCourse($usersId, $coursesId){

    global $conn;

    $sql = "DELETE FROM enrollment WHERE usersId = ? AND coursesId = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $usersId, $coursesId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function delistAllFromCourse($coursesId){

    global $conn;

    $sql = "DELETE FROM enrollment WHERE coursesId = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $coursesId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function deleteCourseContent($coursesId){

    global $conn;

    $sql = "DELETE FROM coursesteacherdata WHERE idCourse = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $coursesId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function deletingCourse($usersId, $coursesId){

    global $conn;

    delistAllFromCourse($coursesId);
    deleteCourseContent($coursesId);

    $sql = "DELETE FROM courses WHERE courseTeacher = ? AND coursesId = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $usersId, $coursesId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}