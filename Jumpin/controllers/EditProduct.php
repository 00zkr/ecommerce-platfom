<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../config/database.php';

// Get product ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}
$product_id = (int)$_GET['id'];

// Fetch brands for dropdown
$brandsResult = $conn->query("SELECT brand_id, name FROM brands ORDER BY name");

// Fetch product data
$productResult = $conn->query("SELECT * FROM products WHERE product_id = $product_id");
if ($productResult->num_rows === 0) {
    die("Product not found.");
}
$product = $productResult->fetch_assoc();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = $conn->real_escape_string(trim($_POST['name']));
    $price = floatval($_POST['price']);
    $size = $conn->real_escape_string(trim($_POST['size']));
    $stock_quantity = intval($_POST['stock_quantity']);
    $imageName1 = $conn->real_escape_string(trim($_POST['imageName1']));
    $imageName2 = $conn->real_escape_string(trim($_POST['imageName2']));
    $brand_id = intval($_POST['brand_id']);

    // Validate brand exists
    $brandCheck = $conn->query("SELECT brand_id FROM brands WHERE brand_id = $brand_id");
    if ($brandCheck->num_rows === 0) {
        $error = "Selected brand is invalid.";
    } else {
        // Update product
        $sql = "UPDATE products SET
            name = '$name',
            price = $price,
            size = '$size',
            stock_quantity = $stock_quantity,
            imageName1 = '$imageName1',
            imageName2 = '$imageName2',
            brand_id = $brand_id
            WHERE product_id = $product_id";

        if ($conn->query($sql)) {
            header("Location: ../views/all_products.php?message=Product updated successfully");
            exit();
        } else {
            $error = "Error updating product: " . $conn->error;
        }
    }
}

include '../views/edit_product.php';
?>
