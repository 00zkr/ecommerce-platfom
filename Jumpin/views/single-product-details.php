<?php
// Include database and controller
require_once '../config/database.php';
require_once '../controllers/ProductController.php';

// Get product ID from URL or other source
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;

// If product ID is not provided, show an error
if (!$productId) {
    echo "No product ID provided.";
    exit;
}

// Create a controller instance and fetch product details
$productController = new ProductController($conn);
$product = $productController->getProductDetails($productId);
include '../includes/header.php'; ?>
    <!-- ##### Single Product Details Area Start ##### -->
    <section class="single_product_details_area d-flex align-items-center">

        <!-- Single Product Thumb -->
        <div class="single_product_thumb clearfix">
            <div class="product_thumbnail_slides owl-carousel">
            <img src="../public/img/product-img/<?= $product['imageName1'] ?>" alt="">
            <img src="../public/img/product-img/<?= $product['imageName2'] ?>" alt="">
            </div>
        </div>

        <!-- Single Product Description -->
        <div class="single_product_desc clearfix">
        <span><?= htmlspecialchars($product['brand_name']) ?></span>
            <a href="cart.html">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
            </a>
            <p class="product-price">$<?= htmlspecialchars($product['price']) ?></p>
            <p class="product-desc"><?= htmlspecialchars($product['description']) ?></p>

            <!-- Form -->
            <form class="cart-form clearfix" method="post">
                <!-- Select Box -->
                <div class="select-box d-flex mt-50 mb-30">
                    <select name="select" id="productSize" class="mr-5">
                        <option value="value">Size: XL</option>
                        <option value="value">Size: X</option>
                        <option value="value">Size: M</option>
                        <option value="value">Size: S</option>
                    </select>
                </div>
                <!-- Cart & Favourite Box -->
                <div class="cart-fav-box d-flex align-items-center">
                    <!-- Cart -->
                    <button type="submit" name="addtocart" value="5" class="btn essence-btn">Add to cart</button>
                </div>
            </form>
        </div>
    </section>
    <!-- ##### Single Product Details Area End ##### -->

<?php include '../includes/footer.php'; ?>