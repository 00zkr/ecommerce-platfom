<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    // Get Product by ID
    public function getProductById($product_id) {
        $sql = "SELECT * FROM Products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


}
?>