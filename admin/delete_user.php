<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /booknest/index.php");
    exit;
}
include("../includes/config.php");

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: manage_users.php");
exit;
?>
