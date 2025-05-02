<?php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';



$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php'; // contains $conn = new mysqli(...);
require_once '../models/CartModel.php';
require_once '../models/CartItemModel.php';


$cartModel = new CartModel($conn);
$cartItemModel = new CartItemModel($conn);
$cart = $cartModel->getCartByUser($user_id);
if (!$cart) {
    echo "<p>Your cart is empty.</p>";
    include '../includes/footer.php';
    exit();
}
$items = $cartItemModel->getCartItems($cart['cart_id']);
$total = $cartItemModel->getTotalCartValue($cart['cart_id']);
?>

<div class="container py-5">
    <h2 class="mb-4">My Cart</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price (€)</th>
                <th>Quantity</th>
                <th>Subtotal (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="3" class="text-end">Total</td>
                <td><?= number_format($total, 2) ?> €</td>
            </tr>
        </tfoot>
    </table>
    <div class="checkout-btn">
    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
</div>
</div>
<?php include '../includes/footer.php';?>
