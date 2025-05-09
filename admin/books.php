<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    redirect("/booknest/index.php");
}

$stmt = $mysqli->prepare("SELECT id, title, author, price FROM books ORDER BY id ASC");
$stmt->execute();
$books = $stmt->get_result();

include("../includes/footer.php");
?>

<h2>Manage Books</h2>

<a href="/admin/add_book.php">Add New Book</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($book = $books->fetch_assoc()): ?>
            <tr>
                <td><?php echo $book['id']; ?></td>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo number_format($book['price'], 2); ?></td>
                <td>
                    <a href="/admin/edit_book.php?id=<?php echo $book['id']; ?>">Edit</a>
                    <a href="/admin/process/delete_book.php?id=<?php echo $book['id']; ?>"onclick="return confirm('Delete this book?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$stmt->close();
include("../includes/footer.php");
?>