<?php
session_start();



if(isset($_GET["signedin"])){
    header("Location: ../pages/mainsite.php?signedin=useruid");
    exit();
}
else {
    header("Location: ../index.php");
    exit();
}
