<?php
session_start();
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /booknest/index.php");
    exit;
}

include("../includes/header.php");

$stmt = $mysqli->prepare("SELECT id, user_id, total_price, created_at FROM orders");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $user_id, $total_price, $created_at);

?>

<h2>🧾 Manage Orders</h2>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Total Price</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($id); ?></td>
                <td><?php echo htmlspecialchars($user_id); ?></td>
                <td><?php echo $total_price; ?></td>
                <td><?php echo $created_at; ?></td>
                <td>
                    <a href="/booknest/view_order.php?id=<?php echo $id; ?>">View</a> | 
                    <a href="/booknest/delete_order.php?id=<?php echo $id; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$stmt->close();
include("../includes/footer.php");
?>
