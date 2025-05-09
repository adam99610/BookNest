<?php
session_start();
include("../../includes/config.php");
include("../../includes/functions.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    redirect("/index.php");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // This deletes the cover image from the server(if any)
    $stmt = $mysqli->prepare("SELECT cover_image FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $book = $stmt->get_result()->fetch_assoc();
    if ($book && $book['cover_image']) {
        unlink('../../' . $book['cover_image']);
    }
    $stmt->close();

    //This deletes the book from the database
    $stmt = $mysqli->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

redirect("/admin/books.php");
?>