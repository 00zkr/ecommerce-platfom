<?php
class BrandModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Create a new Brand
    public function createBrand($name) {
        $sql = "INSERT INTO Brands (name) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    // 2. Get a Brand by ID
    public function getBrandById($brand_id) {
        $sql = "SELECT * FROM Brands WHERE brand_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 3. Get a Brand by Name
    public function getBrandByName($name) {
        $sql = "SELECT * FROM Brands WHERE name = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 4. Get All Brands
    public function getAllBrands() {
        $sql = "SELECT * FROM Brands";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 5. Update Brand Name
    public function updateBrand($brand_id, $name) {
        $sql = "UPDATE Brands SET name = ? WHERE brand_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $name, $brand_id);
        return $stmt->execute();
    }

    // 6. Delete a Brand
    public function deleteBrand($brand_id) {
        $sql = "DELETE FROM Brands WHERE brand_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        return $stmt->execute();
    }
}
?>
