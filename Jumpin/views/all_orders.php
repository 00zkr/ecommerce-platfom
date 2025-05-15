<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}
include '../includes/admin_header.php';

require_once '../config/database.php';
require_once '../models/OrderModel.php';

$user_id = $_SESSION['user_id'];
if (!$user_id) die("User ID missing");

$orderModel = new OrderModel($conn);
$orders = $orderModel->getAllOrdersWithItems();
$orders = array_filter($orders, fn($order) => !empty($order['items']));
?>

<style>
  body {
    background-color: #fff;
    color: #000;
  }
  .order-card {
    border: 1px solid #000;
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 6px;
    background-color: #f9f9f9;
  }
  .order-header {
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 1.1rem;
  }
  .table thead {
    background-color: #000 !important;
  }
  .table thead th {
    color: #fff !important;
    background-color: #000 !important;
    padding: 12px 15px;
    font-weight: 600;
    border-bottom: 2px solid #444;
  }
  .order-total {
    text-align: right;
    margin-top: 10px;
    font-size: 1.15rem;
  }
  .btn-blue {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
  }
  .btn-blue:hover {
    background-color: #0056b3;
    border-color: #004085;
    color: white;
  }
</style>

<div class="container mt-5 mb-5">
  <h2 class="mb-4 text-center">Orders for Admin #<?= htmlspecialchars($user_id) ?></h2>

  <?php if (empty($orders)): ?>
    <p class="text-center">No orders with items found.</p>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
      <div class="order-card shadow-sm">
        <div class="order-header">
          Order #<?= $order['order_id'] ?> | User: <?= htmlspecialchars($order['full_name']) ?> |
          Date: <?= $order['order_date'] ?> | Status: <?= htmlspecialchars($order['status']) ?>
        </div>
        <table class="table table-bordered">
          <thead>
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
                <td>$<?= number_format($item['price_at_time_of_order'], 2) ?></td>
                <td><?= intval($item['quantity']) ?></td>
                <td>$<?= number_format($item['price_at_time_of_order'] * $item['quantity'], 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="order-total">
          <strong>Total Amount: $<?= number_format($order['total_amount'], 2) ?></strong>
        </div>
        <div class="d-flex justify-content-end mt-3">
          <form method="post" action="../controllers/UpdateOrderStatus.php" class="d-inline">
            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
              <?php
              $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
              foreach ($statuses as $status) {
                $selected = ($order['status'] === $status) ? 'selected' : '';
                echo "<option value=\"$status\" $selected>" . ucfirst($status) . "</option>";
              }
              ?>
            </select>
          </form>
        </div>

        <div class="d-flex justify-content-end mt-3">
          <a href="../controllers/DeleteOrder.php?id=<?= $order['order_id'] ?>" class="btn btn-blue">
            Delete Order
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include '../includes/admin_footer.php'; ?>
