<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

// Check admin status
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /booknest/index.php");
    exit;
}

// Validate order ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_orders.php");
    exit;
}

$order_id = (int)$_GET['id'];

// Fetch order details
$stmt = $mysqli->prepare("SELECT o.id, u.username, o.total_price, o.created_at 
                          FROM orders o 
                          JOIN users u ON o.user_id = u.id 
                          WHERE o.id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $username, $total_price, $created_at);
$stmt->fetch();

if ($stmt->num_rows === 0) {
    echo "Order not found.";
    exit;
}

include("../includes/header.php");
?>

<h2>📖 Order #<?php echo $id; ?> Details</h2>
<p><strong>User:</strong> <?php echo htmlspecialchars($username); ?></p>
<p><strong>Total Price:</strong> £<?php echo number_format($total_price, 2); ?></p>
<p><strong>Placed On:</strong> <?php echo $created_at; ?></p>

<h3>Items:</h3>
<table>
    <thead>
        <tr>
            <th>Book Title</th>
            <th>Quantity</th>
            <th>Price (each)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $item_stmt = $mysqli->prepare("SELECT b.title, oi.quantity, oi.price
                                        FROM order_items oi
                                        JOIN books b ON oi.book_id = b.id
                                        WHERE oi.order_id = ?");
        $item_stmt->bind_param("i", $order_id);
        $item_stmt->execute();
        $result = $item_stmt->get_result();

        while ($item = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo htmlspecialchars($item['title']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>£<?php echo number_format($item['price'], 2); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<p><a href="/admin/manage_orders.php">← Back to Manage Orders</a></p>

<?php
include("../includes/footer.php");
?>
