<?php
class CartItemModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Add Item to Cart
    public function addItemToCart($cart_id, $product_id, $quantity) {
        $sql = "INSERT INTO Cart_Items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
        return $stmt->execute();
    }

    // 2. Update Cart Item
    public function updateCartItem($cart_item_id, $quantity) {
        $sql = "UPDATE Cart_Items SET quantity = ? WHERE cart_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $cart_item_id);
        return $stmt->execute();
    }

    // 3. Remove Item from Cart
    public function removeItemFromCart($cart_item_id) {
        $sql = "DELETE FROM Cart_Items WHERE cart_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cart_item_id);
        return $stmt->execute();
    }

    // 4. Get Cart Items
    public function getCartItems($cart_id) {
        $sql = "SELECT ci.*, p.name, p.price FROM Cart_Items ci
                JOIN Products p ON ci.product_id = p.product_id
                WHERE ci.cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 5. Get Cart Item by Product
    public function getCartItemByProduct($cart_id, $product_id) {
        $sql = "SELECT * FROM Cart_Items WHERE cart_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $cart_id, $product_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 6. Clear Cart (remove all items)
    public function clearCart($cart_id) {
        $sql = "DELETE FROM Cart_Items WHERE cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        return $stmt->execute();
    }

    // 7. Get Total Cart Value
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
