<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../views/login.php");
  exit();
}

require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];
  $full_name = trim($_POST['full_name']);
  $phone = trim($_POST['phone']);
  $email = trim($_POST['email']);
  $role = $_POST['role'];

  $allowed_roles = ['client', 'vendor', 'admin'];

  // Basic validations
  if (!$username || !$password || !$full_name || !$phone || !$email) {
    $error = "All fields marked with * are required.";
  } elseif (!in_array($role, $allowed_roles)) {
    $error = "Invalid role selected.";
  } else {
    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "Username or email already exists.";
      $stmt->close();
    } else {
      $stmt->close();

      // Hash password
      $password_hash = password_hash($password, PASSWORD_DEFAULT);

      // Insert user
      $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, phone, email, role) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $username, $password_hash, $full_name, $phone, $email, $role);

      if ($stmt->execute()) {
        $stmt->close();
        header("Location: ../views/all_users.php?message=User added successfully");
        exit();
      } else {
        $error = "Database error: " . $stmt->error;
      }
      $stmt->close();
    }
  }
}

include '../views/add_user.php';
?>
