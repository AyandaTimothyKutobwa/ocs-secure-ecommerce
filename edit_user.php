<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT id, username, email, role FROM users WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    header("Location: dashboard.php");
    exit();
}

$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User Role</title>
</head>
<body>
    <h2>Edit Role for <?php echo htmlspecialchars($user['username']); ?></h2>
    <form method="POST" action="update_user.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>
            Role:
            <select name="role" required>
                <option value="user" <?php if($user['role'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </p>
        <button type="submit">Update Role</button>
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
