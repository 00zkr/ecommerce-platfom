<?php
// config.php for database connection
$servername = "localhost";
$username = "root";  // default XAMPP MySQL username
$password = "";      // default XAMPP MySQL password (empty)
$dbname = "ecommerce_db";  // name of the database

// Create connection to MySQL server
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created or already exists.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);

// SQL to create the tables
$createUsersTable = "CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('client', 'vendor', 'admin') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$createBrandsTable = "CREATE TABLE IF NOT EXISTS Brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)";

$createProductsTable = "CREATE TABLE IF NOT EXISTS Products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand_id INT,
    price DECIMAL(10, 2) NOT NULL,
    size VARCHAR(50),
    imageName1 VARCHAR(255),
    imageName2 VARCHAR(255),
    FOREIGN KEY (brand_id) REFERENCES Brands(id)
)";

$createInventoryTable = "CREATE TABLE IF NOT EXISTS Inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    stock_quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES Products(id)
)";

$createOrdersTable = "CREATE TABLE IF NOT EXISTS Orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2),
    status ENUM('pending', 'completed', 'shipped') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";

$createOrderItemsTable = "CREATE TABLE IF NOT EXISTS Order_Items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price_at_time_of_order DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES Orders(id),
    FOREIGN KEY (product_id) REFERENCES Products(id)
)";

$createCartTable = "CREATE TABLE IF NOT EXISTS Cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id)
)";

$createCartItemsTable = "CREATE TABLE IF NOT EXISTS Cart_Items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (cart_id) REFERENCES Cart(id),
    FOREIGN KEY (product_id) REFERENCES Products(id)
)";

// Run the queries to create the tables
$conn->query($createUsersTable);
$conn->query($createBrandsTable);
$conn->query($createProductsTable);
$conn->query($createInventoryTable);
$conn->query($createOrdersTable);
$conn->query($createOrderItemsTable);
$conn->query($createCartTable);
$conn->query($createCartItemsTable);

// Sample data insertion
$conn->query("INSERT INTO Brands (name) VALUES ('Adidas')");
$conn->query("INSERT INTO Brands (name) VALUES ('Nike')");
$conn->query("INSERT INTO Brands (name) VALUES ('Puma')");

$conn->query("INSERT INTO Users (full_name, phone, role) VALUES ('Client 1', '1234567890', 'client')");
$conn->query("INSERT INTO Users (full_name, phone, role) VALUES ('Client 2', '1234567891', 'client')");
$conn->query("INSERT INTO Users (full_name, phone, role) VALUES ('Client 3', '1234567892', 'client')");
$conn->query("INSERT INTO Users (full_name, phone, role) VALUES ('Vendor 1', '1234567893', 'vendor')");
$conn->query("INSERT INTO Users (full_name, phone, role) VALUES ('Vendor 2', '1234567894', 'vendor')");
$conn->query("INSERT INTO Users (full_name, phone, role) VALUES ('Admin', '1234567895', 'admin')");

$conn->query("INSERT INTO Products (name, brand_id, price, size, imageName1, imageName2) VALUES ('Adidas Ultraboost 22', 1, 180.00, '10', 'ultraboost1.jpg', 'ultraboost2.jpg')");
$conn->query("INSERT INTO Products (name, brand_id, price, size, imageName1, imageName2) VALUES ('Nike Air Max 270', 2, 160.00, '11', 'airmax1.jpg', 'airmax2.jpg')");
$conn->query("INSERT INTO Products (name, brand_id, price, size, imageName1, imageName2) VALUES ('Puma RS-X3 Puzzle', 3, 120.00, '9', 'puma1.jpg', 'puma2.jpg')");

echo "Sample data inserted successfully.<br>";

// Close the connection
$conn->close();
?>
