<?php
include_once "functions.inc.php";
session_start();
global $conn;

if (isset($_GET['method'])) {
    $method = $_GET['method'];
    if ($method === "checkEnrollment") {
        $userID = getUserId ($_SESSION['firstName'], $_SESSION['lastName']);
        checkEnrollment($conn, $userID);
    }
}
