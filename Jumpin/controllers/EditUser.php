<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/login.php");
    exit();
}

require_once '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid user ID.");
}
$user_id = (int)$_GET['id'];

$error = '';
$success = '';

// Fetch user data for form
$userResult = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
if ($userResult->num_rows === 0) {
    die("User not found.");
}
$user = $userResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $role = $_POST['role'];

    $allowed_roles = ['client', 'vendor', 'admin'];
    if (!in_array($role, $allowed_roles)) {
        $error = "Invalid role selected.";
    } else {
        $sql = "UPDATE users SET
                full_name = '$full_name',
                phone = '$phone',
                email = '$email',
                role = '$role'
                WHERE user_id = $user_id";

        if ($conn->query($sql)) {
            header("Location: ../views/all_users.php?message=User updated successfully");
            exit();
        } else {
            $error = "Error updating user: " . $conn->error;
        }
    }
}

include '../views/edit_user.php';
?>
