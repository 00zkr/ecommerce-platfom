<?php
class CartItemModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Cart Items
    public function getCartItems($cart_id) {
        $sql = "SELECT ci.*, p.name, p.price FROM Cart_Items ci
                JOIN Products p ON ci.product_id = p.product_id
                WHERE ci.cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    // Get Total Cart Value
    public function getTotalCartValue($cart_id) {
        $sql = "SELECT SUM(ci.quantity * p.price) AS total 
                FROM Cart_Items ci
                JOIN Products p ON ci.product_id = p.product_id
                WHERE ci.cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
}
?>
