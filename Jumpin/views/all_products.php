<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}
include '../includes/admin_header.php';
require_once '../config/database.php';

$sql = "SELECT product_id, name, price, size, stock_quantity, imageName1, imageName2, brand_id FROM products";
$result = $conn->query($sql);
?>

<div class="container">
  <h2 class="mb-4">All Products</h2>
  <a href="../controllers/AddProduct.php" class="btn btn-success mb-3">Add Product</a>
  <table class="table table-bordered">
    <thead class="table-dark text-white">
      <tr>
        <th>Product ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Image 1</th>
        <th>Image 2</th>
        <th>Brand ID</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['product_id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= $row['price'] ?></td>
          <td><?= htmlspecialchars($row['size']) ?></td>
          <td><?= $row['stock_quantity'] ?></td>
          <td><?= htmlspecialchars($row['imageName1']) ?></td>
          <td><?= htmlspecialchars($row['imageName2']) ?></td>
          <td><?= $row['brand_id'] ?></td>
          <td>
            <a href="../controllers/EditProduct.php?id=<?= $row['product_id'] ?>" class="btn btn-warning">Edit</a>
            <a href="../controllers/DeleteProduct.php?id=<?= $row['product_id'] ?>" class="btn btn-danger">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
