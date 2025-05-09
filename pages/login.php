<?php
require_once(__DIR__ . "/../includes/config.php");
require_once(__DIR__."/../includes/functions.php");
include("../includes/header.php");
?>

<h2>Login to your Account</h2>

<form action="../process/login_process.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required id="username" aria-required="true">

    <label for="password">Password:</label>
    <input type="password" name="password" required id="password" aria-required="true">

    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="../pages/register.php">Register here</a></p>

<?php include("../includes/footer.php"); ?>