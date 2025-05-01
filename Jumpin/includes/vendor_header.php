<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Title  -->
    <title>jumpin - jump into it</title>

    <!-- Favicon  -->
    <link rel="icon" href="../public/img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="../public/css/core-style.css">
    <link rel="stylesheet" href="../public/style.css">

</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
    <?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success text-center">
        <?= htmlspecialchars($_GET['message']) ?>
    </div>
    <?php endif; ?>
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <img src="../public/img/core-img/shoe.png" style="height: 40px; width: auto;" alt="">
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="vendor_products.php">Products</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="user-login-info dropdown">
                    <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="../public/img/core-img/user.svg" alt="">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a class="dropdown-item" href="profile.php">Profile</a>
                            <a class="dropdown-item" href="../controllers/LogoutController.php">Logout</a>
                        <?php else: ?>
                            <a class="dropdown-item" href="register.php">Register</a>
                            <a class="dropdown-item" href="login.php">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->
