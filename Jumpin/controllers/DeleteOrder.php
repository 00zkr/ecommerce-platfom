<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../views/login.php");
  exit();
}

require_once '../config/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $order_id = intval($_GET['id']);

  // Delete order items first (due to FK constraints)
  $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
  $stmt->bind_param("i", $order_id);
  $stmt->execute();
  $stmt->close();

  // Then delete the order
  $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
  $stmt->bind_param("i", $order_id);
  $stmt->execute();
  $stmt->close();

  header("Location: ../views/all_orders.php?message=Order deleted successfully");
  exit();
} else {
  header("Location: ../views/all_orders.php?error=Invalid order ID");
  exit();
}
?>
