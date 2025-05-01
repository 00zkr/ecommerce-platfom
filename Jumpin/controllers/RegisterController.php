<?php
// Include the necessary database connection file
require_once '../config/database.php';
require_once '../models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = trim($_POST['Username']);
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordConfirmer = $_POST['passwordConfirmer'];

    // Validation
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($fullName)) {
        $errors[] = "Full name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if ($password !== $passwordConfirmer) {
        $errors[] = "Passwords do not match.";
    }

    // If there are errors, show them and don't process further
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='text-danger'>$error</p>";
        }
        exit;
    }

    // Create User model instance
    $userModel = new UserModel($db);

    // Call function to check if username or email already exists
    if ($userModel->checkUsernameExists($username)) {
        echo "<p class='text-danger'>Username already taken.</p>";
        exit;
    }

    if ($userModel->checkEmailExists($email)) {
        echo "<p class='text-danger'>Email already registered.</p>";
        exit;
    }

    // Register the user in the database
    $userId = $userModel->createUser($username, $email, $password, $fullName, "");

    if ($userId) {
        echo "<p class='text-success'>Registration successful. Please <a href='../views/login.php'>login</a> now.</p>";
    } else {
        echo "<p class='text-danger'>Registration failed. Please try again.</p>";
    }
}
?>
