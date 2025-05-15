<?php include '../includes/admin_header.php'; ?>

<div class="container mt-5 mb-3" style="max-width: 600px;">
  <h2 class="mb-4">Add New User</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="AddUser.php">
    <div class="mb-3">
      <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
      <input
        type="text"
        class="form-control"
        id="username"
        name="username"
        required
        maxlength="255"
        value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
      >
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
      <input
        type="password"
        class="form-control"
        id="password"
        name="password"
        required
      >
    </div>

    <div class="mb-3">
      <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
      <input
        type="text"
        class="form-control"
        id="full_name"
        name="full_name"
        required
        maxlength="255"
        value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>"
      >
    </div>

    <div class="mb-3">
      <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
      <input
        type="text"
        class="form-control"
        id="phone"
        name="phone"
        required
        maxlength="50"
        value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>"
      >
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
      <input
        type="email"
        class="form-control"
        id="email"
        name="email"
        required
        maxlength="255"
        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
      >
    </div>

    <div class="d-flex flex-column mb-4">
      <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
      <select id="role" name="role" class="form-select" required>
        <?php
        $roles = ['client', 'vendor', 'admin'];
        foreach ($roles as $role) {
          $selected = (isset($_POST['role']) && $_POST['role'] === $role) ? 'selected' : '';
          echo "<option value=\"$role\" $selected>" . ucfirst($role) . "</option>";
        }
        ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Add User</button>
    <a href="all_users.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>

<?php include '../includes/admin_footer.php'; ?>
