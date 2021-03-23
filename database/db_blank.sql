/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : localhost:3306
 Source Schema         : pos_db_blank

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : 65001

 Date: 19/02/2021 08:49:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barcode
-- ----------------------------
DROP TABLE IF EXISTS `barcode`;
CREATE TABLE `barcode`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` decimal(10, 0) NOT NULL DEFAULT 1,
  `products_id` int(0) NOT NULL,
  `invoice_id` int(0) NULL DEFAULT NULL,
  `user_id` int(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_barcode_products1_idx`(`products_id`) USING BTREE,
  INDEX `fk_barcode_invoice1_idx`(`invoice_id`) USING BTREE,
  INDEX `fk_barcode_user1_idx`(`user_id`) USING BTREE,
  CONSTRAINT `fk_barcode_invoice1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_barcode_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_barcode_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of barcode
-- ----------------------------

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` date NOT NULL,
  `category_id` int(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_category_category1_idx`(`category_id`) USING BTREE,
  CONSTRAINT `fk_category_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of category
-- ----------------------------

-- ----------------------------
-- Table structure for currency
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'null',
  `rate` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'null',
  `round_exch` float NOT NULL,
  `base_currency` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of currency
-- ----------------------------
INSERT INTO `currency` VALUES (1, '​ກີບ', '$vl*$ra', '1', -500, 1);
INSERT INTO `currency` VALUES (2, '​ໂດ​ລາ', '$vl*$ra', '8700', -0.01, 0);
INSERT INTO `currency` VALUES (3, 'ບາດ', '$vl*$ra', '270', -0.1, 0);

-- ----------------------------
-- Table structure for custommer
-- ----------------------------
DROP TABLE IF EXISTS `custommer`;
CREATE TABLE `custommer`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of custommer
-- ----------------------------

-- ----------------------------
-- Table structure for discount
-- ----------------------------
DROP TABLE IF EXISTS `discount`;
CREATE TABLE `discount`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `discount` int(0) NOT NULL,
  `invoice_id` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_discount_invoice1_idx`(`invoice_id`) USING BTREE,
  CONSTRAINT `fk_discount_invoice1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of discount
-- ----------------------------

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` int(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_invoice_user1_idx`(`user_id`) USING BTREE,
  CONSTRAINT `fk_invoice_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of invoice
-- ----------------------------

-- ----------------------------
-- Table structure for language
-- ----------------------------
DROP TABLE IF EXISTS `language`;
CREATE TABLE `language`  (
  `language_id` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name_ascii` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(0) NOT NULL,
  PRIMARY KEY (`language_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of language
-- ----------------------------

-- ----------------------------
-- Table structure for language_source
-- ----------------------------
DROP TABLE IF EXISTS `language_source`;
CREATE TABLE `language_source`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of language_source
-- ----------------------------

-- ----------------------------
-- Table structure for language_translate
-- ----------------------------
DROP TABLE IF EXISTS `language_translate`;
CREATE TABLE `language_translate`  (
  `id` int(0) NOT NULL,
  `language` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `translation` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`, `language`) USING BTREE,
  INDEX `language_translate_idx_language`(`language`) USING BTREE,
  CONSTRAINT `language_translate_ibfk_1` FOREIGN KEY (`language`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `language_translate_ibfk_2` FOREIGN KEY (`id`) REFERENCES `language_source` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of language_translate
-- ----------------------------

-- ----------------------------
-- Table structure for lost_product
-- ----------------------------
DROP TABLE IF EXISTS `lost_product`;
CREATE TABLE `lost_product`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `qautity` int(0) NOT NULL,
  `date` date NOT NULL,
  `pricebuy` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `purchase_item_id` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_lost_product_purchase_item1_idx`(`purchase_item_id`) USING BTREE,
  CONSTRAINT `fk_lost_product_purchase_item1` FOREIGN KEY (`purchase_item_id`) REFERENCES `purchase_item` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of lost_product
-- ----------------------------

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` int(0) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migration
-- ----------------------------

-- ----------------------------
-- Table structure for pay_multi_curency
-- ----------------------------
DROP TABLE IF EXISTS `pay_multi_curency`;
CREATE TABLE `pay_multi_curency`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `amount_kip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `amount_th` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `amount_usd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `invoice_id` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_pay_multi_curency_invoice1_idx`(`invoice_id`) USING BTREE,
  CONSTRAINT `fk_pay_multi_curency_invoice1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of pay_multi_curency
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qautity` int(0) NOT NULL,
  `date` date NULL DEFAULT NULL,
  `pricesale` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `category_id` int(0) NOT NULL,
  `user_id` int(0) NOT NULL,
  `status` int(0) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_products_category1_idx`(`category_id`) USING BTREE,
  INDEX `fk_products_user1_idx`(`user_id`) USING BTREE,
  CONSTRAINT `fk_products_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_products_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of products
-- ----------------------------

-- ----------------------------
-- Table structure for purchase
-- ----------------------------
DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date` datetime(0) NOT NULL,
  `currency_id` int(0) NOT NULL,
  `status` enum('save','confirm','cancle') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE,
  INDEX `fk_purchase_currency1_idx`(`currency_id`) USING BTREE,
  CONSTRAINT `fk_purchase_currency1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of purchase
-- ----------------------------

-- ----------------------------
-- Table structure for purchase_item
-- ----------------------------
DROP TABLE IF EXISTS `purchase_item`;
CREATE TABLE `purchase_item`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `date` date NULL DEFAULT NULL,
  `pricebuy` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qautity` int(0) NOT NULL,
  `qtt_saled` int(0) NULL DEFAULT 0,
  `date_exp` datetime(0) NULL DEFAULT NULL,
  `products_id` int(0) NOT NULL,
  `purchase_id` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE,
  INDEX `fk_purchase_products1_idx`(`products_id`) USING BTREE,
  INDEX `fk_purchase_item_purchase1_idx`(`purchase_id`) USING BTREE,
  CONSTRAINT `fk_purchase_item_purchase1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_purchase_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of purchase_item
-- ----------------------------

-- ----------------------------
-- Table structure for sale
-- ----------------------------
DROP TABLE IF EXISTS `sale`;
CREATE TABLE `sale`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `products_id` int(0) NOT NULL,
  `qautity` int(0) NOT NULL,
  `user_id` int(0) NOT NULL,
  `invoice_id` int(0) NOT NULL,
  `price` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `profit_price` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_sale_products_idx`(`products_id`) USING BTREE,
  INDEX `fk_sale_user1_idx`(`user_id`) USING BTREE,
  INDEX `fk_sale_invoice1_idx`(`invoice_id`) USING BTREE,
  CONSTRAINT `fk_sale_invoice1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_sale_products` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_sale_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of sale
-- ----------------------------

-- ----------------------------
-- Table structure for sale_has_purchase
-- ----------------------------
DROP TABLE IF EXISTS `sale_has_purchase`;
CREATE TABLE `sale_has_purchase`  (
  `sale_id` int(0) NOT NULL,
  `purchase_item_id` int(0) NOT NULL,
  `qautity` int(0) NOT NULL,
  `pricebuy` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`sale_id`, `purchase_item_id`) USING BTREE,
  INDEX `fk_sale_has_purchase_purchase1_idx`(`purchase_item_id`) USING BTREE,
  INDEX `fk_sale_has_purchase_sale1_idx`(`sale_id`) USING BTREE,
  CONSTRAINT `fk_sale_has_purchase_purchase1` FOREIGN KEY (`purchase_item_id`) REFERENCES `purchase_item` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_sale_has_purchase_sale1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of sale_has_purchase
-- ----------------------------

-- ----------------------------
-- Table structure for shop_profile
-- ----------------------------
DROP TABLE IF EXISTS `shop_profile`;
CREATE TABLE `shop_profile`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `logo` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `shop_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `telephone` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone_number` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `adress` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `key_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alert` int(0) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of shop_profile
-- ----------------------------
INSERT INTO `shop_profile` VALUES (1, '2020012409012829.png', 'POS', '021 21XXXX', '020 55045770', 'daxionginfo@gmail.com', 'Vientiane lao', '172709095144195439911270920', 1);

-- ----------------------------
-- Table structure for still_pay
-- ----------------------------
DROP TABLE IF EXISTS `still_pay`;
CREATE TABLE `still_pay`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `details` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` datetime(0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `custommer_id` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_still_pay_custommer1_idx`(`custommer_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of still_pay
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `photo` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(0) NULL DEFAULT 1,
  `user_type` enum('Admin','User','POS') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` date NOT NULL,
  `height_screen` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPRESSED;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (5, '2019020102022139.png', 'Da', 'Xiong', 'daxiong', 'da123', 1, 'Admin', '2019-02-01', NULL);
INSERT INTO `user` VALUES (6, '2018032311034741.jpg', 'POS', 'POS', 'user', '12345', 1, 'User', '2019-01-22', NULL);
INSERT INTO `user` VALUES (7, '2018042719044953.jpg', 'POS', 'POS', 'pos', '123', 1, 'POS', '2018-04-27', NULL);
INSERT INTO `user` VALUES (8, '2019020102025740.png', 'admin', 'admin', 'admin', 'admin123', 1, 'Admin', '2019-02-01', NULL);

SET FOREIGN_KEY_CHECKS = 1;
