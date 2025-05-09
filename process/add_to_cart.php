<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $book_id = (int)$_POST['book_id'];
    $quantity = max(1, (int)$_POST['quantity']);

    // Check if the cart session is set, if not, initialize it
    if (!isset($_SESSION['CART'])) {
        $_SESSION['CART'] = [];
    }

    // Fetch book details to validate the book
    $stmt = $mysqli->prepare("SELECT title, price FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $book = $result->fetch_assoc();

        // If the book is already in the cart, update the quantity, otherwise add it
        if (isset($_SESSION['CART'][$book_id])) {
            $_SESSION['CART'][$book_id]['quantity'] += $quantity;
        } else {
            $_SESSION['CART'][$book_id] = [
                'title' => $book['title'],
                'price' => $book['price'],
                'quantity' => $quantity
            ];
        }

        // Redirect to the cart page after adding the book
        header("Location: /booknest/pages/cart.php");
        exit();
    } else {
        echo "Book not found.";
    }

    $stmt->close();
    $mysqli->close();
}
?>
