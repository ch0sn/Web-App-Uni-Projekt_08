<?php
include_once "functions.inc.php";
if (availableCoursePwd($_GET['courseid'])){
    $enrollPw = $_POST['loginKeyPanel'];
    /*$hashedEnrollPw = password_hash($enrollPw, PASSWORD_DEFAULT );*/
    if (password_verify($enrollPw,getCoursePW($_GET['courseid']))){
        enrollToCourse($_GET['userid'], $_GET['courseid']);
    header("Location: ../pages/KursseiteEdit.php?courseid=" . $_GET["courseid"] . "&enrolled=yes");
    }else {
        header("Location: ../pages/KursseiteEdit.php?courseid=". $_GET["courseid"] . "&enrolled=no&pwkey=false");
    }
} else {
    enrollToCourse($_GET['userid'], $_GET['courseid']);
    header("Location: ../pages/KursseiteEdit.php?courseid=" . $_GET["courseid"] . "&enrolled=yes");
}