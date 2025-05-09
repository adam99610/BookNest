<?php
session_start();
include("../../includes/functions.php");
include("../../includes/config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    redirect("/index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = sanitize_input($_POST['title']);
    $author = sanitize_input($_POST['author']);
    $price = (float)$_POST['price'];
    $description = sanitize_input($_POST['description']);

    //This will handle the cover image uploads
    $cover_image = null;
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] ==0) {
        $cover_image = 'uploads/' . time() . '_' . basename($_FILES['cover']['name']);
        move_uploaded_file($_FILES['cover']['tmp_name'], '../../' . $cover_image);
    }

    //This inserts books into the database
    $stmt = $mysqli->prepare("INSERT INTO books (title, author, price, description, cover_image) VALUES (?, ?, ?, ?, ?) ");
    $stmt->bind_param("ssdss", $title,$author,$price,$description, $cover_image);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Book added successfully!";
    }else {
        $_SESSION['message'] = "Error adding book.";
    }
    $stmt->close();

}

redirect("/admin/books.php");
?>