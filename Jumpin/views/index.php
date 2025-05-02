<?php
session_start();
include '../includes/header.php';
include '../config/database.php'; 
?>

<section class="welcome_area bg-img background-overlay" style="background-image: url(../public/img/bg-img/bg-1.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="hero-content">
                    <h6>jumpin</h6>
                    <h2>New Collection</h2>
                    <a href="shop.php" class="btn essence-btn">view collection</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="new_arrivals_area section-padding-80 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>Popular Products</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">
                    <?php
                    $query = "SELECT * FROM Products LIMIT 4";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <!-- Single Product -->
                    <div class="single-product-wrapper">
                        <div class="product-img">
                            <img src="../public/img/product-img/<?php echo $row['imageName1']; ?>" alt="">
                            <img class="hover-img" src="../public/img/product-img/<?php echo $row['imageName2']; ?>" alt="">
                        </div>
                        <div class="product-description">
                            <span><?php echo $row['brand_id']; ?></span>
                            <a href="single-product-details.php?product_id=<?php echo $row['product_id']; ?>">
                                <h6><?php echo $row['name']; ?></h6>
                            </a>
                            <p class="product-price">$<?php echo $row['price']; ?></p>

                            <!-- Add to Cart Form -->
                            <form action="../controllers/AddToCart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="number" name="quantity" value="1" min="1" required> <!-- Added quantity input -->
                                <div class="add-to-cart-btn">
                                    <button type="submit" name="add_to_cart" class="btn essence-btn">Add to Cart</button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>
