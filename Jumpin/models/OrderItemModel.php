<?php
class OrderItemModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Add Order Item
    public function addOrderItem($order_id, $product_id, $quantity, $price_at_time_of_order) {
        $sql = "INSERT INTO Order_Items (order_id, product_id, quantity, price_at_time_of_order) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price_at_time_of_order);
        return $stmt->execute();
    }

    // 2. Get Order Items by Order
    public function getOrderItemsByOrder($order_id) {
        $sql = "SELECT * FROM Order_Items WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 3. Get Order Item by ID
    public function getOrderItemById($order_item_id) {
        $sql = "SELECT * FROM Order_Items WHERE order_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_item_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 4. Update Order Item
    public function updateOrderItem($order_item_id, $quantity, $price_at_time_of_order) {
        $sql = "UPDATE Order_Items SET quantity = ?, price_at_time_of_order = ? WHERE order_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("idi", $quantity, $price_at_time_of_order, $order_item_id);
        return $stmt->execute();
    }

    // 5. Delete Order Item
    public function deleteOrderItem($order_item_id) {
        $sql = "DELETE FROM Order_Items WHERE order_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_item_id);
        return $stmt->execute();
    }

    // 6. Get Order Items by Product
    public function getOrderItemByProduct($product_id) {
        $sql = "SELECT * FROM Order_Items WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 7. Get Total Amount for Order
    public function getTotalAmountForOrder($order_id) {
        $sql = "SELECT SUM(quantity * price_at_time_of_order) AS total FROM Order_Items WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    // 8. Get All Items by Order
    public function getAllItemsByOrder($order_id) {
        $sql = "SELECT oi.*, p.name AS product_name FROM Order_Items oi 
                JOIN Products p ON oi.product_id = p.product_id WHERE oi.order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
