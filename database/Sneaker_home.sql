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


INSERT INTO `product`(`product_id`, `name`, `size`, `description`, `price`, `old_price`, `discount`, `stock`, `color`, `category_id`, `image_url`, `is_best_seller`) 
VALUES 
(1, 'Puma Mule Ribbon Black', '38', 'A modern slip-on shoe featuring a rounded toe and a stylish ribbon accent. Perfect for daily wear.', 1000000, 1200000, 17, 50, 'Black', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_UYkQMiEBDgG2s52vA3KhrCEB.jpg', 1),
(2, 'Puma Mule Ribbon White Black', '39', 'A fashionable mule shoe with a ribbon detail, featuring black and white tones.', 1200000, 1400000, 14, 45, 'White/Black', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_BlRpRJxaI67J5eb1cxWxa5hD.jpg', 1),
(3, 'Puma Slip on Bale Bari Mule White', '40', 'A minimalist mule-style slip-on shoe in a clean white tone.', 1900000, 2000000, 5, 30, 'White', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_Dp7ZODMnv97b3OoVs9z57QYX.png', 1),
(4, 'Puma Slip on Bale Bari Mule Black', '38', 'Comfortable mule design in sleek black for daily activities.', 1350000, 1550000, 13, 40, 'Black', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_e6Su1cxQooeQVIHl10euNK2H.jpg', 1),
(5, 'Puma RS-Fast International', '41', 'A bold design inspired by global influences with vibrant colors.', 3200000, 3420000, 6, 25, 'Multi-color', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_b2ovLNNI1w3NLeQR0kgQU5jq.jpg', 1),
(6, 'Puma Porsche Legacy x RS-Fast Black Carrot', '42', 'Collaboration with Porsche Legacy featuring black and orange tones.', 6300000, 7000000, 10, 20, 'Black/Orange', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_pLvXM1ql1LKOsQZJIC7iyCNz.jpg', 1),
(7, 'Puma J. Cole x RS-Dreamer Jr Ebony Ivory', '40', 'Special sneaker in black/white for fans of J. Cole.', 3000000, 3500000, 14, 35, 'Black/White', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_qgY0nJMQeyNShMvEeHR9NZsi.jpg', 1),
(8, 'Puma J. Cole x RS-Dreamer 2 Off-Season Red', '39', 'High-performance sneaker in vibrant red for street style lovers.', 4200000, 5000000, 16, 30, 'Red', 1, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_igLaig6Oy2KX38CXwnZMWMW7.png', 1),
(9, 'Nike Air Max 90 Lucha Libre', '42', 'Bold colors inspired by Mexican wrestling culture.', 4400000, 4800000, 8, 20, 'Multi-color', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_6w4KmkYosjIyZQ9W4hiQqlDl.png', 0),
(10, 'Nike Air Max 90 Nordic Christmas', '38', 'Holiday-themed Air Max with Nordic patterns and festive colors.', 6300000, 7200000, 13, 18, 'Red/Green', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_hJrxOJaghi4UbbohE5LHk0jJ.png', 0),
(11, 'Nike Air Max 90 SE Remix Pack', '41', 'Street-ready design featuring mixed materials and bold patterns.', 7300000, 8000000, 9, 12, 'Black/Multi', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_esB2EMVEf7zluDRpFQwey9vo.png', 0),
(12, 'Adidas Superstar Pride Pack', '39', 'Classic Superstar with vibrant Pride-themed details.', 2200000, 2500000, 12, 40, 'White/Multi', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_superstar-pride.jpg', 1),
(13, 'Adidas Stan Smith Parley Edition', '40', 'Sustainable design with Parley ocean plastics in classic white.', 2700000, 3000000, 10, 28, 'White/Green', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_stan-parley.jpg', 1),
(14, 'New Balance 574 Core Grey', '41', 'Timeless 574 sneaker design in a neutral grey tone.', 2100000, 2500000, 16, 35, 'Grey', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_nb574-core-grey.jpg', 0),
(15, 'New Balance 327 Black White', '38', 'Modern retro style with bold black and white contrast.', 2700000, 3000000, 10, 25, 'Black/White', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_nb327-bw.jpg', 0);
(17, 'Herschel Dawson Vintage Floral Backpack', 'One Size', 'A charming and functional backpack featuring a vintage floral pattern. Its spacious design with drawstring and buckle closures makes it perfect for everyday use.', 590000, 413000, 0.30, 100, 'Multicolor', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_56l62LRpw1LcF56zef1BFcTC.png', 0),
(18, 'Herschel Dawson Light Navy Backpack', 'One Size', 'Classic and practical, this backpack in light navy blue exudes elegance. Ideal for carrying essentials with its multiple compartments and durable build.', 490000, 343000, 0.30, 150, 'Light Navy', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_rnGXzeSKqUlpp5USdSygH6qh.png', 1),
(19, 'Herschel Little America Light Black Backpack', 'One Size', 'An iconic Herschel design in a sleek light black color. Combining modern functionality with a timeless mountaineering-inspired silhouette.', 1250000, 875000, 0.30, 120, 'Black', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_tlo7gSE2dhRRAMkxCCwr2Fcg.png', 1),
(20, 'Herschel Little America Light Rose Backpack', 'One Size', 'Stylish and feminine, this backpack in light rose is a perfect choice for those who love a subtle yet elegant look. Great for school, work, or travel.', 1250000, 875000, 0.30, 90, 'Light Rose', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_V2srdt0gM0joGtdt87E9Q3Hp.png', 0),
(21, 'MLB Coolfield Unstructured New York Yankees ‘Black’ Hat', 'One Size', 'A lightweight and unstructured cap showcasing the New York Yankees logo in classic black, blending sporty style with everyday comfort.', 1250000, 875000, 0.30, 200, 'Black', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_HmJQKxnb95NTUuOaSUzvWw7N.jpg', 0),
(22, 'Nike Sportswear Heritage86 Beach Cap', 'One Size', 'A casual beach cap with a relaxed fit, offering timeless style and sun protection. Designed with breathable material for all-day comfort.', 12500000, 8750000, 0.30, 50, 'Beige', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_SD6LivykN20bSwC17H7mcmqx.png', 0),
(23, 'Fear Of God Essentials RC 9Fifty Cap Moonstruck', 'One Size', 'A premium cap in a neutral "Moonstruck" tone, merging Fear Of God\'s minimalist aesthetic with modern streetwear trends.', 1790000, 1253000, 0.30, 75, 'Moonstruck', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_9l8KNOdb8wCRM3msgx3tTWGj.png', 1),
(24, 'Nike U NK H86 CAP Washed Hat', 'One Size', 'A washed-out finish gives this classic Nike cap a vintage vibe. Perfect for laid-back outfits or casual outings.', 1299000, 1100000, 0.15, 100, 'Washed Out', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_uHB0Hp07MEgxRHahYeJ0wvBF.png', 0),
(25, 'Drew House Corduroy Bucket Hat', 'One Size', 'Made with soft corduroy fabric, this bucket hat adds a playful touch to your look. A unique and trendy accessory from Drew House.', 490000, 343000, 0.30, 60, 'Corduroy', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_FfcXOHhTikRbRjd76Ex9iORq.png', 0),
(26, 'HAPPY SOCKS', 'One Size', 'Bright and cheerful, Happy Socks add a splash of color to any outfit. Designed for comfort and individuality.', 450000, 315000, 0.30, 150, 'Multicolor', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_ZHhPVnnDnoCAUqS3Yjo1QT2L.jpg', 1),
(27, 'HAPPY SOCKS Zebra socks', 'One Size', 'A bold design featuring zebra stripes, these socks are perfect for anyone who loves a wild and fun style.', 450000, 315000, 0.30, 120, 'Zebra', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_mDmY6Nt69WhbZE8JLTNOLy9D.jpg', 1),
(28, 'HAPPY SOCKS Faded Diamond socks', 'One Size', 'An eye-catching diamond pattern with faded colors, adding a retro flair to your sock collection.', 450000, 315000, 0.30, 110, 'Diamond', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_nCwgHnds4kwoXRegH79OgeDA.jpg', 0),
(29, 'HAPPY SOCKS Stripe socks', 'One Size', 'Classic striped socks that combine versatility and vibrant color schemes to elevate your everyday outfits.', 3999000, 3890000, 0.03, 200, 'Stripe', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_c9postbwNv0g04S2fdM8ib3b.jpg', 0),
(16, 'Gucci Black Square Eyeglasses', 'One Size', 'Sleek and sophisticated, these black square eyeglasses feature a classic frame design, perfect for a polished look.', 4010000, 3590000, 0.10, 50, 'Black', 3, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_1mINi5TvffImzn5qwBYqS0N1.png', 0);
(30, 'Fear Of God Essentials SS Polo String Polo Shirt', 'M', 'A sleek and versatile polo shirt in a neutral "String" tone. Features minimalist branding and a relaxed fit for effortless style.', 3500000, 3200000, 10, 100, 'String', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_6oxLHeUye7EdYCS8qqbwhzWq.png', 1),
(31, 'Fear Of God Essentials Pullover Mockneck Dark Heather Oatmeal Sweater', 'L', 'A cozy pullover sweater in dark heather oatmeal. Features a mock neck design and premium materials for elevated comfort and warmth.', 4800000, 4200000, 12, 150, 'Dark Heather Oatmeal', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_SwEKJJNmjz7ybiiEFqd00oNu.png', 1),
(32, 'Nike AS M NSW Club JGGR FT ‘Black’ Pants', 'M', 'A playful and trendy T-shirt featuring a baby face graphic with an ice cream design. The soft white fabric offers casual style with a fun twist.', 2500000, 2200000, 8, 200, 'Black', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_fRHX6vcvF0tqQxclAPTY48Bq.png', 0),
(33, 'Fear Of God Essentials Dark Heather Oatmeal Sweatshorts', 'L', 'A refined polo shirt with a color-blocked design. Blends Lacoste\'s timeless elegance with modern details for versatile wear.', 2700000, 2400000, 7, 120, 'Dark Heather Oatmeal', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_HFTsYxmGNioC9DibHujmnGle.png', 0),
(34, 'ADLV Baby Face Short Sleeve T-Shirt White Ice Cream', 'S', 'A comfortable hoodie with Stussy\'s iconic logo. Perfect for layering or casual streetwear looks.', 3200000, 2900000, 10, 180, 'White Ice Cream', 2, 'https://pos.nvncdn.com/eb9ddb-116318/ps/20220323_rQFbw7rf2n8cXtMXcqL4yWLB.png', 0),
(35, 'Lacoste Men’s Color Matching Polo PH3461-51G-001', 'M', 'A neutral-toned, oversized T-shirt designed with simplicity in mind. A wardrobe staple for both casual and elevated looks.', 2800000, 2400000, 15, 250, 'Color Matching', 2, 'https://authentic-shoes.com/wp-content/uploads/2023/04/5421_75352a641c394557b7078a14bf9d2af4-300x314.png', 1),
(36, 'Adidas Originals Waffle Jacket ‘Beige’ JW0109', 'L', 'A stylish beige jacket with a textured waffle finish. Perfect for layering, offering both warmth and a laid-back vibe.', 5500000, 4900000, 9, 100, 'Beige', 2, 'https://authentic-shoes.com/wp-content/uploads/2024/10/WAFFLE_BBTT_White_JW0109_01_layd-300x300.png', 0),
(37, 'Nike Sportswear ‘Swoosh’ Woven Black Windbreaker AR3133 010', 'M', 'A lightweight windbreaker featuring Nike\'s bold Swoosh logo. Combines sporty functionality with modern aesthetics.', 3700000, 3300000, 14, 130, 'Black', 2, 'https://authentic-shoes.com/wp-content/uploads/2023/04/o1cn01gprxcf23gtgazhav8___2518497228.jpg_400x400_32e5b16f9e5d49858f603a49db5a88fb-300x300.png', 1),
(38, 'Nike Sportswear Club PrimaLoft ‘Black’ FB7374-010', 'XL', 'An insulated black jacket with PrimaLoft technology for superior warmth and lightweight comfort. Ideal for cooler weather.', 4900000, 4300000, 10, 160, 'Black', 2, 'https://authentic-shoes.com/wp-content/uploads/2024/01/Ao-Khoac-Nike-Sportswear-Club-PrimaLoft-Black-FB7374-010-2-300x375.png', 0),
(39, 'Canada Goose Citadel Parka ‘Black’ 4567M-61', 'XXL', 'A high-performance parka designed for extreme cold, featuring a luxurious fur-lined hood and a durable black shell.', 10000000, 9000000, 18, 80, 'Black', 2, 'https://authentic-shoes.com/wp-content/uploads/2024/10/canada-goose-4567m-61-1-300x300.png', 1),
(40, 'The North Face 1996 Eco Nuptse Jacket ‘Black’ NJ1DP75C', 'M', 'A classic puffer jacket made with eco-friendly materials. Offers a perfect combination of warmth, functionality, and iconic style.', 7500000, 6800000, 10, 110, 'Black', 2, 'https://authentic-shoes.com/wp-content/uploads/2024/01/Ao-The-North-Face-1996-Eco-Nuptse-Jacket-Black-NJ1DP75C-1-300x300.png', 0),
(41, 'Stussy Basic Stussy Hoodie 2023 ‘Black’', 'L', 'A cozy jumper with a high stand neck and a bold Yankees logo. Designed for comfort and a sporty aesthetic.', 4300000, 3900000, 7, 140, 'Black', 2, 'https://authentic-shoes.com/wp-content/uploads/2023/04/1924762_blac_2_89dd3821-32c6-4b38-8dcf-cc7a477660e9_1728x_a65e43be3158499291660d48f07a7279-300x309.png', 1),
(42, 'MLB Basic Stand Neck Mega Logo Plush Jumper NY Yankees 3AJPF0416-50CRS', 'M', 'Classic black jogger pants crafted from soft fleece material. Features a tapered fit and Nike branding for everyday wear.', 2600000, 2300000, 10, 180, 'Black', 2, 'https://authentic-shoes.com/wp-content/uploads/2023/04/3ajpf0416-50crs-4778803449807410_9d175d1537d44079b3b46f6fc3551fab-300x300.png', 0),
(43, 'Fear Of God Essentials T-Shirt ‘Taupe’', 'M', 'Comfortable sweatshorts in a dark heather oatmeal tone. Minimalist design and premium materials make them perfect for relaxed casual looks.', 3200000, 2700000, 8, 150, 'Taupe', 2, 'https://authentic-shoes.com/wp-content/uploads/2023/04/fear-of-god-essentials-t-shirt-t_966e19adba044b6c98c54b9f939d9a24-300x282.png', 0);

