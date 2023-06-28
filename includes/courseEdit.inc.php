<?php
session_start();
global $conn;

    if(empty($_POST["course_name"]) || empty($_POST["course_subjectarea"])
        || empty($_POST["course_semesternumber"]) || empty($_POST["course_semestertime"])) {
        header("Location: ../pages/KursseiteEdit.php?error=emptyfield");
        exit();
    }else if (empty($_POST["course_pwd"])){
        $coursename = $_POST["course_name"];
        $coursesubjectarea = $_POST["course_subjectarea"];
        $coursesemesternr = $_POST["course_semesternumber"];
        $coursesemestertime = $_POST["course_semestertime"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $uID = getUserId($_SESSION['firstName'],$_SESSION['lastName']);

        createCourseWOPwd($conn,$coursename, $coursesubjectarea, $coursesemesternr, $coursesemestertime, $uID);
    }else{
        $coursename = $_POST["course_name"];
        $coursesubjectarea = $_POST["course_subjectarea"];
        $coursesemesternr = $_POST["course_semesternumber"];
        $coursesemestertime = $_POST["course_semestertime"];
        $coursepwd = $_POST["course_pwd"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $uID = getUserId($_SESSION['firstName'],$_SESSION['lastName']);

        createCourse($conn, $coursename ,$coursesubjectarea,$coursesemesternr,$coursesemestertime, $coursepwd, $uID);
    }