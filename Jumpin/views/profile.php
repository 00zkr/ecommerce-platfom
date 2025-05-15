<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
require_once '../config/database.php';

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

switch ($user['role']) {
  case 'client':
    include '../includes/header.php';
    break;
  case 'vendor':
    include '../includes/vendor_header.php';
    break;
  case 'admin':
    include '../includes/admin_header.php';
    break;
  default:
    header("Location: ../views/login.php?error=Unknown role");
    exit();
}
?>

<style>
  .profile-card {
    max-width: 600px;
    margin: 40px auto;
    box-shadow: 0 0 12px rgba(0,0,0,0.1);
    border-radius: 8px;
  }
  .profile-header {
    background-color: #000;
    color: #fff;
    padding: 20px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    text-align: center;
    font-weight: 600;
    font-size: 1.5rem;
  }
  .profile-body {
    padding: 25px 30px;
    font-size: 1.1rem;
  }
  .profile-body p {
    margin-bottom: 1.1rem;
  }
  .profile-label {
    font-weight: 600;
    color: #333;
  }
  .btn-edit {
    display: block;
    width: 160px;
    margin: 0 auto 20px;
  }
</style>

<div class="profile-card card">
  <div class="profile-header">Your Profile</div>
  <div class="profile-body">
    <p><span class="profile-label">Username:</span> <?= htmlspecialchars($user['username']) ?></p>
    <p><span class="profile-label">Email:</span> <?= htmlspecialchars($user['email']) ?></p>
    <p><span class="profile-label">Full Name:</span> <?= htmlspecialchars($user['full_name']) ?></p>
    <p><span class="profile-label">Phone:</span> <?= htmlspecialchars($user['phone']) ?></p>
    <p><span class="profile-label">Role:</span> <?= ucfirst($user['role']) ?></p>
    <p><span class="profile-label">Created At:</span> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
  </div>
</div>

  <a href="edit_profile.php" class="btn btn-dark btn-edit">Edit Profile</a>

<?php 
switch ($user['role']) {
  case 'client':
    include '../includes/footer.php'; 
    break;
  case 'vendor':
  case 'admin':
    include '../includes/admin_footer.php'; 
    break;
}
?>
