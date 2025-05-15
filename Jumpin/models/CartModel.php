<?php
class CartModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Cart by User ID
    public function getCartByUser($user_id) {
        $sql = "SELECT * FROM Cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Delete Cart
    public function deleteCart($cart_id) {
        $sql = "DELETE FROM Cart WHERE cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        return $stmt->execute();
    }
}
?>
