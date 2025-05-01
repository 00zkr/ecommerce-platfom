<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Create Product
    public function createProduct($vendor_id, $name, $description, $price, $size, $stock_quantity, $imageName1 = null, $imageName2 = null) {
        $sql = "INSERT INTO Products (vendor_id, name, description, price, size, stock_quantity, imageName1, imageName2) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issdssis", $vendor_id, $name, $description, $price, $size, $stock_quantity, $imageName1, $imageName2);
        return $stmt->execute();
    }

    // 2. Get Product by ID
    public function getProductById($product_id) {
        $sql = "SELECT * FROM Products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 3. Get All Products
    public function getAllProducts() {
        $sql = "SELECT * FROM Products";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 4. Get Products by Vendor
    public function getProductsByVendor($vendor_id) {
        $sql = "SELECT * FROM Products WHERE vendor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $vendor_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 5. Update Product
    public function updateProduct($product_id, $name, $description, $price, $size, $stock_quantity, $imageName1 = null, $imageName2 = null) {
        $sql = "UPDATE Products SET name = ?, description = ?, price = ?, size = ?, stock_quantity = ?, imageName1 = ?, imageName2 = ? 
                WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdsisss", $name, $description, $price, $size, $stock_quantity, $imageName1, $imageName2, $product_id);
        return $stmt->execute();
    }

    // 6. Delete Product
    public function deleteProduct($product_id) {
        $sql = "DELETE FROM Products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        return $stmt->execute();
    }

    // 7. Update Stock Quantity
    public function updateStockQuantity($product_id, $quantity) {
        $sql = "UPDATE Products SET stock_quantity = stock_quantity + ? WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $product_id);
        return $stmt->execute();
    }

    // 8. Check Product Availability
    public function checkProductAvailability($product_id) {
        $sql = "SELECT stock_quantity FROM Products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['stock_quantity'] > 0 : false;
    }

    // 9. Search Products by Name
    public function searchProducts($search_term) {
        $sql = "SELECT * FROM Products WHERE name LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $search_term = "%$search_term%";  // Add wildcards for LIKE search
        $stmt->bind_param("s", $search_term);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 10. Get Products by Brand
public function getProductsByBrand($brand_id) {
    $sql = "SELECT p.*, b.name AS brand_name 
            FROM Products p
            JOIN Brands b ON p.brand_id = b.brand_id
            WHERE b.brand_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
}
?>