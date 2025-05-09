<?php
require_once(__DIR__ . "/../includes/config.php");
require_once(__DIR__ . "/../includes/functions.php");
include("../includes/header.php");
?>

<h2>Register an Account</h2>

<form action="/booknest/process/register_process.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" required id="username" aria-required="true">

    <label for="email">Email:</label>
    <input type="text" name="email" required id="email" aria-required="true">

    <label for="password">Password:</label>
    <input type="password" name="password" required id="password" aria-required="true">

    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="../pages/login.php">Login here</a></p>

<?php include("../includes/footer.php"); ?>