<?php 
if(session_status() == PHP_SESSION_NONE) {
    session_start();
} 
require_once("functions.php");
require_once(__DIR__ . "/config.php");

date_default_timezone_set('Europe/London');
?>

<!DOCTYPE html>
<html lang="en">
<style>
    nav ul { list-style: none; padding: 0; }
    nav li { margin: 10px 0; }
    nav a { text-decoration: none; font-size: 1.2rem; }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <header>
        <h1><a href="/booknest/index.php">BookNest</a></h1>
        <nav>
            <ul>
                     <?php if (is_logged_in() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <li><a href="/booknest/admin/dashboard.php">Admin Dashboard</a></li>
                    <?php endif; ?>
                <li><a href="/booknest/catalogue.php">Catalogue</a></li>

                <?php if (is_logged_in()): ?>

                    <li><a href="/booknest/pages/cart.php">Cart</a></li>
                    <li><a href="/booknest/pages/logout.php">Logout</a></li>
                    
                <?php else: ?>
                    <li><a href="/booknest/pages/login.php">Login</a></li>
                    <li><a href="/booknest/pages/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
