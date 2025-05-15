<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create User
    public function createUser($username, $email, $password, $full_name, $phone, $role = 'client') {
        $sql = "INSERT INTO Users (username, email, password, full_name, phone, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $email, $password, $full_name, $phone, $role);
        return $stmt->execute();
    }

    // Check if Username Exists
    public function checkUsernameExists($username) {
        $sql = "SELECT COUNT(*) FROM Users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    // Check if Email Exists
    public function checkEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM Users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    // Authenticate User (Check username and password)
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