<?php
include("includes/config.php");
include("includes/functions.php");
include("includes/header.php");

// Handle the search input
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';

// Get books based on search results
if (!empty($search)) {
    $searchParam = '%' . $search . '%';
    $stmt = $mysqli->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    $stmt->bind_param("ss", $searchParam, $searchParam);
} else {
    $stmt = $mysqli->prepare("SELECT * FROM books");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
}

$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Book Catalogue</h2>

<form action="catalogue.php" method="get">
    <label for="search">Search by Title or Author:</label>
    <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<div id="book-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($book = $result->fetch_assoc()): ?>
            <div class="book-item">
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Price:</strong> £<?php echo number_format($book['price'], 2); ?></p>
                <?php if (!empty($book['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($book['image_url']); ?>" alt="Cover of <?php echo htmlspecialchars($book['title']); ?>">
                <?php endif; ?>
                <p>
                    <a href="/booknest/pages/book_details.php?id=<?php echo $book['id']; ?>">View Details</a>
                </p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No books found<?php if (!empty($search)) echo " matching your search."; ?></p>
    <?php endif; ?>
</div>

<?php
$stmt->close();
$mysqli->close();
include("includes/footer.php");
?>
