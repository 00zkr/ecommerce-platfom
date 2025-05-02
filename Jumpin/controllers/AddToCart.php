<?php
// Include the database connection file directly
require_once '../config/database.php'; // Ensure this path is correct

// Check if the form was submitted
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Ensure both product_id and quantity are provided
    if (empty($product_id) || empty($quantity)) {
        die("Product ID and quantity are required.");
    }

    // Check if the user is logged in (assuming session is already started)
    session_start();
    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to add items to the cart.");
    }

    $user_id = $_SESSION['user_id'];

    // Check if the user already has a cart
    $check_cart_query = "SELECT * FROM Cart WHERE user_id = ?";
    $stmt = $conn->prepare($check_cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the user doesn't have a cart, create one
    if ($result->num_rows == 0) {
        $create_cart_query = "INSERT INTO Cart (user_id) VALUES (?)";
        $stmt = $conn->prepare($create_cart_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_id = $stmt->insert_id;  // Get the newly created cart_id
    } else {
        // If the user already has a cart, fetch the cart_id
        $cart = $result->fetch_assoc();
        $cart_id = $cart['cart_id'];
    }

    // Check if the product already exists in the cart
    $check_product_query = "SELECT * FROM Cart_Items WHERE cart_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_product_query);
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the product exists, update the quantity
        $update_query = "UPDATE Cart_Items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("iii", $quantity, $cart_id, $product_id);
    } else {
        // If the product does not exist, insert it into the cart
        $insert_query = "INSERT INTO Cart_Items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
    }

    $stmt->execute();

    // Redirect to the cart page or show a success message
    header("Location: ../views/index.php?message=Added to cart");
    exit();
}
?>
