<?php
include_once "functions.inc.php";
$usersId = $_GET['userid'];
$coursesId = $_GET['courseid'];
if (getCourseTeacherByCourseId($coursesId) == $usersId){
    deletingCourse($usersId,$coursesId);
    header("Location: ../pages/mainsite.php");
}else {
    delistCourse($usersId, $coursesId);
    header("Location: ../pages/mainsite.php");
}
