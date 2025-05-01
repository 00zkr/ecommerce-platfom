<?php
include '../includes/admin_header.php';
require_once '../config/database.php';

$sql = "SELECT user_id, username, email, full_name, phone, role, created_at FROM users";
$result = $conn->query($sql);
?>

<div class="container">
  <h2 class="mb-4">All Users</h2>

  <table class="table table-bordered">
    <thead class="table-dark text-white">
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Full Name</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['user_id'] ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= $row['role'] ?></td>
          <td><?= $row['created_at'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
