<?php
class CartModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Create Cart for User
    public function createCart($user_id) {
        $sql = "INSERT INTO Cart (user_id) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    // 2. Get Cart by User ID
    public function getCartByUser($user_id) {
        $sql = "SELECT * FROM Cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 3. Delete Cart
    public function deleteCart($cart_id) {
        $sql = "DELETE FROM Cart WHERE cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        return $stmt->execute();
    }
}
?>
