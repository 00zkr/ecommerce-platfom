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

// Find affected orders before deleting order_items
$result = $conn->query("SELECT DISTINCT order_id FROM order_items WHERE product_id = $product_id");
$affectedOrders = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $affectedOrders[] = intval($row['order_id']);
    }
}

// Delete order_items with the product
$conn->query("DELETE FROM order_items WHERE product_id = $product_id");

// Update total_amount for affected orders
foreach ($affectedOrders as $orderId) {
    $res = $conn->query("SELECT SUM(price_at_time_of_order * quantity) AS new_total FROM order_items WHERE order_id = $orderId");
    $newTotal = 0;
    if ($res && $row = $res->fetch_assoc()) {
        $newTotal = $row['new_total'] ?? 0;
    }
    $conn->query("UPDATE orders SET total_amount = $newTotal WHERE order_id = $orderId");
}

// Then delete product
$sql = "DELETE FROM products WHERE product_id = $product_id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../views/all_products.php?message=Product deleted");
    exit();
} else {
    echo "Error deleting product: " . $conn->error;
}
?>
