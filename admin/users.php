<?php
session_start();
include("../includes/config.php");
include("../includes/functions.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    redirect("/booknest/index.php");
}

$stmt = $mysqli->prepare("SELECT id, username, email, active, role FROM users ORDER BY id ASC ");
$stmt->execute();
$users = $stmt->get_result();

include("../includes/header.php");
?>

<h2>Manage Users</h2>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td><?php echo $user['active'] ? "Active" : "Inactive"; ?></td>
                <td>
                    <?php if ($user['active']): ?>
                        <a href="/admin/process/deactivate_user.php?id=<?php echo $user['id']; ?>">Deactivate</a>
                    <?php else: ?>
                        <a href="/admin/process/activate_user.php?id=<?php echo $user['id']; ?>">Activate</a>
                    <?php endif; ?>
                    <a href="/admin/process/delete_user.php?id=<?php echo $user['id']; ?>"onclick="return confirm('Delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$stmt->close();
include("../includes/footer.php");
?>