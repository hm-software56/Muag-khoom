-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2018 at 01:00 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: daxiong_pos7
--

-- --------------------------------------------------------

--
-- Table structure for table barcode
--

CREATE TABLE barcode (
  id int(11) NOT NULL,
  barcode varchar(45) NOT NULL,
  status decimal(10,0) NOT NULL DEFAULT '1',
  products_id int(11) NOT NULL,
  invoice_id int(11) DEFAULT NULL,
  user_id int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table category
--

CREATE TABLE category (
  id int(11) NOT NULL,
  name varchar(255) NOT NULL,
  date date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table discount
--

CREATE TABLE discount (
  id int(11) NOT NULL,
  discount int(100) NOT NULL,
  invoice_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table invoice
--

CREATE TABLE invoice (
  id int(11) NOT NULL,
  code varchar(45) NOT NULL,
  full_name varchar(255) DEFAULT NULL,
  phone varchar(45) DEFAULT NULL,
  date date NOT NULL,
  user_id int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table products
--

CREATE TABLE products (
  id int(11) NOT NULL,
  name varchar(255) NOT NULL,
  qautity int(11) NOT NULL,
  date date DEFAULT NULL,
  pricesale varchar(40) NOT NULL,
  pricebuy varchar(40) NOT NULL,
  image varchar(45) DEFAULT NULL,
  category_id int(11) NOT NULL,
  user_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table sale
--

CREATE TABLE sale (
  id int(11) NOT NULL,
  date date NOT NULL,
  products_id int(11) NOT NULL,
  qautity int(11) NOT NULL,
  user_id int(11) NOT NULL,
  invoice_id int(11) NOT NULL,
  price int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table shop_profile
--

CREATE TABLE shop_profile (
  id int(11) NOT NULL,
  logo varchar(45) DEFAULT NULL,
  shop_name varchar(255) NOT NULL,
  telephone varchar(45) DEFAULT NULL,
  phone_number varchar(45) DEFAULT NULL,
  email varchar(45) DEFAULT NULL,
  adress text NOT NULL,
  key_active varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table shop_profile
--

INSERT INTO shop_profile (id, logo, shop_name, telephone, phone_number, email, adress, key_active) VALUES
(1, '2017042016040619.jpg', 'ຮ້ານ ເຮ​ເອມ​ຊອບ', '020 55045770', '020 55045770', 'daxionginfo@gmail.com', 'Lao', '175313076774795881812531320');

-- --------------------------------------------------------

--
-- Table structure for table user
--

CREATE TABLE user (
  id int(11) NOT NULL,
  photo varchar(45) DEFAULT NULL,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) DEFAULT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  status tinyint(4) DEFAULT '1',
  user_type enum('Admin','User','POS') NOT NULL,
  date date NOT NULL,
  height_screen varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table barcode
--
ALTER TABLE barcode
  ADD PRIMARY KEY (id),
  ADD KEY fk_barcode_products1_idx (products_id),
  ADD KEY fk_barcode_invoice1_idx (invoice_id),
  ADD KEY fk_barcode_user1_idx (user_id);

--
-- Indexes for table category
--
ALTER TABLE category
  ADD PRIMARY KEY (id);

--
-- Indexes for table discount
--
ALTER TABLE discount
  ADD PRIMARY KEY (id),
  ADD KEY fk_discount_invoice1_idx (invoice_id);

--
-- Indexes for table invoice
--
ALTER TABLE invoice
  ADD PRIMARY KEY (id),
  ADD KEY fk_invoice_user1_idx (user_id);

--
-- Indexes for table products
--
ALTER TABLE products
  ADD PRIMARY KEY (id),
  ADD KEY fk_products_category1_idx (category_id),
  ADD KEY fk_products_user1_idx (user_id);

--
-- Indexes for table sale
--
ALTER TABLE sale
  ADD PRIMARY KEY (id),
  ADD KEY fk_sale_products_idx (products_id),
  ADD KEY fk_sale_user1_idx (user_id),
  ADD KEY fk_sale_invoice1_idx (invoice_id);

--
-- Indexes for table shop_profile
--
ALTER TABLE shop_profile
  ADD PRIMARY KEY (id);

--
-- Indexes for table user
--
ALTER TABLE user
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table barcode
--
ALTER TABLE barcode
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table category
--
ALTER TABLE category
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table discount
--
ALTER TABLE discount
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table invoice
--
ALTER TABLE invoice
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table products
--
ALTER TABLE products
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table sale
--
ALTER TABLE sale
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table shop_profile
--
ALTER TABLE shop_profile
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table user
--
ALTER TABLE user
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table barcode
--
ALTER TABLE barcode
  ADD CONSTRAINT fk_barcode_invoice1 FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_barcode_products1 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_barcode_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table discount
--
ALTER TABLE discount
  ADD CONSTRAINT fk_discount_invoice1 FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table invoice
--
ALTER TABLE invoice
  ADD CONSTRAINT fk_invoice_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table products
--
ALTER TABLE products
  ADD CONSTRAINT fk_products_category1 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_products_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table sale
--
ALTER TABLE sale
  ADD CONSTRAINT fk_sale_invoice1 FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_sale_products FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_sale_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
