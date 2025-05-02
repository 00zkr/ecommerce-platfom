<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'vendor') {
    header("Location: login.php");
    exit();
}
include '../includes/vendor_header.php';
require_once '../config/database.php';

$vendor_id = $_SESSION['user_id'];

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'vendor') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT product_id, name, price, size, stock_quantity, imageName1, imageName2, brand_id 
        FROM products 
        WHERE vendor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
  <h2 class="mb-4">My Products</h2>

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
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
