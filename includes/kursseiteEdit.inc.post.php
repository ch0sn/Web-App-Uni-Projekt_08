<?php


require_once 'dbh.inc.php';
require_once 'functions.inc.php';



global $conn;
$courseid = $_POST['courseid'];
$contentArray = json_decode($_POST['contentArray'], true);


updateCourseContent($conn, $courseid, $contentArray);

