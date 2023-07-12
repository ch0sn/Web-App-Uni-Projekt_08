<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_GET['method'])) {
    $method = $_GET['method'];


    if ($method === "saveContentArray") {
        ContentArraySave();
    } elseif ($method === "getCourseContent") {
        CourseContentGet();
    } elseif ($method === "getTeacherData") {
        TeacherDataGet();
    } elseif ($method === "saveTeacherData") {
        TeacherDataSave();
    } elseif ($method === "CoursesSearchBar") {
        CoursesSearchBar();
    }
}


function CourseContentGet()
{
    global $conn;
    $courseid = $_POST['courseid'];
    $content = getCourseContent($conn, $courseid);
    echo $content;
}


function ContentArraySave()
{

    global $conn;
    $courseid = $_POST['courseid'];
    $contentArray = json_decode($_POST['contentArray'], true);

    updateCourseContent($conn, $courseid, $contentArray);
}


function TeacherDataSave()
{
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    global $conn;

    // Überprüfen, ob die erforderlichen Daten vorhanden sind
    if (isset($_POST['courseid']) && isset($_POST['dataName']) && isset($_POST['base64Image'])) {
        $courseid = $_POST['courseid'];
        $dataName = $_POST['dataName'];
        $base64Image = $_POST['base64Image'];

        // Daten in die Datenbank einfügen
        insertTeacherData($conn, $courseid, $dataName, $base64Image);
        echo "Data inserted successfully";
    } else {
        echo "Missing data";
    }
}



function TeacherDataGet()
{
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    global $conn;
    $courseid = $_POST['courseid'];
    $dataName = $_POST['dataName'];
    $content = getTeacherData($conn, $courseid, $dataName);
    echo $content;
}

function CoursesSearchBar()
{
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    global $conn;
    $searchContent = $_POST['searchContent'];
    $content = showCoursesSearchBar($searchContent);
    echo $content;
}
