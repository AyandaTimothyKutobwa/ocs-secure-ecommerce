<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';
include 'activity_log.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $newRole = $_POST['role'] === 'admin' ? 'admin' : 'user';  // Basic validation

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $newRole, $id);
    if ($stmt->execute()) {
        // Log role update
        logActivity($conn, $_SESSION['userid'], "Changed role for user ID $id to $newRole");
        header("Location: dashboard.php?msg=Role updated successfully");
        exit();
    } else {
        echo "Error updating role.";
    }
    $stmt->close();
} else {
    header("Location: dashboard.php");
    exit();
}
