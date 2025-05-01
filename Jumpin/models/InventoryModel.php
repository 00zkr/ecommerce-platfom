<?php
class InventoryModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Add Inventory for Product
    public function addInventory($product_id, $vendor_id, $stock_quantity) {
        $sql = "INSERT INTO Inventory (product_id, vendor_id, stock_quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $product_id, $vendor_id, $stock_quantity);
        return $stmt->execute();
    }

    // 2. Update Inventory Stock Quantity
    public function updateInventory($inventory_id, $stock_quantity) {
        $sql = "UPDATE Inventory SET stock_quantity = ? WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $stock_quantity, $inventory_id);
        return $stmt->execute();
    }

    // 3. Get Inventory by Product
    public function getInventoryByProduct($product_id) {
        $sql = "SELECT * FROM Inventory WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 4. Get Inventory by Vendor
    public function getInventoryByVendor($vendor_id) {
        $sql = "SELECT * FROM Inventory WHERE vendor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $vendor_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 5. Get All Inventory
    public function getAllInventory() {
        $sql = "SELECT * FROM Inventory";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 6. Decrease Stock Quantity (e.g., on purchase)
    public function decreaseStockQuantity($inventory_id, $quantity) {
        $sql = "UPDATE Inventory SET stock_quantity = stock_quantity - ? WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $inventory_id);
        return $stmt->execute();
    }

    // 7. Increase Stock Quantity (e.g., on restock)
    public function increaseStockQuantity($inventory_id, $quantity) {
        $sql = "UPDATE Inventory SET stock_quantity = stock_quantity + ? WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $inventory_id);
        return $stmt->execute();
    }
}
?>
