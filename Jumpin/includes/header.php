
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
                <a class="nav-brand" href="index.php" ><img src="../public/img/core-img/shoe.png" style="height: 40px; width: auto;" alt=""></a>
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
                            <li><a href="#">Shop</a>
                                <div class="megamenu">
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">Brands</li>
                                        <li><a href="shop.php">Nike</a></li>
                                        <li><a href="shop.php">Adidas </a></li>
                                        <li><a href="shop.php">Puma</a></li>
                                        <li><a href="shop.php">Reebok</a></li>
                                        <li><a href="shop.php">New Balance</a></li>
                                    </ul>
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">&nbsp;</li>
                                        <li><a href="shop.php">Converse</a></li>
                                        <li><a href="shop.php">Vans</a></li>
                                        <li><a href="shop.php">Under Armour</a></li>
                                        <li><a href="shop.php">Under Armour</a></li>
                                        <li><a href="shop.php">Dr. Martens</a></li>
                                    </ul>
                                    <ul class="single-mega cn-col-4"></ul>

                                    <div class="single-mega cn-col-4 align-left-image" >
                                        <img src="../public/img/bg-img/bg-6.jpg"  alt="" >
                                    </div>
                                </div>
                            </li>
                            <li><a href="cart.php">cart</a></li>
                            <li><a href="orders.php">orders</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- User Login Info -->
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
                
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="../views/cart.php" id="essenceCartBtn"><img src="../public/img/core-img/bag.svg" alt=""> <span>3</span></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->
