<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!-- Title  -->
  <title>jumpin - jump into it</title>

  <!-- Favicon  -->
  <link rel="icon" href="../public/img/core-img/favicon.ico">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/register.css" />
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
  <div class="card p-4 shadow login-card">
    <h5 class="text-center mb-4 fw-bold">Create an account</h5>
    <form  method="post" action="../controllers/RegisterController.php">
      <div class="mb-3">
        <label class="form-label text-muted">Username</label>
        <input type="text" class="form-control" name="Username" placeholder="userName">
      </div>
      <div class="mb-3">
        <label class="form-label text-muted">Full Name</label>
        <input type="text" class="form-control" placeholder="Full name" name="fullName">
      </div>
      <div class="mb-3">
        <label class="form-label text-muted">Email</label>
        <input type="email" class="form-control" placeholder="you@example.com" name="email">
      </div>
      <div class="mb-3">
        <label class="form-label text-muted">Password</label>
        <input type="password" class="form-control" placeholder="••••••••" name="password">
      </div>
      <div class="mb-3">
        <label class="form-label text-muted">Confirm Password</label>
        <input type="password" class="form-control" placeholder="••••••••" name="passwordConfirmer">
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="terms">
        <label class="form-check-label small text-muted" for="terms">
          I agree to the terms and conditions
        </label>
      </div>
      <button type="submit" class="btn btn-dark w-100 rounded-pill">Register</button>
    </form>
  </div>
</body>
</html>
