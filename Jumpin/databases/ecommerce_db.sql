-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 02:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `name`) VALUES
(1, 'Adidas'),
(2, 'Nike'),
(3, 'Puma'),
(4, 'Fila'),
(5, 'Reebok');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `created_at`) VALUES
(1, 1, '2025-05-01 04:38:28'),
(2, 2, '2025-05-01 04:38:28'),
(3, 3, '2025-05-01 04:38:28'),
(4, 4, '2025-05-01 23:52:44'),
(5, 13, '2025-05-02 04:32:10'),
(6, 14, '2025-05-02 09:30:02'),
(7, 15, '2025-05-02 10:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(2, 2, 2, 1),
(3, 3, 3, 3),
(25, 7, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `vendor_id`, `stock_quantity`) VALUES
(1, 1, 4, 50),
(2, 2, 5, 40),
(3, 3, 6, 60);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(1, 1, '2025-05-01 04:38:28', 300.00, 'pending'),
(2, 2, '2025-05-01 04:38:28', 500.00, 'completed'),
(3, 3, '2025-05-01 04:38:28', 700.00, 'shipped'),
(4, 1, '2025-05-01 23:51:52', 1420.00, 'pending'),
(5, 4, '2025-05-01 23:52:53', 78.00, 'pending'),
(6, 1, '2025-05-02 03:38:37', 708.00, 'pending'),
(7, 13, '2025-05-02 04:32:17', 156.00, 'pending'),
(8, 1, '2025-05-02 08:43:59', 1465.00, 'pending'),
(9, 14, '2025-05-02 09:30:39', 300.00, 'pending'),
(10, 15, '2025-05-02 10:52:54', 238.00, 'pending'),
(11, 1, '2025-05-15 00:07:16', 478.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_time_of_order` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price_at_time_of_order`) VALUES
(1, 1, 1, 1, 180.00),
(2, 2, 2, 2, 160.00),
(3, 3, 3, 1, 120.00),
(4, 4, 1, 10, 78.00),
(5, 4, 2, 4, 160.00),
(6, 5, 1, 1, 78.00),
(7, 6, 1, 4, 78.00),
(8, 6, 19, 4, 99.00),
(9, 7, 1, 2, 78.00),
(10, 8, 1, 5, 78.00),
(11, 8, 3, 2, 120.00),
(12, 8, 4, 2, 80.00),
(13, 8, 9, 1, 75.00),
(14, 8, 10, 2, 300.00),
(15, 9, 5, 3, 100.00),
(16, 10, 4, 2, 80.00),
(17, 10, 1, 1, 78.00),
(18, 11, 1, 1, 78.00),
(19, 11, 4, 2, 80.00),
(20, 11, 3, 2, 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(50) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `imageName1` varchar(255) DEFAULT NULL,
  `imageName2` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `vendor_id`, `brand_id`, `name`, `description`, `price`, `size`, `stock_quantity`, `imageName1`, `imageName2`, `created_at`) VALUES
(1, 4, 4, ' Fila Kreatix', ' Fila Kreatix\r\nType : Lifestyle / Streetwear', 78.00, '38-42', 50, 'product-7.1.jpg', 'product-7.2.jpg', '2025-05-01 04:38:28'),
(2, 5, 4, 'Fila Rega', ' Fila Rega \r\nType : Sneakers basses pour homme / Lifestyle', 160.00, '37-43', 40, 'product-8.2.jpg', 'product-8.1.jpg', '2025-05-01 04:38:28'),
(3, 6, 2, 'Air Force 1', 'Nike Air Force 1\r\nType : Lifestyle / Running', 120.00, '38-45', 60, 'product-9.1.jpg', 'product-9.2.jpg', '2025-05-01 04:38:28'),
(4, 4, 1, 'Adidas Campus', 'Adidas Campus\r\nType : Lifestyle / Casual', 80.00, '39-44', 100, 'product-1.1.jpg', 'product-1.2.jpg', '2025-05-01 17:24:11'),
(5, 5, 1, 'Adidas Samba', 'Born on the football pitch, the Samba is now a timeless streetwear icon.', 100.00, '39-45', 58, 'product-2.1.jpg', 'product-2.2.jpg', '2025-05-01 17:46:08'),
(6, 6, 1, 'Adidas Stan Smith', 'Adidas Stan Smith\r\nType : Lifestyle / Classique intemporel\r\n', 99.00, '39-44', 15, 'product-3.1.jpg', 'product-3.2.jpg', '2025-05-01 18:03:23'),
(7, 5, 1, 'Adidas Super Star', 'Adidas Superstar\r\nType : Streetwear / Lifestyle\r\nÉditions spéciales (avec motifs, collaborations)', 99.00, '40-44', 120, 'product-4.1.jpg', 'product-4.2.jpg', '2025-05-01 18:08:16'),
(8, 6, 4, 'Fila Collene', 'Fila Collene CB WMN\r\nType : Sneakers basses / Lifestyle', 66.00, '36-41', 76, 'product-5.1.jpg', 'product-5.2.jpg', '2025-05-01 18:13:38'),
(9, 4, 4, 'Fila Courtbay', 'Fila Courtbay\r\nType : Lifestyle / Streetwear', 75.00, '35-45', 11, 'product-6.1.jpg', 'product-6.2.jpg', '2025-05-01 18:17:40'),
(10, 4, 2, 'Nike Air Max Plus TN', 'Nike Air Max Plus TN\r\nType : Streetwear / Lifestyle', 300.00, '36-46', 2, 'product-10.1.jpg', 'product-10.2.jpg', '2025-05-01 18:56:44'),
(11, 6, 2, 'Nike Dunk SB', 'Nike Dunk SB\r\nType : Skateboard / Streetwear', 149.00, '40-44', 34, 'product-11.1.jpg', 'product-11.2.jpg', '2025-05-01 19:00:02'),
(12, 5, 2, 'Nike Zoom', 'Nike Zoom\r\nType : Running / Training haute performance\r\n\r\n', 120.00, '38-42', 50, 'product-12.1.jpg', 'product-12.2.jpg', '2025-05-01 19:02:27'),
(13, 6, 3, 'Puma Doublecourt', 'Puma Doublecourt\r\nType : Lifestyle / Streetwear', 80.00, '36-41', 100, 'product-13.1.jpg', 'product-13.2.jpg', '2025-05-01 19:05:35'),
(14, 4, 3, 'Puma Morphic Base', 'Puma Morphic Base\r\nType : Lifestyle / Running rétro\r\n', 89.00, '39-44', 76, 'product-14.1.jpg', 'product-14.2.jpg', '2025-05-01 19:09:28'),
(15, 6, 3, 'Puma Speedcat', 'Puma Speedcat\r\nType : Motorsport / Lifestyle\r\n\r\n\r\n', 800.00, '35-45', 2, 'product-15.1.jpg', 'product-15.2.jpg', '2025-05-01 19:12:12'),
(16, 4, 3, 'Puma Suede Classic', 'Puma Suede Classic / Suede XL\r\nType : Lifestyle / Streetwear\r\n', 99.00, '35-45', 8, 'product-16.1.jpg', 'product-16.2.jpg', '2025-05-01 19:15:36'),
(17, 4, 5, ' Reebok Classic Leather', ' Reebok Classic Leather\r\nType : Lifestyle / Rétro\r\n', 44.00, '39-45', 10, 'product-17.1.jpg', 'product-17.2.jpg', '2025-05-01 19:19:08'),
(18, 5, 5, ' Reebok Club C 85', ' Reebok Club C 85\r\nType : Lifestyle / Tennis rétro', 145.00, '38-42', 100, 'product-18.1.jpg', 'product-18.2.jpg', '2025-05-01 19:22:51'),
(19, 5, 5, 'Reebok Zig Kinetica 21', 'Reebok Zig Kinetica 21\r\nType : Running / Lifestyle futuriste', 99.00, '39-44', 100, 'product-19.1.jpg', 'product19.2.jpg', '2025-05-01 19:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('client','vendor','admin') DEFAULT 'client',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `full_name`, `phone`, `role`, `created_at`) VALUES
(1, 'client1', 'client1@example.com', 'pass123', 'Alice Smith', '0700000001', 'client', '2025-05-01 04:38:28'),
(2, 'client2', 'client2@example.com', 'pass123', 'Bob Jones', '0700000002', 'client', '2025-05-01 04:38:28'),
(3, 'client3', 'client3@example.com', 'pass123', 'Charlie Lee', '0700000003', 'client', '2025-05-01 04:38:28'),
(4, 'vendor1', 'vendor1@example.com', 'pass123', 'Diana Moore', '0700000004', 'vendor', '2025-05-01 04:38:28'),
(5, 'vendor2', 'vendor2@example.com', 'pass123', 'Ethan Hall', '0700000005', 'vendor', '2025-05-01 04:38:28'),
(6, 'vendor3', 'vendor3@example.com', 'pass123', 'Fiona Clark', '0700000006', 'vendor', '2025-05-01 04:38:28'),
(7, 'admin1', 'admin1@example.com', 'adminpass', 'George King', '0700000007', 'admin', '2025-05-01 04:38:28'),
(8, 'test', 'z.rhendour9924@uca.ma', '$2y$10$jN3UxMJKu8w0sai44aBg6uR8yFhIKqzmBWelM5nFNAekRwbOxOaey', 'test', '', 'client', '2025-05-01 04:43:49'),
(9, 'test1', 'z.rhendour99245@uca.ma', '$2y$10$bzQ3Js782qQNvUh8/.C1OeeE8wJlfqHH1NO.CHl0Jb67ILzwsa9Dq', 'test', '', 'client', '2025-05-01 04:44:28'),
(10, 'test2', 'z.rhendour992456@uca.ma', '$2y$10$1POog8GDRPSpnAw7LtiedOWlNUDZJIy9k2ROWQOli06P3zkMHd36i', 'test', '', 'client', '2025-05-01 04:45:15'),
(11, 'test3', 'zakariarhendour@gmail.com', '$2y$10$iPJ9y10oM1dWdcJnD9MFhegmQArlaL0ismWp5YB9eL9qeGF/kvqzC', 'test3', '', 'client', '2025-05-01 04:45:44'),
(12, 'tahtoh', 'm.majjati4521@uca.ac.ma', '123', 'mjt', '', 'client', '2025-05-01 16:56:44'),
(13, 'axki', 'axki@gmail.com', 'axki', 'axkism', '', 'client', '2025-05-02 04:28:48'),
(14, 'fati', 'f.bme@gmail.com', '123', 'fatif', '', 'client', '2025-05-02 09:28:40'),
(15, 'ousssama', 'oussama@gmail.com', '123', 'oussama', '', 'client', '2025-05-02 10:50:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
