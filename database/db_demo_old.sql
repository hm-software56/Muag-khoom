CREATE TABLE barcode (
  id int(11) NOT NULL,
  barcode varchar(45) NOT NULL,
  status decimal(10,0) NOT NULL DEFAULT '1',
  products_id int(11) NOT NULL,
  invoice_id int(11) DEFAULT NULL,
  user_id int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO barcode (id, barcode, status, products_id, invoice_id, user_id) VALUES
(3, '9126273636751', '1', 1, NULL, NULL),
(4, '6759771992277', '1', 2, NULL, NULL),
(5, '7803523462415', '1', 3, NULL, NULL),
(6, '9950194147719', '1', 4, NULL, NULL),
(7, '2301005712850', '1', 5, NULL, NULL),
(8, '3836449277942', '1', 6, NULL, NULL),
(9, '6933654318815', '1', 7, NULL, NULL),
(10, '7209188334409', '1', 8, NULL, NULL),
(11, '7493856473044', '1', 9, NULL, NULL),
(12, '4159836005416', '1', 10, NULL, NULL),
(13, '3581963379695', '1', 11, NULL, NULL);

CREATE TABLE category (
  id int(11) NOT NULL,
  name varchar(255) NOT NULL,
  date date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO category (id, name, date) VALUES
(1, 'ເຄື່ອງດື່ມ', '2017-04-21'),
(2, 'ເຂົ້າ​ໝົມ', '2017-04-21'),
(3, '​ສະ​ບູ', '2017-04-21'),
(4, '​ເຄື່ອງ​ກີນ', '2017-04-21');

CREATE TABLE discount (
  id int(11) NOT NULL,
  discount int(100) NOT NULL,
  invoice_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO discount (id, discount, invoice_id) VALUES
(1, 17000, 12),
(2, 8000, 15),
(3, 20000, 16),
(4, 82000, 18);

CREATE TABLE invoice (
  id int(11) NOT NULL,
  code varchar(45) NOT NULL,
  full_name varchar(255) DEFAULT NULL,
  phone varchar(45) DEFAULT NULL,
  date date NOT NULL,
  user_id int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO invoice (id, code, full_name, phone, date, user_id) VALUES
(3, '00000001', NULL, NULL, '2018-02-09', 1),
(4, '00000002', NULL, NULL, '2018-02-09', 1),
(5, '00000003', NULL, NULL, '2018-02-09', 1),
(6, '00000004', NULL, NULL, '2018-02-09', 1),
(7, '00000005', NULL, NULL, '2018-02-10', 1),
(8, '00000006', NULL, NULL, '2018-02-10', 1),
(9, '00000007', NULL, NULL, '2018-02-12', 1),
(10, '00000008', NULL, NULL, '2018-02-12', 2),
(11, '00000009', NULL, NULL, '2018-02-12', 1),
(12, '00000010', NULL, NULL, '2018-02-13', 1),
(13, '00000011', NULL, NULL, '2018-02-14', 1),
(14, '00000012', NULL, NULL, '2018-02-14', 2),
(15, '00000013', NULL, NULL, '2018-02-14', 1),
(16, '00000014', NULL, NULL, '2018-02-14', 1),
(17, '00000015', NULL, NULL, '2018-02-15', 1),
(18, '00000016', NULL, NULL, '2018-02-16', 1),
(19, '00000017', NULL, NULL, '2018-02-16', 1);

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

INSERT INTO products (id, name, qautity, date, pricesale, pricebuy, image, category_id, user_id) VALUES
(1, 'Beer lao ແກ້ວ​ໃຫຍ່', 23, '2017-04-21', '10000', '8000', '2017042108045841.jpg', 1, 3),
(2, 'Beer lao ແກ້ວໜ້ອຍ', 37, '2017-04-21', '7000', '6000', '2017042108043942.jpg', 1, 3),
(3, 'Beer ດຳແກ້ວໜ້ອຍ', 20, '2017-04-21', '9000', '6000', '2017042108043944.png', 1, 1),
(4, 'TUBORG', 300, '2017-04-21', '9000', '6000', '2017042108043946.jpg', 1, 1),
(5, 'ໂສ​ດາ​ລາວ', 45, '2018-02-07', '4000', '3000', '2017042108043548.png', 1, 1),
(6, 'ເປບ​ຊີ​ຕ​ຸກ', 45, '2017-04-21', '5000', '3000', '2017042108041450.jpeg', 1, 1),
(7, 'Beer namkong', 45, '2017-04-21', '8000', '6000', '2017042108043451.jpg', 1, 1),
(8, 'Beer ປ່ອງ​ກາງ', 55, '2017-04-21', '5000', '3000', '2017042108041354.jpg', 1, 1),
(9, 'ນ່ຳ​ດີ້ມ​ຫົວ​ເສືອ​ກາງ', 20, '2017-04-21', '3000', '2000', '2017042108041157.gif', 1, 1),
(10, 'Supermarket Wine', 300, '2017-04-21', '400000', '200000', '2017042109045205.jpg', 1, 3),
(11, 'Vine Wine', 101, '2017-04-21', '600000', '400000', '2017042109044307.jpg', 1, 1),
(12, 'ເຂົ້າ​ຫນົມ​ອົມ', 20, '2017-04-21', '30000', '15000', '2017042110041046.jpg', 2, 1),
(13, 'ກະ​ແລມ', 103, '2017-04-21', '7000', '5000', '2017042110042850.jpg', 2, 1),
(14, 'ເຂົ້າ​ຫນົມ​ Chocole', 20, '2017-04-21', '15000', '1000', '2017042110041254.jpg', 2, 1),
(15, 'ເຂົ້າ​ຫນົມ​ Nuggets', 30, '2017-04-21', '1000', '500', '2017042110040356.jpg', 2, 1),
(16, 'ເບຍ​ລັງໜຶ່ງ', 45, '2018-02-16', '95000', '90000', '2018021605020728.jpg', 1, 1),
(17, 'ນ້ຳ​ດື່ມ​ຫົ​ວ​ເສືອ pack ໜື່ງ', 100, '2018-02-16', '25000', '23000', '2018021605022933.jpg', 1, 1);

CREATE TABLE sale (
  id int(11) NOT NULL,
  date date NOT NULL,
  products_id int(11) NOT NULL,
  qautity int(11) NOT NULL,
  user_id int(11) NOT NULL,
  invoice_id int(11) NOT NULL,
  price int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO sale (id, date, products_id, qautity, user_id, invoice_id, price) VALUES
(1, '2018-02-09', 6, 2, 1, 3, 10000),
(2, '2018-02-09', 5, 2, 1, 3, 8000),
(3, '2018-02-09', 2, 2, 1, 3, 14000),
(4, '2018-02-09', 1, 2, 1, 3, 20000),
(5, '2018-02-05', 1, 2, 1, 4, 20000),
(6, '2018-01-27', 4, 2, 1, 5, 18000),
(7, '2018-01-27', 1, 1, 1, 5, 10000),
(8, '2018-02-09', 6, 5, 1, 6, 25000),
(9, '2018-02-09', 3, 4, 1, 6, 36000),
(10, '2018-02-09', 2, 5, 1, 6, 35000),
(11, '2018-02-09', 11, 1, 1, 6, 600000),
(12, '2018-02-09', 7, 2, 1, 6, 16000),
(13, '2018-02-09', 4, 8, 1, 6, 72000),
(14, '2018-02-10', 6, 4, 1, 7, 20000),
(15, '2018-02-10', 4, 6, 1, 7, 54000),
(16, '2018-02-10', 2, 4, 1, 7, 28000),
(17, '2018-02-10', 13, 3, 1, 8, 21000),
(18, '2018-02-10', 10, 4, 1, 8, 1600000),
(19, '2018-02-10', 12, 5, 1, 8, 150000),
(20, '2018-02-12', 7, 2, 1, 9, 16000),
(21, '2018-02-12', 5, 1, 1, 9, 4000),
(22, '2018-02-12', 4, 3, 1, 9, 27000),
(23, '2018-02-12', 3, 1, 1, 9, 9000),
(24, '2018-02-12', 2, 1, 1, 9, 7000),
(25, '2018-02-12', 9, 5, 2, 10, 15000),
(26, '2018-02-12', 7, 1, 2, 10, 8000),
(27, '2018-02-12', 13, 1, 1, 11, 7000),
(28, '2018-02-12', 15, 1, 1, 11, 1000),
(29, '2018-02-12', 12, 2, 1, 11, 60000),
(30, '2018-02-12', 7, 1, 1, 11, 8000),
(31, '2018-02-12', 9, 1, 1, 11, 3000),
(32, '2018-02-12', 5, 2, 1, 11, 8000),
(33, '2018-02-12', 4, 4, 1, 11, 36000),
(34, '2018-02-13', 7, 23, 1, 12, 184000),
(35, '2018-02-13', 9, 5, 1, 12, 15000),
(36, '2018-02-13', 10, 2, 1, 12, 800000),
(37, '2018-02-13', 4, 2, 1, 12, 18000),
(38, '2018-02-14', 15, 20, 1, 13, 20000),
(39, '2018-02-14', 13, 8, 1, 13, 56000),
(40, '2018-02-14', 9, 12, 1, 13, 36000),
(41, '2018-02-14', 5, 2, 1, 13, 8000),
(42, '2018-02-14', 4, 1, 1, 13, 9000),
(43, '2018-02-14', 15, 4, 2, 14, 4000),
(44, '2018-02-14', 14, 1, 2, 14, 15000),
(45, '2018-02-14', 13, 1, 2, 14, 7000),
(46, '2018-02-14', 12, 2, 2, 14, 60000),
(47, '2018-02-14', 9, 4, 1, 15, 12000),
(48, '2018-02-14', 5, 2, 1, 15, 8000),
(49, '2018-02-14', 4, 2, 1, 15, 18000),
(50, '2018-02-14', 5, 10, 1, 16, 40000),
(51, '2018-02-14', 4, 20, 1, 16, 180000),
(52, '2018-02-15', 5, 3, 1, 17, 12000),
(53, '2018-02-15', 4, 7, 1, 17, 63000),
(54, '2018-02-16', 7, 2, 1, 18, 16000),
(55, '2018-02-16', 9, 4, 1, 18, 12000),
(56, '2018-02-16', 10, 4, 1, 18, 1600000),
(57, '2018-02-16', 4, 6, 1, 18, 54000),
(58, '2018-02-16', 16, 5, 1, 19, 475000),
(59, '2018-02-16', 1, 12, 1, 19, 120000);

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

INSERT INTO shop_profile (id, logo, shop_name, telephone, phone_number, email, adress, key_active) VALUES
(1, '2017042016040619.jpg', 'ຮ້ານ ເຮ​ເອມ​ຊອບ', '020 55045770', '020 55045770', 'daxionginfo@gmail.com', 'Lao', '231653023157970541804165320');

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

INSERT INTO user (id, photo, first_name, last_name, username, password, status, user_type, date, height_screen) VALUES
(1, '2017042016044316.jpg', 'Daxiong', 'Songyangcheng', 'daxiong', 'da123', 1, 'Admin', '2017-04-20', NULL),
(2, '2017042109041319.jpg', 'POS', '', 'pos', '123', 1, 'POS', '2017-04-21', NULL),
(3, '2017042204040547.jpg', 'User', '', 'user', '123', 1, 'User', '2017-04-22', NULL);


ALTER TABLE barcode
  ADD PRIMARY KEY (id),
  ADD KEY fk_barcode_products1_idx (products_id),
  ADD KEY fk_barcode_invoice1_idx (invoice_id),
  ADD KEY fk_barcode_user1_idx (user_id);

ALTER TABLE category
  ADD PRIMARY KEY (id);

ALTER TABLE discount
  ADD PRIMARY KEY (id),
  ADD KEY fk_discount_invoice1_idx (invoice_id);

ALTER TABLE invoice
  ADD PRIMARY KEY (id),
  ADD KEY fk_invoice_user1_idx (user_id);

ALTER TABLE products
  ADD PRIMARY KEY (id),
  ADD KEY fk_products_category1_idx (category_id),
  ADD KEY fk_products_user1_idx (user_id);

ALTER TABLE sale
  ADD PRIMARY KEY (id),
  ADD KEY fk_sale_products_idx (products_id),
  ADD KEY fk_sale_user1_idx (user_id),
  ADD KEY fk_sale_invoice1_idx (invoice_id);

ALTER TABLE shop_profile
  ADD PRIMARY KEY (id);

ALTER TABLE user
  ADD PRIMARY KEY (id);


ALTER TABLE barcode
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE category
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE discount
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE invoice
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE products
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE sale
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

ALTER TABLE shop_profile
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE user
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE barcode
  ADD CONSTRAINT fk_barcode_invoice1 FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_barcode_products1 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_barcode_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE discount
  ADD CONSTRAINT fk_discount_invoice1 FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE invoice
  ADD CONSTRAINT fk_invoice_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE products
  ADD CONSTRAINT fk_products_category1 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_products_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE sale
  ADD CONSTRAINT fk_sale_invoice1 FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_sale_products FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_sale_user1 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;