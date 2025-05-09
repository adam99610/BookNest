<?php
session_start();
include("../../includes/config.php");
include("../../includes/functions.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    redirect("/index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $title = sanitize_input($_POST['title']);
    $author = sanitize_input($_POST['author']);
    $price = (float)$_POST['price'];
    $description = sanitize_input($_POST['description']);

    // handles cover page upload
    $cover_image = null;
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0){
        $cover_image = 'uploads/' . time() . '_' . basename($_FILES['cover']['name']);
        move_uploaded_file($_FILES['cover']['tmp_name'], '../../' . $cover_image);
    }

    // Update Book details
    $stmt = $mysqli->prepare("UPDATE books SET title = ?, author = ?, price = ?, description = ?, cover_image = ? WHERE id = ?");
    $stmt->bind_param("ssdii", $title, $author, $price, $description, $cover_image, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Book updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating book.";
    }

    $stmt->close();
}

redirect("/admin/books.php");
?>