<?php
session_start();

//this is a check if the user is logged in and that user is admin
if(!isset($_SESSION["user_id"]) || !isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    // if not logged in as admin will redirect to login page
    header("Location: /booknest/pages/login.php");
    exit();
}
?>