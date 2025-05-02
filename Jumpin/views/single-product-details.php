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
include '../includes/header.php'; 
// Create a controller instance and fetch product details
$productController = new ProductController($conn);
$product = $productController->getProductDetails($productId);
if (!$product) {
    echo "Product not found.";
    include '../includes/footer.php';
    exit;
}
?>
    <!-- ##### Single Product Details Area Start ##### -->
    <section class="single_product_details_area d-flex align-items-center">

        <!-- Single Product Thumb -->
        <div class="single_product_thumb">
            <div class="product_thumbnail_slides">
                <img class="product-image" src="../public/img/product-img/<?= $product['imageName1'] ?>">
                <img class="product-image" src="../public/img/product-img/<?= $product['imageName2'] ?>">
            </div>
        </div>

        <!-- Single Product Description -->
        <div class="single_product_desc clearfix">
            <a href="cart.html">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
            </a>
            <p class="product-price">$<?= htmlspecialchars($product['price']) ?></p>
            <p class="product-desc"><?= htmlspecialchars($product['description']) ?></p>

            <!-- Form -->

                <!-- Cart & Favourite Box -->
                <div class="cart-fav-box d-flex align-items-center">
                    <form action="../controllers/AddToCart.php" method="post" class="d-flex align-items-center">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <input type="number" name="quantity" value="1" min="1" required class="me-3"> <!-- added spacing -->
                        <div class="add-to-cart-btn">
                            <button type="submit" name="add_to_cart" class="btn essence-btn">Add to Cart</button>
                        </div>
                    </form>
                </div>
        </div>
    </section>
    <!-- ##### Single Product Details Area End ##### -->

<?php include '../includes/footer.php'; ?>