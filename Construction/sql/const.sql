SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `image` varchar(150) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `customer_addresses` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customer_addresses` (`id`, `customer`, `address`) VALUES
(1, 1, 'Abobo'),
(2, 2, 'Anyama'),
(3, 3, 'Adjamé'),
(4, 4, 'Attecoubé'),
(5, 5, 'Cocody'),
(6, 6, 'Plateau'),
(7, 7, 'Koumassi'),
(8, 8, 'Marcory'),
(9, 9, 'Yopougon'),
(10, 10, 'Port Bouet'),
(11, 11, 'Treichville'),
(12, 12, 'Bingerville');

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `category` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `products` (`id`, `name`, `price`, `category`, `image`, `create_date`) VALUES
(1, 'Bulldozer', '15000', 1, 'image/bulldozer.jpg', '2019-04-20 05:35:47'),
(2, 'Crane', '20000', 1, 'image/site.jpg', '2019-04-20 05:35:47'),
(3, 'Bull', '20000', 1, 'image/excavators.jpg', '2019-04-20 05:35:47'),
(4, 'Ciment', '15000', 1, 'image/truck.png', '2019-04-20 05:35:47'),
(6, 'Carreau', '10000', 2, 'image/floor.jpg', '2019-04-20 05:35:47'),
(7, 'Toile', '15000', 2, 'image/roof.jpg', '2019-04-20 05:35:47'),
(8, 'Pelle', '1500', 2, 'image/sand.png', '2019-04-20 05:35:47'),
(9, 'Outils', '10000', 2, 'image/tools.jpg', '2019-04-20 05:35:47'),
(10, 'Dunlop', '22000', 2, 'image/index.jpg', '2019-04-20 05:35:47'),
(11, 'Dunlop', '22000', 2, 'image/index1.jpg', '2019-04-20 05:35:47'),
(12, 'Gants Dockers 154', '2400', 2, 'image/index2.jpg', '2019-04-20 05:35:47'),
(13, 'Gants Dockers 204', '2400', 2, 'image/index3.jpg', '2019-04-20 05:35:47'),
(14, 'Gants maitrise', '5000', 2, 'image/index4.jpg', '2019-04-20 05:35:47'),
(15, 'Gilet de sécurité - Chassuble jaune', '4000', 2, 'image/index5.jpg', '2019-04-20 05:35:47'),
(16, 'Gilet de sécurité - Chassuble vert', '4000', 2, 'image/index6.jpg', '2019-04-20 05:35:47'),
(17, 'Gilet de sécurité - Chassuble orange', '4000', 2, 'image/index7.jpg', '2019-04-20 05:35:47'),
(18, 'Lunnete Monolux', '2000', 2, 'image/index8.jpg', '2019-04-20 05:35:47'),
(19, 'Agate gigh', '22500', 2, 'image/index9.jpg', '2019-04-20 05:35:47'),
(20, 'Demi-masque respiratoire', '11500', 2, 'image/index10.jpg', '2019-04-20 05:35:47'),
(21, 'Casque anti-bruit', '6500', 2, 'image/index11.jpg', '2019-04-20 05:35:47');

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `rating` int(2) NOT NULL,
  `customer` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `product_categories`(`id`, `name`) VALUES (1, 'Location'), (2, 'Acheter');

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ALTER TABLE `orders`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `customer` (`customer`),
--   ADD KEY `product` (`product`);

 ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer` (`customer`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer` (`customer`),
  ADD KEY `product` (`product`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer` (`customer`),
  ADD KEY `product` (`product`);

ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `customer_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;


ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`);

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`);

ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `product_categories` (`id`);

ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`);