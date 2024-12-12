CREATE TABLE `User` (
  `user_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255),
  `email` VARCHAR(255) UNIQUE,
  `password` VARCHAR(255),
  `role` VARCHAR(255) DEFAULT 'user'
);

CREATE TABLE `Category` (
  `category_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255)
);

CREATE TABLE `Product` (
  `product_id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255),
  `size` INT,
  `description` TEXT,
  `price` DECIMAL(10, 3),
  `old_price` DECIMAL(10, 3) DEFAULT NULL,
  `discount` INT DEFAULT NULL,
  `stock` INT,
  `color` VARCHAR(255),
  `category_id` INT,
  `image_url` VARCHAR(255) DEFAULT NULL,
    `is_best_seller` TINYINT(1) DEFAULT 0,
  FOREIGN KEY (`category_id`) REFERENCES `Category` (`category_id`)
);

CREATE TABLE `Order` (
  `order_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT,
  `order_date` DATETIME,
  `status` VARCHAR(255),
  `total_amount` DECIMAL(10, 2),
  FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`)
);

CREATE TABLE `OrderItem` (
  `order_item_id` INT PRIMARY KEY AUTO_INCREMENT,
  `order_id` INT,
  `product_id` INT,
  `quantity` INT,
  `price` DECIMAL(10, 3),
  FOREIGN KEY (`order_id`) REFERENCES `Order` (`order_id`),
  FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`)
);

CREATE TABLE `ShoppingCart` (
  `cart_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT UNIQUE,
  FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`)
);

CREATE TABLE `CartItem` (
  `cart_item_id` INT PRIMARY KEY AUTO_INCREMENT,
  `cart_id` INT,
  `product_id` INT,
  `quantity` INT,
  FOREIGN KEY (`cart_id`) REFERENCES `ShoppingCart` (`cart_id`),
  FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`)
);

CREATE TABLE `PaymentMethod` (
  `payment_id` INT PRIMARY KEY AUTO_INCREMENT,
  `method` VARCHAR(255)
);

CREATE TABLE `PaymentOrder` (
  `order_id` INT,
  `payment_id` INT,
  `payment_date` DATETIME,
  PRIMARY KEY (`order_id`, `payment_id`),
  FOREIGN KEY (`order_id`) REFERENCES `Order` (`order_id`),
  FOREIGN KEY (`payment_id`) REFERENCES `PaymentMethod` (`payment_id`)
);

CREATE TABLE `Favorite` (
  `favorite_id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT,
  `product_id` INT,
  FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`),
  FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`)
);

-- Update price based on discount
UPDATE `Product`
SET `price` = `old_price` * (1 - `discount` / 100)
WHERE `discount` IS NOT NULL AND `old_price` IS NOT NULL;

DELIMITER //

CREATE TRIGGER `update_price_on_discount_change`
BEFORE INSERT ON `Product`
FOR EACH ROW
BEGIN
  IF NEW.discount IS NOT NULL AND NEW.old_price IS NOT NULL THEN
    SET NEW.price = NEW.old_price * (1 - NEW.discount / 100);
  END IF;
END;

//

DELIMITER ;

DELIMITER //

CREATE TRIGGER `update_price_on_discount_change_update`
BEFORE UPDATE ON `Product`
FOR EACH ROW
BEGIN
  IF NEW.discount IS NOT NULL AND NEW.old_price IS NOT NULL THEN
    SET NEW.price = NEW.old_price * (1 - NEW.discount / 100);
  END IF;
END;

//

DELIMITER ;