<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Create Order
    public function createOrder($user_id, $total_amount, $status, $order_items) {
        $this->conn->begin_transaction();
        try {
            // Insert Order
            $sql = "INSERT INTO Orders (user_id, total_amount, status) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ids", $user_id, $total_amount, $status);
            $stmt->execute();
            $order_id = $stmt->insert_id;

            // Insert Order Items
            foreach ($order_items as $item) {
                $this->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price_at_time_of_order']);
            }

            $this->conn->commit();
            return $order_id;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    // 2. Get Order by ID
    public function getOrderById($order_id) {
        $sql = "SELECT * FROM Orders WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 3. Get Orders by User
    public function getOrdersByUser($user_id) {
        $sql = "SELECT * FROM Orders WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 4. Get All Orders
    public function getAllOrders() {
        $sql = "SELECT * FROM Orders";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 5. Update Order
    public function updateOrder($order_id, $total_amount, $status) {
        $sql = "UPDATE Orders SET total_amount = ?, status = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("dsi", $total_amount, $status, $order_id);
        return $stmt->execute();
    }

    // 6. Delete Order
    public function deleteOrder($order_id) {
        $sql = "DELETE FROM Orders WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        return $stmt->execute();
    }

    // 7. Get Orders by Status
    public function getOrdersByStatus($status) {
        $sql = "SELECT * FROM Orders WHERE status = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 8. Get Latest Orders
    public function getLatestOrders($limit = 5) {
        $sql = "SELECT * FROM Orders ORDER BY order_date DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 9. Get Total Orders for User
    public function getTotalOrdersForUser($user_id) {
        $sql = "SELECT COUNT(*) AS total_orders FROM Orders WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total_orders'];
    }

    // Helper function to add items to an order (called inside createOrder())
    private function addOrderItem($order_id, $product_id, $quantity, $price_at_time_of_order) {
        $sql = "INSERT INTO Order_Items (order_id, product_id, quantity, price_at_time_of_order) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price_at_time_of_order);
        $stmt->execute();
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
    
    
}
?>
