<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php';
require_once '../models/CartModel.php';
require_once '../models/CartItemModel.php';

$user_id = $_SESSION['user_id'];
$cartModel = new CartModel($conn);
$cartItemModel = new CartItemModel($conn);
$cart = $cartModel->getCartByUser($user_id);
$items = $cartItemModel->getCartItems($cart['cart_id']);
$total = $cartItemModel->getTotalCartValue($cart['cart_id']);

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_time_of_order) VALUES (?, ?, ?, ?)");

    foreach ($items as $item) {
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt->bind_param("i", $cart['cart_id']);
    $stmt->execute();

    $conn->commit();
    header("Location: ../views/index.php?message=Order placed seccusfully");
} catch (Exception $e) {
    $conn->rollback();
    echo "Order failed: " . $e->getMessage();
}
?>
