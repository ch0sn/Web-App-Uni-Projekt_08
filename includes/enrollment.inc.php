<?php
include_once "functions.inc.php";
if (isset($_POST['loginKeyPanel'])){
$enrollPw = $_POST['loginKeyPanel'];
$hashedEnrollPw = password_hash($enrollPw, PASSWORD_DEFAULT );
}
else {
    enrollToCourse($_GET['userid'], $_GET['courseid']);
    header("Location: ../pages/KursseiteEdit.php?courseid=" . $_GET["courseid"] . "&enrolled=yes");
}