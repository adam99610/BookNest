<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/header.php");

// Check if user is logged in (optional, but good practice)
if (!is_logged_in()) {
    redirect("/booknest/pages/login.php");
}
?>

<div class="container">
    <h2>Thank you for your order!</h2>
    <p>Your order has been successfully placed. We’ll send you an email confirmation shortly.</p>

    <p>
        <a href="/booknest/catalogue.php">Continue Shopping</a>
        or 
        <a href="/booknest/pages/order_history.php">View Your Orders</a>
    </p>
</div>

<?php include("../includes/footer.php"); ?>
