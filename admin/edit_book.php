<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /booknest/index.php");
    exit;
}
include("../includes/header.php");

$id = $_GET['id'];
$stmt = $mysqli->prepare("SELECT title, author, price FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($title, $author, $price);
$stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST["title"];
    $new_author = $_POST["author"];
    $new_price = $_POST["price"];

    $update_stmt = $mysqli->prepare("UPDATE books SET title = ?, author = ?, price = ? WHERE id = ?");
    $update_stmt->bind_param("ssdi", $new_title, $new_author, $new_price, $id);
    $update_stmt->execute();
    $update_stmt->close();

    header("Location: manage_books.php");
    exit;
}

?>

<h2>Edit Book</h2>

<form action="" method="POST">
    <label for="title">Title</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

    <label for="author">Author</label>
    <input type="text" name="author" value="<?php echo htmlspecialchars($author); ?>" required>

    <label for="price">Price</label>
    <input type="number" name="price" value="<?php echo $price; ?>" step="0.01" required>

    <button type="submit">Update</button>
</form>

<?php
include("../includes/footer.php");
?>
