<?php
session_start();
include("../../includes/functions.php");
include("../../includes/config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    redirect("/index.php");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $mysqli->prepare("UPDATE reviews SET approved = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

redirect("/admin/reviews.php");
?>