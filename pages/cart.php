<?php
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/header.php");

$cart = isset($_SESSION['CART']) ? $_SESSION['CART'] : [];
?>

<h2>Your Shopping Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is currently empty.</p>
<?php else: ?>
    <form action="/booknest/process/update_cart.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cart as $book_id => $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td>£<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <input type="number" name="quantities[<?php echo $book_id; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                        </td>
                        <td>£<?php echo number_format($subtotal, 2); ?></td>
                        <td><a href="/booknest/process/remove_from_cart.php?id=<?php echo $book_id; ?>">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total:</strong>£<?php echo number_format($total, 2); ?></p>

        <button type="submit">Update Cart</button>
        <a href="/booknest/pages/checkout.php">Proceed to Checkout</a>
    </form>
<?php endif; ?>

<?php include("../includes/footer.php"); ?>
