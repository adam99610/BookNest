<?php

//Sanitize the users input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

//Redirect helper
function redirect($url) {
    header("Location:" . $url);
    exit();
}

//check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

//Securely hash the password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

//Verify that the password is hashed
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

//Check admin login status
function is_admin_logged_in() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}