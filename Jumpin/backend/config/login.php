<?php
session_start();
include(__DIR__ . "/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['userName']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        die("Please fill in all fields.");
    }

    // Fetch user
    $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE userName = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Correct login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;

        header("Location: http://localhost/ecommerce-platfom/Jumpin/frontend/index.php"); // Correct redirect
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
