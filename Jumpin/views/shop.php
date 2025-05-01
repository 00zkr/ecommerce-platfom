<?php
include '../includes/header.php';
include '../config/database.php';

// Pagination setup
$limit = 9;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total products
$result_count = $db->query("SELECT COUNT(*) AS total FROM products");
$row_count = $result_count->fetch_assoc();
$total_products = $row_count['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products
$stmt = $db->prepare("SELECT * FROM products LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!-- Breadcumb -->
<div class="breadcumb_area bg-img" style="background-image: url(../public/img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Dresses</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shop Grid -->
<section class="shop_grid_area section-padding-80">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="shop_sidebar_area">
                    <div class="widget catagory mb-50">
                        <h6 class="widget-title mb-30">Categories</h6>
                        <div class="catagories-menu">
                            <ul class="menu-content collapse show">
                                <li>
                                    <a href="#" style="color: black; font-size:small;">Brands</a>
                                    <ul class="sub-menu collapse show">
                                        <li><a href="#">Nike</a></li>
                                        <li><a href="#">Adidas</a></li>
                                        <li><a href="#">Puma</a></li>
                                        <li><a href="#">Reebok</a></li>
                                        <li><a href="#">New Balance</a></li>
                                        <li><a href="#">Converse</a></li>
                                        <li><a href="#">Vans</a></li>
                                        <li><a href="#">Under Armour</a></li>
                                        <li><a href="#">Dr. Martens</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="col-12 col-md-8 col-lg-9">
                <div class="shop_grid_product_area">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="product-topbar d-flex align-items-center justify-content-between">
                                <div class="total-products">
                                    <p><span><?= $total_products ?></span> products found</p>
                                </div>
                                <div class="product-sorting d-flex">
                                    <p>Sort by:</p>
                                    <form action="#" method="get">
                                        <select name="select" id="sortByselect">
                                            <option value="rating">Highest Rated</option>
                                            <option value="newest">Newest</option>
                                            <option value="price_desc">Price: $$ - $</option>
                                            <option value="price_asc">Price: $ - $$</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                <div class="single-product-wrapper w-100">
                                    <div class="product-img">
                                        <img src="../public/img/product-img/<?= htmlspecialchars($product['imageName1']) ?>" alt="">
                                        <img class="hover-img" src="../public/img/product-img/<?= htmlspecialchars($product['imageName2']) ?>" alt="">

                                        <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
                                            <div class="product-badge offer-badge">
                                                <span>-<?= round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) ?>%</span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="product-favourite">
                                            <a href="#" class="favme fa fa-heart"></a>
                                        </div>
                                    </div>

                                    <div class="product-description">
                                        <span><?= !empty($product['brand']) ? htmlspecialchars($product['brand']) : 'Generic Brand' ?></span>
                                        <a href="single-product-details.php?product_id=<?= $product['product_id'] ?>">
                                            <h6><?= htmlspecialchars($product['name']) ?></h6>
                                        </a>
                                        <p class="product-price">
                                            <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
                                                <span class="old-price">$<?= $product['old_price'] ?></span>
                                            <?php endif; ?>
                                            $<?= $product['price'] ?>
                                        </p>
                                        <div class="hover-content">
                                            <div class="add-to-cart-btn">
                                                <a href="add-to-cart.php?id=<?= $product['product_id'] ?>" class="btn essence-btn">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="navigation">
                    <ul class="pagination mt-50 mb-70">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa fa-angle-left"></i></a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa fa-angle-right"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
