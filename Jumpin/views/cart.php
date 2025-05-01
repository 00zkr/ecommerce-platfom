<?php
include '../includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

require_once '../config/database.php'; // contains $conn = new mysqli(...);
require_once '../models/CartModel.php';
require_once '../models/CartItemModel.php';


$cartModel = new CartModel($conn);
$cartItemModel = new CartItemModel($conn);
$cart = $cartModel->getCartByUser($user_id);
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
</div>
<?php include '../includes/footer.php';?>
