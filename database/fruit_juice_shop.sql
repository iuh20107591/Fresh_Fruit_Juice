-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 01:24 PM
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
-- Database: `fruit_juice_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `status`) VALUES
(1, 'Xoài', 1),
(2, 'Táo', 1),
(3, 'Dứa', 1),
(4, 'Ổi', 1),
(5, 'Cam', 1),
(6, 'Lựu', 1),
(7, 'Cà chua', 1),
(8, 'Cóc', 1),
(9, 'Đào', 1),
(10, 'Dâu', 1),
(11, 'Dưa Hấu', 1),
(12, 'Lê', 1),
(13, 'Nho', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('pending','done') DEFAULT 'pending',
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `phone`, `address`, `created_at`, `status`, `deleted`) VALUES
(1, 'Nguyễn Ngọc Khánh', '0985811425', '123', '2025-07-04 20:34:28', 'done', 0),
(6, 'Nguyễn Ngọc Khánh', '0985811425', '123', '2025-07-06 22:15:55', 'done', 0),
(7, 'Nguyễn Ngọc Khánh', '0985811425', '123', '2025-07-06 22:20:00', 'pending', 0),
(9, 'Nguyễn Ngọc Khánh', '0985811425', '123', '2025-07-06 22:23:12', 'pending', 1),
(10, 'Nguyễn Ngọc Khánh', '0985811425', 'test', '2025-07-07 10:09:32', 'done', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `price`, `quantity`) VALUES
(2, 1, 2, 'Nước ép táo', 28000.00, 1),
(8, 6, 3, 'Nước ép cà chua', 18000.00, 1),
(9, 7, 8, 'Nước ép dứa', 21000.00, 1),
(11, 9, 10, 'Nước ép lựu', 30000.00, 1),
(12, 10, 1, 'Nước cam ép', 25000.00, 1),
(13, 1, 8, 'Nước ép dứa', 21000.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cat_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `seller` varchar(50) DEFAULT 'seller1',
  `mix_cat1` int(11) DEFAULT NULL,
  `mix_cat2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `cat_id`, `status`, `seller`, `mix_cat1`, `mix_cat2`) VALUES
(1, 'Nước cam ép', 'Nước cam tươi mát, bổ sung vitamin C', 25000.00, 'ep_cam.jpg', 5, 1, 'seller1', 5, NULL),
(2, 'Nước ép táo', 'Nước ép táo thơm ngon, tốt cho sức khỏe', 28000.00, 'ep_tao.jpg', 2, 1, 'seller1', 2, NULL),
(3, 'Nước ép cà chua', 'Giàu vitamin A và C, tốt cho làn da và hệ miễn dịch.', 18000.00, 'ep_ca_chua.jpg', 7, 1, 'seller1', 7, NULL),
(4, 'Nước ép cóc', 'Chua thanh, giải nhiệt và giàu chất xơ.', 22000.00, 'ep_coc.jpg', 8, 1, 'seller1', 8, NULL),
(5, 'Nước ép đào', 'Hương vị ngọt ngào, bổ sung vitamin và khoáng chất.', 25000.00, 'ep_dao.jpg', 9, 1, 'seller1', 9, NULL),
(6, 'Nước ép dâu', 'Thơm ngon, bổ sung chất chống oxy hoá.', 28000.00, 'ep_dau.jpg', 10, 1, 'seller1', 10, NULL),
(7, 'Nước ép dưa hấu', 'Giải nhiệt mùa hè, ngọt mát tự nhiên.', 20000.00, 'ep_dua_hau.jpg', 11, 1, 'seller1', 11, NULL),
(8, 'Nước ép dứa', 'Giàu enzyme hỗ trợ tiêu hoá, mùi vị hấp dẫn.', 21000.00, 'ep_dua.jpg', 3, 1, 'seller1', 3, NULL),
(9, 'Nước ép lê', 'Ngọt dịu, giúp thanh lọc cơ thể và làm mát da.', 24000.00, 'ep_le.jpg', 12, 1, 'seller1', 12, NULL),
(10, 'Nước ép lựu', 'Chống lão hóa và hỗ trợ tim mạch.', 30000.00, 'ep_luu.jpg', 6, 1, 'seller1', 6, NULL),
(11, 'Nước ép nho', 'Tốt cho máu và hệ tim mạch, vị ngon đặc trưng.', 27000.00, 'ep_nho.jpg', 13, 1, 'seller1', 13, NULL),
(12, 'Nước ép ổi', 'Rất giàu vitamin C, tăng đề kháng.', 19000.00, 'ep_oi.jpg', 4, 1, 'seller1', 4, NULL),
(13, 'Nước ép xoài', 'Vị thơm ngon đặc trưng, hỗ trợ tiêu hoá.', 26000.00, 'ep_xoai.jpg', 1, 1, 'seller1', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','seller','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin'),
(2, 'seller1', 'seller123', 'seller'),
(3, 'customer1', 'cust123', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cate` (`cat_id`),
  ADD KEY `fk_mix1` (`mix_cat1`),
  ADD KEY `fk_mix2` (`mix_cat2`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_mix1` FOREIGN KEY (`mix_cat1`) REFERENCES `category` (`cat_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_mix2` FOREIGN KEY (`mix_cat2`) REFERENCES `category` (`cat_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
