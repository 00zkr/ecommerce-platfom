<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

require_once '../config/database.php';

$user_id = $_SESSION['user_id'];

// Fetch current user data
$sql = "SELECT username, email, full_name, phone FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize inputs
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Basic validation
    if (!$username) $errors[] = "Username is required.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (!$full_name) $errors[] = "Full name is required.";
    if (!$phone) $errors[] = "Phone is required.";

    if (empty($errors)) {
        // Update the user data
        $updateSql = "UPDATE users SET username = ?, email = ?, full_name = ?, phone = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssi", $username, $email, $full_name, $phone, $user_id);

        if ($updateStmt->execute()) {
            $success = "Profile updated successfully.";
            // Refresh user data
            $user = ['username' => $username, 'email' => $email, 'full_name' => $full_name, 'phone' => $phone];
        } else {
            $errors[] = "Database error: could not update profile.";
        }
    }
}

switch ($_SESSION['role']) {
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
  .edit-profile-container {
    max-width: 500px;
    margin: 40px auto;
  }
  .form-label {
    font-weight: 600;
  }
  .alert {
    margin-bottom: 20px;
  }
</style>

<div class="edit-profile-container">
  <h2 class="mb-4 text-center">Edit Profile</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" novalidate>
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="full_name" class="form-label">Full Name</label>
      <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="phone" class="form-label">Phone</label>
      <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
    </div>

    <button type="submit" class="btn btn-dark w-100">Save Changes</button>
    <a href="profile.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
  </form>
</div>

<?php 
switch ($_SESSION['role']) {
  case 'client':
    include '../includes/footer.php'; 
    break;
  case 'vendor':
  case 'admin':
    include '../includes/admin_footer.php'; 
    break;
}
?>
