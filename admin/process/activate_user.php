<?php
session_start();
include("../../includes/config.php");
include("../../includes/functions.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    redirect("/index.php");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $mysqli->prepare("UPDATE users SET active = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

redirect("/admin/users.php");
?>