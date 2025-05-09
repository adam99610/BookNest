<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/booknest/includes/config.php");
include($_SERVER['DOCUMENT_ROOT'] . "/booknest/includes/functions.php");

// Check admin status
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /booknest/index.php");
    exit;
}


// Validate order ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_orders.php");
    exit;
}

$order_id = (int)$_GET['id'];

// Delete related order items first
$stmt = $mysqli->prepare("DELETE FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();

// Then delete the order itself
$stmt = $mysqli->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();

// Redirect back
header("Location: /booknest/admin/manage_orders.php");
exit;
?>
