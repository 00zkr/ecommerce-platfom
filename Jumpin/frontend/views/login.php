<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>jumpin - jump into it</title>
  <link rel="icon" href="../public/img/core-img/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/login.css" />
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
  <div class="card p-4 shadow login-card">
    <h5 class="text-center mb-4 fw-bold">Login to your account</h5>
    
    <form method="post" action="../backend/config/login.php">
      <div class="mb-3">
        <label class="form-label text-muted">Username</label>
        <input type="text" class="form-control" placeholder="Enter your username" name="userName">
      </div>
      <div class="mb-3">
        <label class="form-label text-muted">Password</label>
        <input type="password" class="form-control" placeholder="••••••••" name="password">
      </div>
      
      <button type="submit" class="btn btn-dark w-100 rounded-pill">Login</button>
    </form>
  </div>
</body>
</html>
