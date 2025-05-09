<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /booknest/index.php");
    exit;
}
include("../includes/header.php");

$id = $_GET['id'];
$delete_stmt = $mysqli->prepare("DELETE FROM books WHERE id = ?");
$delete_stmt->bind_param("i", $id);
$delete_stmt->execute();
$delete_stmt->close();

header("Location: manage_books.php");
exit;

include("../includes/footer.php");
?>
