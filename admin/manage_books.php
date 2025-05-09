<?php
session_start();
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /booknest/index.php");
    exit;
}


include("../includes/header.php");

$stmt = $mysqli->prepare("SELECT id, title, author, price, created_at FROM books");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $title, $author, $price, $created_at);

?>

<h2>📖 Manage Books</h2>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Added On</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($title); ?></td>
                <td><?php echo htmlspecialchars($author); ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $created_at; ?></td>
                <td>
                    <a href="edit_book.php?id=<?php echo $id; ?>">Edit</a> | 
                    <a href="delete_book.php?id=<?php echo $id; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$stmt->close();
include("../includes/footer.php");
?>
