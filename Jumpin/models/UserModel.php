<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Create User
    public function createUser($username, $email, $password, $full_name, $phone, $role = 'client') {
        $sql = "INSERT INTO Users (username, email, password, full_name, phone, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $email, $password, $full_name, $phone, $role);
        return $stmt->execute();
    }

    // 2. Get User by ID
    public function getUserById($user_id) {
        $sql = "SELECT * FROM Users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 3. Get User by Username
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM Users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 4. Update User
    public function updateUser($user_id, $username, $email, $full_name, $phone, $role) {
        $sql = "UPDATE Users SET username = ?, email = ?, full_name = ?, phone = ?, role = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $email, $full_name, $phone, $role, $user_id);
        return $stmt->execute();
    }

    // 5. Delete User
    public function deleteUser($user_id) {
        $sql = "DELETE FROM Users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    // 6. Get All Clients
    public function getAllClients() {
        $sql = "SELECT * FROM Users WHERE role = 'client'";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 7. Get All Vendors
    public function getAllVendors() {
        $sql = "SELECT * FROM Users WHERE role = 'vendor'";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 8. Check if Username Exists
    public function checkUsernameExists($username) {
        $sql = "SELECT COUNT(*) FROM Users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    // 9. Check if Email Exists
    public function checkEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM Users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    // 10. Authenticate User (Check username and password)
    public function authenticateUser($username, $password) {
        $sql = "SELECT * FROM Users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && $password==$result['password']) {
            return $result;  // Return user data if authenticated
        }
        return null;  // Return null if authentication fails
    }
}
?>