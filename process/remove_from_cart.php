<?php
session_start();
include("../includes/functions.php");

if (isset($_GET['id'])) {
    $book_id = (int)$_GET['id'];

    // Check if the book exists in the cart
    if (isset($_SESSION['CART'][$book_id])) {
        unset($_SESSION['CART'][$book_id]);  // Remove book from cart
    }

    // Redirect to cart page after removal
    redirect("/booknest/pages/cart.php");
}
?>
