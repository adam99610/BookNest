<?php
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/header.php");

if (empty($_SESSION['CART'])) {
    echo "<p>Your cart is empty. <a href='/catalogue.php'>Browse books</a>.</p>";
} else {
    // Cart is not empty, display the checkout details
    echo "<h2>Checkout</h2>";
    
    // Table to display the cart items
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Book</th>";
    echo "<th>Price</th>";
    echo "<th>Quantity</th>";
    echo "<th>Subtotal</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $total = 0;
    foreach ($_SESSION['CART'] as $book_id => $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;

        echo "<tr>";
        echo "<td>" . htmlspecialchars($item['title']) . "</td>";
        echo "<td>£" . number_format($item['price'], 2) . "</td>";
        echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
        echo "<td>£" . number_format($subtotal, 2) . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // Display the total
    echo "<p><strong>Total:</strong> £" . number_format($total, 2) . "</p>";

    // Checkout form
    echo "<form action='/booknest/checkout_process.php' method='POST'>";
    echo "<button type='submit'>Proceed to Checkout</button>";
    echo "</form>";
}

include("../includes/footer.php");
?>
