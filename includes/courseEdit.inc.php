<?php
session_start();


    if(empty($_POST["course_name"]) || empty($_POST["course_subjectarea"])
        || empty($_POST["course_semesternumber"]) || empty($_POST["course_semestertime"])) {
        header("Location: ../pages/KursseiteEdit.php?error=emptyfield");
        exit();
    }
    if (empty($_POST["coursePassword"])) {
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $coursename = $_POST["course_name"];
        $coursesubjectarea = $_POST["course_subjectarea"];
        $coursesemesternr = $_POST["course_semesternumber"];
        $coursesemesterseason = $_POST["course_semestertime"];
        $coursePassword = "";

        $uID = getUserId($_SESSION['firstName'], $_SESSION['lastName']);

        createCourse($coursename, $coursesubjectarea, $coursesemesternr, $coursesemesterseason, $coursePassword, $uID);

    }else {
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $coursename = $_POST["course_name"];
        $coursesubjectarea = $_POST["course_subjectarea"];
        $coursesemesternr = $_POST["course_semesternumber"];
        $coursesemesterseason = $_POST["course_semestertime"];
        $coursePassword = $_POST["coursePassword"];

        $uID = getUserId($_SESSION['firstName'], $_SESSION['lastName']);

        createCourse($coursename, $coursesubjectarea, $coursesemesternr, $coursesemesterseason, $coursePassword, $uID);
    }