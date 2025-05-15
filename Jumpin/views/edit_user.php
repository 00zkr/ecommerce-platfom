<?php include '../includes/header.php'; ?>

  <div class="container mt-5 mb-3">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm mt-2">
          <div class="card-header text-white">
            <h4 class="mb-0">Edit User</h4>
          </div>
          <div class="card-body">
            <?php if (!empty($error)) : ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="post" action="">
              <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input
                  type="text"
                  id="full_name"
                  name="full_name"
                  class="form-control"
                  value="<?php echo htmlspecialchars($user['full_name']); ?>"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input
                  type="text"
                  id="phone"
                  name="phone"
                  class="form-control"
                  value="<?php echo htmlspecialchars($user['phone']); ?>"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control"
                  value="<?php echo htmlspecialchars($user['email']); ?>"
                  required
                />
              </div>

              <div class="d-flex flex-column mb-4">
                <label for="role" class="form-label">Role</label>
                <select
                  id="role"
                  name="role"
                  class="form-select"
                  required
                >
                  <?php
                  $roles = ['client', 'vendor', 'admin'];
                  foreach ($roles as $role) {
                    $selected = ($user['role'] === $role) ? 'selected' : '';
                    echo "<option value=\"$role\" $selected>" . ucfirst($role) . "</option>";
                  }
                  ?>
                </select>
              </div>

              <button type="submit" class="btn btn-primary w-100">Update User</button>
            </form>
          </div>
          <div class="card-footer text-center">
            <a href="all_users.php" class="btn btn-link">Back to all users</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>


<?php include '../includes/footer.php'; ?>
