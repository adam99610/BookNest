<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    redirect("/booknest/index.php");
}

include("../includes/header.php");
?>

<h2>Add New Book</h2>

<form action="/admin/process/add_book.php" method="post" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" required><br>

    <label for="author">Author:</label>
    <input type="text" name="author" required><br>

    <label for="price">Price (£):</label>
    <input type="number"  step="0.01" name="price" required><br>

    <label for="description">Description:</label>
    <textarea name="description" rows="4" required></textarea><br>

    <label for="cover">Cover Image:</label>
    <input type="file" name="cover" accept="image/*"><br>

    <button type="submit">Add Book</button>
</form>

<?php
include("../includes/footer.php");
?>