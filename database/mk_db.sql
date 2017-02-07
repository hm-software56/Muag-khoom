-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2017 at 02:23 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(45) NOT NULL,
  `status` decimal(10,0) NOT NULL DEFAULT '1',
  `products_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_barcode_products1_idx` (`products_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `barcode`
--

INSERT INTO `barcode` (`id`, `barcode`, `status`, `products_id`) VALUES
(3, '1111', '0', 3),
(6, '6666', '0', 7),
(7, '7777', '0', 7),
(8, '8888', '0', 7),
(9, '8560034819211', '0', 4),
(10, '1234567890128', '0', 4),
(11, '512566601', '0', 4),
(13, 'C31CB10302', '0', 4),
(18, '0001', '0', 3),
(19, '0002', '0', 3),
(20, '0003', '0', 3),
(21, '0004', '0', 3),
(22, '0005', '0', 3),
(23, '8344289085177', '1', 3),
(24, '7094137184262', '1', 3),
(25, '1141718347229', '1', 3),
(26, '1524698669305', '1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `date`) VALUES
(1, 'ນ້ຳ​ດ​ື່ມ', '0000-00-00'),
(2, 'ເບຍ', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `code`, `full_name`, `phone`, `date`) VALUES
(1, '00000001', NULL, NULL, '2017-02-03'),
(2, '00000002', NULL, NULL, '2017-02-03'),
(3, '00000003', NULL, NULL, '2017-02-03'),
(4, '00000004', NULL, NULL, '2017-02-03'),
(5, '00000005', NULL, NULL, '2017-02-03'),
(6, '00000006', NULL, NULL, '2017-02-03'),
(7, '00000007', NULL, NULL, '2017-02-03'),
(8, '00000008', NULL, NULL, '2017-02-03'),
(9, '00000009', NULL, NULL, '2017-02-03');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `qautity` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `pricesale` varchar(40) NOT NULL,
  `pricebuy` varchar(40) NOT NULL,
  `image` varchar(45) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_category1_idx` (`category_id`),
  KEY `fk_products_user1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `qautity`, `date`, `pricesale`, `pricebuy`, `image`, `category_id`, `user_id`) VALUES
(3, 'ເສື້ອຢຶດ kingpowera', 13, '2017-02-01', '15000', '10000', '2017020114022604.jpg', 1, 1),
(4, 'ເສື້ອຢຶດ kingpowera', 6, '2017-02-01', '10000', '8000', '2017020114022706.jpg', 2, 1),
(5, 'ເສື້ອຢຶດ kingpowera', 20, '2017-02-01', '30000', '20000', '2017020114023728.jpg', 1, 1),
(6, 'ເສື້ອຢຶດ kingpowera', 2, '2017-02-01', '20000', '15000', '2017020114022429.jpg', 1, 1),
(7, 'ເສື້ອຢຶດ kingpowers', 5, '2017-02-01', '20000', '15000', '2017020114023330.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `products_id` int(11) NOT NULL,
  `qautity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sale_products_idx` (`products_id`),
  KEY `fk_sale_user1_idx` (`user_id`),
  KEY `fk_sale_invoice1_idx` (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `date`, `products_id`, `qautity`, `user_id`, `invoice_id`, `price`) VALUES
(12, '2017-02-03', 7, 1, 1, 1, 20000),
(13, '2017-02-03', 7, 1, 1, 2, 20000),
(14, '2017-02-03', 3, 1, 1, 3, 15000),
(15, '2017-02-03', 3, 1, 1, 4, 15000),
(16, '2017-02-03', 3, 1, 1, 5, 15000),
(17, '2017-02-03', 3, 1, 1, 6, 15000),
(18, '2017-02-03', 3, 1, 1, 7, 15000),
(19, '2017-02-03', 3, 1, 1, 8, 15000),
(20, '2017-02-03', 3, 1, 1, 9, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `shop_profile`
--

CREATE TABLE IF NOT EXISTS `shop_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(45) DEFAULT NULL,
  `shop_name` varchar(255) NOT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `adress` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `shop_profile`
--

INSERT INTO `shop_profile` (`id`, `logo`, `shop_name`, `telephone`, `phone_number`, `email`, `adress`) VALUES
(1, '2017020314023151.jpg', 'HM-SOFTWARE', '030 5666666', '020 56992726', 'daxionginfo@gmail.com', 'Vientiane');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(45) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `user_type` enum('Admin','User','POS') NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `photo`, `first_name`, `last_name`, `username`, `password`, `status`, `user_type`, `date`) VALUES
(1, '2017020113025354.jpg', 'Daxiong', 'SONGYANGCHENG', 'daxiong', 'da123', 1, 'Admin', '2017-02-01');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barcode`
--
ALTER TABLE `barcode`
  ADD CONSTRAINT `fk_barcode_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `fk_sale_invoice1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sale_products` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sale_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
