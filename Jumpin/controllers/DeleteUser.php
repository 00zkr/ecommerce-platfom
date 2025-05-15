<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../views/login.php");
  exit();
}

require_once '../config/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $user_id = intval($_GET['id']);

  // Get all order_ids of this user
  $result = $conn->prepare("SELECT order_id FROM orders WHERE user_id = ?");
  $result->bind_param("i", $user_id);
  $result->execute();
  $order_ids = $result->get_result()->fetch_all(MYSQLI_ASSOC);
  $result->close();

  // Delete order_items for each order
  if (!empty($order_ids)) {
    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    foreach ($order_ids as $row) {
      $stmt->bind_param("i", $row['order_id']);
      $stmt->execute();
    }
    $stmt->close();
  }

  // Delete from cart
  $stmt1 = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
  $stmt1->bind_param("i", $user_id);
  $stmt1->execute();
  $stmt1->close();

  // Delete from orders
  $stmt2 = $conn->prepare("DELETE FROM orders WHERE user_id = ?");
  $stmt2->bind_param("i", $user_id);
  $stmt2->execute();
  $stmt2->close();

  // Delete user
  $stmt3 = $conn->prepare("DELETE FROM users WHERE user_id = ?");
  $stmt3->bind_param("i", $user_id);
  $stmt3->execute();
  $stmt3->close();
}

header("Location: ../views/all_users.php?message=User deleted successfully");
exit();
