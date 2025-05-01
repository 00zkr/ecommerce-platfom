<?php
session_start();
include(__DIR__ . "/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['Username']);
    $fullname = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['passwordConfirmer'];

    if (empty($username) || empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        die("Please fill in all fields.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        die("Email already registered.");
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO users (userName, fullName, email, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $username, $fullname, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../../frontend/index.php"); // REDIRECT properly
        exit();
    } else {
        echo "Something went wrong. Please try again.";
    }
}
?>
