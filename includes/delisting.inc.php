<?php
include_once "functions.inc.php";
$usersId = $_GET['userid'];
$coursesId = $_GET['courseid'];
/* Unterscheidung ob Student oder Dozent auf den Abmeldebutton gedrückt hat
    Falls "Dozent" -> Kurslöschung,
    sonst "einfache" Abmeldung des Kurses. */
if (getCourseTeacherByCourseId($coursesId) == $usersId){
    deletingCourse($usersId,$coursesId);
    header("Location: ../pages/mainsite.php");
}else {
    delistCourse($usersId, $coursesId);
    header("Location: ../pages/mainsite.php");
}
