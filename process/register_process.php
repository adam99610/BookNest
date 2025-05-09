<?php
session_start();
include(dirname(__DIR__) . "/includes/config.php");
include("../includes/functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $email = sanitize_input($_POST["email"]);
    $password = $_POST["password"];
    $password_hash = hash_password($password);

    $stmt = $mysqli->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");

    if ($stmt === false) {
        die("MySQL prepare error: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $username, $email, $password_hash);

    if ($stmt->execute()) {
        $_SESSION["user_id"] = $stmt->insert_id;
        redirect("/booknest/index.php");
    }else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>