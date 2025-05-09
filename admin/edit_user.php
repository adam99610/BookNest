<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /booknest/index.php");
    exit;
}
include("../includes/header.php");

$id = $_GET['id'];
$stmt = $mysqli->prepare("SELECT username, email, is_active FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $email, $is_active);
$stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST["username"];
    $new_email = $_POST["email"];
    $new_is_active = isset($_POST["is_active"]) ? 1 : 0;

    $update_stmt = $mysqli->prepare("UPDATE users SET username = ?, email = ?, is_active = ? WHERE id = ?");
    $update_stmt->bind_param("ssii", $new_username, $new_email, $new_is_active, $id);
    $update_stmt->execute();
    $update_stmt->close();

    header("Location: manage_users.php");
    exit;
}

?>

<h2>Edit User</h2>

<form action="" method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

    <label for="is_active">Active</label>
    <input type="checkbox" name="is_active" <?php echo $is_active ? 'checked' : ''; ?>>

    <button type="submit">Update</button>
</form>

<?php
include("../includes/footer.php");
?>
