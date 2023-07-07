<?php


require_once 'dbh.inc.php';
require_once 'functions.inc.php';


global $conn;
$courseid = $_POST['courseid'];
$content = getCourseContent($conn, $courseid);
echo $content;

