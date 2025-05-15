<?php
session_start();
include '../includes/header.php';
include '../config/database.php';

// Fetch brands from DB
$brands_result = $db->query("SELECT brand_id, name FROM brands ORDER BY name ASC");
$brands = $brands_result->fetch_all(MYSQLI_ASSOC);
$brands_result->close();

// Pagination setup
$limit = 9;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Get selected brand from URL if exists
$selected_brand = isset($_GET['brand']) && is_numeric($_GET['brand']) ? intval($_GET['brand']) : null;

// Count total products (filtered if brand selected)
if ($selected_brand) {
    $stmt_count = $db->prepare("SELECT COUNT(*) AS total FROM products WHERE brand_id = ?");
    $stmt_count->bind_param("i", $selected_brand);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $total_products = $row_count['total'];
    $stmt_count->close();
} else {
    $result_count = $db->query("SELECT COUNT(*) AS total FROM products");
    $row_count = $result_count->fetch_assoc();
    $total_products = $row_count['total'];
}

$total_pages = ceil($total_products / $limit);

// Fetch products filtered by brand if selected
if ($selected_brand) {
    $stmt = $db->prepare("SELECT * FROM products WHERE brand_id = ? LIMIT ?, ?");
    $stmt->bind_param("iii", $selected_brand, $offset, $limit);
} else {
    $stmt = $db->prepare("SELECT * FROM products LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $limit);
}
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
                    <h2>Sneakers</h2>
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
                            <ul class="sub-menu collapse show">
                                <?php foreach ($brands as $brand): ?>
                                    <li>
                                        <a href="?brand=<?= urlencode($brand['brand_id']) ?>">
                                            <?= htmlspecialchars($brand['name']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <li><a href="?" style="font-weight: bold;">Show All</a></li>
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
                                    </div>

                                    <div class="product-description">
                                        <span><?= !empty($product['brand']) ? htmlspecialchars($product['brand']) : 'Generic Brand' ?></span>
                                        <a href="single-product-details.php?product_id=<?= $product['product_id'] ?>">
                                            <h6><?= htmlspecialchars($product['name']) ?></h6>
                                        </a>
                                        <p class="product-price">
                                            $<?= $product['price'] ?>
                                        </p>
                                        <form action="../controllers/AddToCart.php" method="post">
                                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                            <input type="number" name="quantity" value="1" min="1" required>
                                            <div class="add-to-cart-btn">
                                                <button type="submit" name="add_to_cart" class="btn essence-btn">Add to Cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Pagination -->
                <?php
                $queryParams = [];
                if ($selected_brand) {
                    $queryParams['brand'] = $selected_brand;
                }
                ?>
                <nav aria-label="navigation">
                    <ul class="pagination mt-50 mb-70">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($queryParams, ['page' => $page - 1])) ?>">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($queryParams, ['page' => $i])) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($queryParams, ['page' => $page + 1])) ?>">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
