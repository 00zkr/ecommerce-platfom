<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_id = intval($_POST['vendor_id']);
    $brand_id = isset($_POST['brand_id']) && $_POST['brand_id'] !== '' ? intval($_POST['brand_id']) : "NULL";
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $size = $conn->real_escape_string($_POST['size']);
    $stock_quantity = intval($_POST['stock_quantity']);

    $uploadDir = "../public/img/product-img/";
    $image1Name = basename($_FILES['image1']['name']);
    $image2Name = basename($_FILES['image2']['name']);

    $image1Path = $uploadDir . $image1Name;
    $image2Path = $uploadDir . $image2Name;

    if ($vendor_id <= 0) {
        $error = "Vendor ID is mandatory and must be positive.";
    } elseif (!move_uploaded_file($_FILES['image1']['tmp_name'], $image1Path) || 
              !move_uploaded_file($_FILES['image2']['tmp_name'], $image2Path)) {
        $error = "Image upload failed.";
    } else {
        $sql = "INSERT INTO products (vendor_id, brand_id, name, description, price, size, stock_quantity, imageName1, imageName2)
                VALUES ($vendor_id, $brand_id, '$name', '$description', $price, '$size', $stock_quantity, '$image1Name', '$image2Name')";

        if ($conn->query($sql)) {
            header("Location: ../views/all_products.php?message=Product added successfully");
            exit();
        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}

$brands = $conn->query("SELECT brand_id, name FROM brands");
include '../views/add_product.php';
