<?php
session_start();
include(__DIR__ . "../backend/config/config.php");

// Check if the user is logged in
// if (!isset($_SESSION['user'])) {
//     header('Location: login.php');
//     exit();
// }

// Get user info
$userId = $_SESSION['user']['id'];

// Fetch updated user data from database (optional but good practice)
$stmt = $conn->prepare('SELECT name, email FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <!-- Include Bootstrap or your CSS here -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>

<!-- Header Area -->
<header class="header-area">
    <!-- Navigation -->
    <div class="main-menu">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.php">Home</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Profile Content -->
<div class="container mt-5">
    <h2>My Profile</h2>
    <div class="card p-4">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
    </div>
</div>

<!-- Footer Area -->
<footer class="footer-area mt-5">
    <div class="container text-center">
        <p>&copy; 2025 Your Website Name</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="jquery.min.js"></script>
<script src="bootstrap.bundle.min.js"></script>

</body>
</html>
