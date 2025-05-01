<?php
include '../includes/header.php';

require_once '../config/database.php'; // Your DB connection
require_once '../models/OrderModel.php';


$user_id = $_SESSION['user_id'];
if (!$user_id) die("User ID missing");

$orderModel = new OrderModel($conn);
$orders = $orderModel->getOrdersByUserId($user_id);
?>



<div class="container">
  <h2 class="mb-4">Orders for User #<?= htmlspecialchars($user_id) ?></h2>

  <?php foreach ($orders as $order): ?>
    <div class="order-card">
      <div class="order-header mb-2">
        Order #<?= $order['order_id'] ?> | Date: <?= $order['order_date'] ?> | Status: <?= $order['status'] ?> | Total: $<?= $order['total_amount'] ?>
      </div>
      <table class="table table-bordered item-table">
        <thead class="table-dark text-white">
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($order['items'] as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['product_name']) ?></td>
            <td>$<?= $item['price_at_time_of_order'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>$<?= number_format($item['price_at_time_of_order'] * $item['quantity'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endforeach; ?>
</div>
<?php include '../includes/footer.php';?>