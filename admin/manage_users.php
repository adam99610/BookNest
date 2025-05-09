<?php
session_start();
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: /booknest/index.php");
    exit;
}

include("../includes/header.php");

$stmt = $mysqli->prepare("SELECT id, username, email, is_active FROM users");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $username, $email, $is_active);

?>

<h2>👥 Manage Users</h2>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($username); ?></td>
                <td><?php echo htmlspecialchars($email); ?></td>
                <td><?php echo $is_active ? 'Active' : 'Inactive'; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $id; ?>">Edit</a> | 
                    <a href="deactivate_user.php?id=<?php echo $id; ?>">Deactivate</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$stmt->close();
include("../includes/footer.php");
?>
