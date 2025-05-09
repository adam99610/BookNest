<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $book_id = (int)$_POST['book_id'];
    $rating = max(1, min(5, (int)$_POST['rating']));
    $review_text = sanitize_input($_POST['review_text']);
    $user_id = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("INSERT INTO reviews (user_id, book_id, rating, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $book_id, $rating, $review_text);

    if($stmt->execute()) {
        $_SESSION['message'] = "Review submitted for approval.";
    }else{
        $_SESSION['message'] = "Error submitting review.";
    }

    $stmt->close();
    $mysqli->close();

    redirect("/booknest/pages/book_details.php?id=" . $book_id);
}
?>