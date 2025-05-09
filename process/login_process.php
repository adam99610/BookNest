<?php
session_start();
include(dirname(__DIR__) . "/includes/config.php");
include("../includes/functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $mysqli->prepare("SELECT id, password_hash, is_admin FROM users WHERE username = ? AND is_active = 1");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $password_hash, $is_admin);
        $stmt->fetch();

        if (verify_password($password, $password_hash)) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["is_admin"] = $is_admin;

            if ($is_admin == 1) {
                redirect("/booknest/admin/dashboard.php");
            } else {
                redirect("/booknest/index.php");
            }

        } else {
            echo "Invalid password.";
        }

    } else {
        echo "Invalid username or account deactivated.";
    }

    $stmt->close();
    $mysqli->close();
}
?>
