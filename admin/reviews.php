<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

// Adding a check to see if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !=='admin') {
    redirect("/booknest/index.php");
}

// Fetching all reviews
$stmt = $mysqli->prepare("SELECT r.id, r.rating, r.review_text, r.created_at, r.approved, u.username, b.title 
                          FROM reviews r
                          JOIN users u ON r.user_id = u.id
                          JOIN books b ON r.book_id = b.id
                          ORDER BY r.created_at DESC");
$stmt->execute();
$reviews = $stmt->get_result();

include("../includes/header.php");
?>

<h2>Manage Reviews</h2>

<table border="1">
    <thead>
        <tr>
            <th>Book</th>
            <th>Users</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($review = $reviews->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($review['title']); ?></td>
                <td><?php echo htmlspecialchars($review['username']); ?></td>
                <td><?php echo str_repeat("⭐", $review['rating']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></td>
                <td><?php echo $review['created_at']; ?></td>
                <td><?php echo $review['approved'] ? "Approved" : "Pending"; ?></td>
                <td>
                    <?php if (!$review['approved']): ?>
                        <a href="/admin/process/approve_review.php?id=<?php echo $review['id']; ?>">Approve</a>
                    <?php endif; ?>
                    <a href="/admin/process/delete_review.php?id<?php echo $review['id']; ?>">Delete</a>    
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$stmt->close();
include("../includes/footer.php");
?>