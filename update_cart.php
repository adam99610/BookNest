<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantities'])) {
    // Loop through the posted quantities to update the cart
    foreach ($_POST['quantities'] as $book_id => $quantity) {
        // Validate quantity to ensure it's a positive number
        $quantity = max(1, (int)$quantity);

        // Check if the book exists in the session cart
        if (isset($_SESSION['CART'][$book_id])) {
            $_SESSION['CART'][$book_id]['quantity'] = $quantity;  // Update quantity
        }
    }

    // Redirect to the cart page after updating the cart
    redirect("/booknest/pages/cart.php");
} else {
    // If no quantities were passed, redirect back to the cart
    redirect("/booknest/pages/cart.php");
}
?>
