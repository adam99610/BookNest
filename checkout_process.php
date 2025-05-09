<?php
session_start();

// Include necessary files
include($_SERVER['DOCUMENT_ROOT'] . "/booknest/includes/config.php");
include($_SERVER['DOCUMENT_ROOT'] . "/booknest/includes/functions.php");

// Check if the cart is empty
if (empty($_SESSION['CART'])) {
    // Redirect to the cart page if the cart is empty
    redirect("/booknest/pages/cart.php");
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect("/booknest/pages/login.php"); // Redirect to login page if user is not logged in
}

// Calculate total price of the cart
$total = 0;
foreach ($_SESSION['CART'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Prepare order details to save to the database
$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID
$status = 'Pending';  // Set the status of the order to 'Pending'

try {
    // Insert the order into the orders table
    $stmt = $mysqli->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, ?)");
    if ($stmt === false) {
        throw new Exception("Error preparing the order insert statement: " . $mysqli->error);
    }

    // Bind parameters for the order insert
    $stmt->bind_param("ids", $user_id, $total, $status);
    if (!$stmt->execute()) {
        throw new Exception("Error executing order insert query: " . $stmt->error);
    }

    // Get the last inserted order ID
    $order_id = $stmt->insert_id;

    // Insert each item in the cart into the order_items table
    foreach ($_SESSION['CART'] as $book_id => $item) {
        $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparing the order items insert statement: " . $mysqli->error);
        }

        // Bind parameters for the order items insert
        $stmt->bind_param("iiid", $order_id, $book_id, $item['quantity'], $item['price']);
        if (!$stmt->execute()) {
            throw new Exception("Error executing order items insert query: " . $stmt->error);
        }
    }

    // Optionally, clear the cart after the order is placed
    unset($_SESSION['CART']);

    // Redirect to the order confirmation page
    redirect("/booknest/pages/order_confirmation.php");

} catch (Exception $e) {
    // If any errors occur, show the error message
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p><a href='/booknest/pages/cart.php'>Go back to Cart</a></p>";
}
?>
