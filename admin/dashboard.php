<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /booknest/index.php");
    exit;
}
include("../includes/header.php");
?>

<h2>📚 Admin Dashboard</h2>

<nav>
    <ul>
        <li><a href="manage_users.php">👥 Manage Users</a></li>
        <li><a href="manage_books.php">📖 Manage Books</a></li>
        <li><a href="manage_orders.php">🧾 Manage Orders</a></li>
        <li><a href="/booknest/index.php">🏠 Return to Homepage</a></li>
    </ul>
</nav>

<?php include("../includes/footer.php"); ?>
