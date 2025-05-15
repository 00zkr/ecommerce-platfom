<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../config/database.php';

if (!isset($_GET['id'])) {
    die("Product ID is required");
}

$product_id = intval($_GET['id']);

// Delete from all tables referencing products first
$conn->query("DELETE FROM cart_items WHERE product_id = $product_id");
$conn->query("DELETE FROM inventory WHERE product_id = $product_id");
$conn->query("DELETE FROM order_items WHERE product_id = $product_id");

// Then delete product
$sql = "DELETE FROM products WHERE product_id = $product_id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../views/all_products.php?message=Product deleted");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
?>
