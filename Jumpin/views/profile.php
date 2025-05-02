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
}
?>

<div class="container">
  <h2 class="mb-4">Profile</h2>

  <div class="card">
    <div class="card-header bg-dark text-white">
      <h4>Profile Information</h4>
    </div>
    <div class="card-body">
      <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
      <p><strong>Role:</strong> <?= $user['role'] ?></p>
      <p><strong>Created At:</strong> <?= $user['created_at'] ?></p>
    </div>
  </div>

  <?php if ($_SESSION['role'] === 'admin'): ?>
    <div class="mt-4">
      <a href="edit_profile.php" class="btn btn-dark">Edit Profile</a>
    </div>
  <?php endif; ?>
</div>

<?php 
switch ($user['role']) {
  case 'client':
    include '../includes/footer.php'; 
    break;
  case 'vendor':
    include '../includes/admin_footer.php'; 
    break;
  case 'admin':
    include '../includes/admin_footer.php'; 
    break;
  default:
      header("Location: ../views/login.php?error=Unknown role");
}
?>
