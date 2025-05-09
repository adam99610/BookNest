<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /booknest/index.php");
    exit;
}
include("../includes/header.php");

$id = $_GET['id'];
$deactivate_stmt = $mysqli->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
$deactivate_stmt->bind_param("i", $id);
$deactivate_stmt->execute();
$deactivate_stmt->close();

header("Location: manage_users.php");
exit;

include("../includes/footer.php");
?>
