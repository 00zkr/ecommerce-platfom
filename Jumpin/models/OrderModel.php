<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getOrdersByUserId($user_id) {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $orders = [];
        while ($order = $result->fetch_assoc()) {
            $order_id = $order['order_id'];
            $order['items'] = $this->getOrderItemsWithProductNames($order_id); // <-- This adds the "items" key
            $orders[] = $order;
        }
        return $orders;
    }

    private function getOrderItemsWithProductNames($order_id) {
        $sql = "SELECT oi.*, p.name as product_name
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                WHERE oi.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    

    public function getAllOrdersWithItems() {
        $sql = "SELECT o.*, u.full_name FROM orders o
                JOIN users u ON o.user_id = u.user_id
                ORDER BY o.order_date DESC";
        $result = $this->conn->query($sql);
    
        $orders = [];
        while ($order = $result->fetch_assoc()) {
            $order_id = $order['order_id'];
            $items = [];
    
            $item_sql = "SELECT oi.*, p.name AS product_name
                         FROM order_items oi
                         JOIN products p ON oi.product_id = p.product_id
                         WHERE oi.order_id = $order_id";
            $item_result = $this->conn->query($item_sql);
            while ($item = $item_result->fetch_assoc()) {
                $items[] = $item;
            }
    
            $order['items'] = $items;
            $orders[] = $order;
        }
    
        return $orders;
    }
    
    
    
}
?>
