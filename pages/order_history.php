<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/header.php");

// Check if user is logged in
if (!is_logged_in()) {
    redirect("/booknest/pages/login.php");
}

$user_id = $_SESSION['user_id'];

// Fetch user's orders
$stmt = $mysqli->prepare("SELECT id, total_price, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <h2>Your Order History</h2>

    <?php if ($result->num_rows === 0): ?>
        <p>You haven’t placed any orders yet.</p>
        <a href="/booknest/pages/catalogue.php">Browse Books</a>
    <?php else: ?>
        <?php while ($order = $result->fetch_assoc()): ?>
            <div class="order-card">
                <h3>Order #<?php echo $order['id']; ?> — £<?php echo number_format($order['total_price'], 2); ?></h3>
                <p><strong>Placed on:</strong> <?php echo date("j M Y, H:i", strtotime($order['created_at'])); ?></p>

                <table>
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $order_id = $order['id'];
                        $item_stmt = $mysqli->prepare("SELECT b.title, oi.quantity, oi.price 
                                                       FROM order_items oi
                                                       JOIN books b ON oi.book_id = b.id
                                                       WHERE oi.order_id = ?");
                        $item_stmt->bind_param("i", $order_id);
                        $item_stmt->execute();
                        $items_result = $item_stmt->get_result();

                        while ($item = $items_result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>£<?php echo number_format($item['price'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

</div>

<?php include("../includes/footer.php"); ?>
