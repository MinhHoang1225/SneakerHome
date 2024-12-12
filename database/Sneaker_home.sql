CREATE TABLE `User` (
  `user_id` int PRIMARY KEY,
  `name` varchar(255),
  `email` varchar(255),
  `password` varchar(255)
);

CREATE TABLE `Product` (
  `product_id` int PRIMARY KEY,
  `name` varchar(255),
  `size` int,
  `description` text,
  `price` decimal,
  `stock` int,
  `color` varchar(255),
  `category_id` int
);

CREATE TABLE `Category` (
  `category_id` int PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `Order` (
  `order_id` int PRIMARY KEY,
  `user_id` int,
  `order_date` datetime,
  `status` varchar(255),
  `total_amount` decimal
);

CREATE TABLE `OrderItem` (
  `order_item_id` int PRIMARY KEY,
  `order_id` int,
  `product_id` int,
  `quantity` int,
  `price` decimal
);

CREATE TABLE `ShoppingCart` (
  `cart_id` int PRIMARY KEY,
  `user_id` int UNIQUE
);

CREATE TABLE `CartItem` (
  `cart_item_id` int PRIMARY KEY,
  `cart_id` int,
  `product_id` int,
  `quantity` int
);

CREATE TABLE `PaymentOrder` (
  `order_id` int,
  `payment_id` int,
  `payment_date` datetime,
  PRIMARY KEY (`order_id`, `payment_id`)
);

CREATE TABLE `PaymentMethod` (
  `payment_id` int PRIMARY KEY,
  `method` vachar
);

CREATE TABLE `Favorite` (
  `favorite_id` int PRIMARY KEY,
  `user_id` int,
  `product_id` int
);

ALTER TABLE `Product` ADD FOREIGN KEY (`category_id`) REFERENCES `Category` (`category_id`);

ALTER TABLE `Order` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

ALTER TABLE `OrderItem` ADD FOREIGN KEY (`order_id`) REFERENCES `Order` (`order_id`);

ALTER TABLE `OrderItem` ADD FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`);

ALTER TABLE `ShoppingCart` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

ALTER TABLE `CartItem` ADD FOREIGN KEY (`cart_id`) REFERENCES `ShoppingCart` (`cart_id`);

ALTER TABLE `CartItem` ADD FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`);

ALTER TABLE `PaymentOrder` ADD FOREIGN KEY (`order_id`) REFERENCES `Order` (`order_id`);

ALTER TABLE `PaymentOrder` ADD FOREIGN KEY (`payment_id`) REFERENCES `PaymentMethod` (`payment_id`);

ALTER TABLE `Favorite` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

ALTER TABLE `Favorite` ADD FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`);
ALTER TABLE user
MODIFY COLUMN role VARCHAR(255) DEFAULT 'user';
ALTER TABLE user
MODIFY COLUMN user_id INT AUTO_INCREMENT;

ALTER TABLE product 
ADD is_best_seller TINYINT(1) DEFAULT 0,
ADD old_price DECIMAL(10, 2) DEFAULT NULL,
ADD discount INT DEFAULT NULL,
ADD image_url VARCHAR(255) DEFAULT NULL;

UPDATE product
SET price = old_price * (1 - discount / 100)
WHERE discount IS NOT NULL AND old_price IS NOT NULL;

ALTER TABLE product MODIFY id INT NOT NULL AUTO_INCREMENT;