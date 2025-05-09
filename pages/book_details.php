<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/header.php");

// Check if book ID is provided and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect("/catalogue.php");
}

$book_id = (int)$_GET['id'];

// Fetch book details
$stmt = $mysqli->prepare("SELECT * FROM books WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<p>Book not found.</p>";
} else {
    $book = $result->fetch_assoc();
    ?>
    <h2><?php echo htmlspecialchars($book['title']); ?></h2>
    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
    <p><strong>Price:</strong> £<?php echo number_format($book['price'], 2); ?></p>
    
    <?php if (!empty($book['image_url'])): ?>
        <img src="<?php echo htmlspecialchars($book['image_url']); ?>" alt="Cover of <?php echo htmlspecialchars($book['title']); ?>">
    <?php endif; ?>

    <!-- Add to Cart Form -->
    <form action="/booknest/process/add_to_cart.php" method="post">
        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" value="1" min="1" required>
        <button type="submit">Add to Cart</button>
    </form>
    <?php
}
$stmt->close();  // Close after we're done using this query

// Fetch user reviews for this book
$stmt = $mysqli->prepare("SELECT r.rating, r.review_text, r.created_at, u.username 
                          FROM reviews r 
                          JOIN users u ON r.user_id = u.id 
                          WHERE r.book_id = ? AND r.approved = 1
                          ORDER BY r.created_at DESC");

if (!$stmt) {
    die("Prepare failed (reviews): " . $mysqli->error);
}
$stmt->bind_param("i", $book_id);
$stmt->execute();
$reviews = $stmt->get_result();
?>

<!-- Reviews section -->
<h3>User Reviews</h3>

<?php if ($reviews->num_rows > 0): ?>
    <?php while ($review = $reviews->fetch_assoc()): ?>
        <div class="review">
            <p><strong><?php echo htmlspecialchars($review['username']); ?></strong></p>
            <p>Rating: <?php echo str_repeat("⭐", $review['rating']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
            <p><small><?php echo htmlspecialchars($review['created_at']); ?></small></p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No reviews yet.</p>
<?php endif; ?>

<?php
$stmt->close();  // Close after we're done using the reviews query

// Review submission form (if logged in)
if (isset($_SESSION['user_id'])):
?>
    <h4>Leave a Review</h4>
    <form action="/booknest/process/submit_review.php" method="post">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <label for="rating">Rating:</label>
        <select name="rating" required>
            <option value="">Select</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?>⭐</option>
            <?php endfor; ?>
        </select><br>
        <label for="review_text">Review:</label><br>
        <textarea name="review_text" rows="4" cols="50" required></textarea><br>
        <button type="submit">Submit Review</button>
    </form>
<?php else: ?>
    <p><a href="/booknest/pages/login.php">Log in</a> to leave a review.</p>
<?php endif; ?>

<?php
$mysqli->close();  // Now safe to close the database connection
include("../includes/footer.php");
?>
