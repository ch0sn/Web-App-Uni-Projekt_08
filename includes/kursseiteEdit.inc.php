<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_GET['method'])) {
    $method = $_GET['method'];


    if ($method === "saveContentArray") {
        ContentArraySave();
    } elseif ($method === "getCourseContent") {
        CourseContentGet();
    } elseif ($method === "getCourseData") {
        CourseDataGet();
    } elseif ($method === "saveCourseData") {
        CourseDataSave();
    } elseif ($method === "CoursesSearchBar") {
        CoursesSearchBar();
    }
}


function CourseContentGet()
{
    global $conn;
    $content = getCourseContent($conn);
    echo $content;
}


function ContentArraySave()
{

    global $conn;
    $contentArray = json_decode($_POST['contentArray'], true);
    updateCourseContent($conn, $contentArray);

}


function CourseDataSave()
{
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    global $conn;
  
   
    $dataName = $_POST['dataName'];
    $base64Image = $_POST['base64Image'];

    insertCourseData($conn, $dataName, $base64Image);
    echo "Data inserted successfully";
   
}



function CourseDataGet()
{
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    global $conn;

    $dataName = $_POST['dataName'];
    $content = getCourseData($conn, $dataName);
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
