-- Create tables
CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    role ENUM('client', 'vendor', 'admin') DEFAULT 'client',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_id INT,
    brand_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    size VARCHAR(50) NOT NULL,
    stock_quantity INT NOT NULL,
    imageName1 VARCHAR(255),
    imageName2 VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES Users(user_id),
    FOREIGN KEY (brand_id) REFERENCES Brands(brand_id)
);


CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Cart_Items (
    cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    product_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES Cart(cart_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

CREATE TABLE Brands (
    brand_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE Order_Items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price_at_time_of_order DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

CREATE TABLE Inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    vendor_id INT,
    stock_quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES Products(product_id),
    FOREIGN KEY (vendor_id) REFERENCES Users(user_id)
);


-- fill in the tables with data
INSERT INTO Users (username, email, password, full_name, phone, role) VALUES
('client1', 'client1@example.com', 'pass123', 'Alice Smith', '0700000001', 'client'),
('client2', 'client2@example.com', 'pass123', 'Bob Jones', '0700000002', 'client'),
('client3', 'client3@example.com', 'pass123', 'Charlie Lee', '0700000003', 'client'),
('vendor1', 'vendor1@example.com', 'pass123', 'Diana Moore', '0700000004', 'vendor'),
('vendor2', 'vendor2@example.com', 'pass123', 'Ethan Hall', '0700000005', 'vendor'),
('vendor3', 'vendor3@example.com', 'pass123', 'Fiona Clark', '0700000006', 'vendor'),
('admin1', 'admin1@example.com', 'adminpass', 'George King', '0700000007', 'admin');

INSERT INTO Brands (name) VALUES
('Adidas'),
('Nike'),
('Puma');

INSERT INTO Products (vendor_id, brand_id, name ,description, price, size, stock_quantity, imageName1, imageName2, created_at)
VALUES
(4, 1, 'Adidas Ultraboost 22', 'High-performance running shoe.', 180.00, '42', 50, 'ultraboost1.jpg', 'ultraboost2.jpg', NOW()),
(5, 2, 'Nike Air Max 270', 'Lightweight shoe with visible air unit.', 160.00, '43', 40, 'airmax1.jpg', 'airmax2.jpg', NOW()),
(6, 3, 'Puma RS-X3 Puzzle', 'Bold design sneaker for daily wear.', 120.00, '41', 60, 'rsx1.jpg', 'rsx2.jpg', NOW());

INSERT INTO Inventory (product_id, vendor_id, stock_quantity)
VALUES
(1, 4, 50),
(2, 5, 40),
(3, 6, 60);

INSERT INTO Orders (user_id, order_date, total_amount, status) VALUES
(1, NOW(), 300.00, 'pending'),  -- Client 1
(2, NOW(), 500.00, 'completed'), -- Client 2
(3, NOW(), 700.00, 'shipped');  -- Client 3

INSERT INTO Order_Items (order_id, product_id, quantity, price_at_time_of_order) VALUES
(1, 1, 1, 180.00),  -- Order 1: Product 1 (Adidas Ultraboost 22)
(2, 2, 2, 160.00),  -- Order 2: Product 2 (Nike Air Max 270)
(3, 3, 1, 120.00);  -- Order 3: Product 3 (Puma RS-X3 Puzzle)


INSERT INTO Cart (user_id, created_at) VALUES
(1, NOW()),
(2, NOW()),
(3, NOW());

INSERT INTO Cart_Items (cart_id, product_id, quantity) VALUES
(1, 1, 2),  -- Cart 1: 2 units of Adidas Ultraboost 22
(2, 2, 1),  -- Cart 2: 1 unit of Nike Air Max 270
(3, 3, 3);  -- Cart 3: 3 units of Puma RS-X3 Puzzle
