<?php
require_once '../config/database.php'; // Include database connection
require_once '../models/UserModel.php'; // Include the UserModel

class LoginController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);  // Instantiate UserModel with DB connection
    }

    public function loginUser($username, $password) {
        // Attempt to authenticate the user
        $user = $this->userModel->authenticateUser($username, $password);

        if ($user) {
            // Login successful: Set session or redirect
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the home page or dashboard based on user role
            header("Location: ../views/index.php");
            exit();
        } else {
            // Login failed: Redirect back with error message
            header("Location: ../views/login.php?error=Invalid username or password");
            exit();
        }
    }
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['userName'] ?? '';
    $password = $_POST['password'] ?? '';

    // Create a new controller instance and call loginUser method
    $controller = new LoginController($conn);
    $controller->loginUser($username, $password);
}
?>
