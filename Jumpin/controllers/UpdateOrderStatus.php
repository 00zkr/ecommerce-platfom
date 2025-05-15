<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../views/login.php");
  exit();
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $order_id = intval($_POST['order_id']);
  $status = $_POST['status'];

  $allowed_statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
  if (!in_array($status, $allowed_statuses)) {
    header("Location: ../views/all_orders.php?error=Invalid status");
    exit();
  }

  $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
  $stmt->bind_param("si", $status, $order_id);
  $stmt->execute();
  $stmt->close();

  header("Location: ../views/all_orders.php?message=Order status updated");
  exit();
} else {
  header("Location: ../views/all_orders.php?error=Invalid request");
  exit();
}
