<?php

global $conn;
if (isset($_POST["submit"])) {
    if(empty($_POST["course_name"]) || empty($_POST["course_subjectarea"])
        || empty($_POST["course_semesternumber"]) || empty($_POST[course_semestertime])) {
        header("Location: ../pages/KursseiteEdit.php?error=emptyfield");
        exit();
    }else{
        $coursename = $_POST["uid"];
        $coursesubjectarea = $_POST["pwd"];
        $coursesemesternr = $_POST["course_semesternumber"];
        $coursesemestertime = $_POST["course_semestertime"];
        $coursepwd = $_POST["course_pwd"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        createCourse($conn,$coursesubjectarea,$coursesemesternr,$coursesemestertime,$coursepwd);
    }
}else {
    header("Location: ../pages/KursseiteEdit.php");
    exit();
}