SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `perfumeshop`

-- Table for Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for Admin
CREATE TABLE `admin` (
  `admin_id` INT NOT NULL AUTO_INCREMENT,
  `admin_name` VARCHAR(255) NOT NULL,
  `admin_password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`admin_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin
INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_password`) VALUES
(1, 'admin', 'admin@#12345');

-- Table for Perfume Products
CREATE TABLE `products` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(255) NOT NULL,
  `brand` VARCHAR(255) NOT NULL,
  `product_price` FLOAT(10,2) NOT NULL,
  `product_code` VARCHAR(255) NOT NULL UNIQUE,
  `product_in_stock` TINYINT(1) NOT NULL,
  `product_discount` FLOAT(3,2) DEFAULT NULL,
  `volume_ml` INT DEFAULT NULL,
  `fragrance_type` VARCHAR(255) DEFAULT NULL,
  `product_detail` MEDIUMTEXT DEFAULT NULL,
  `product_image` VARCHAR(255) DEFAULT NULL,
  `product_quantity` INT DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserting sample perfume products
INSERT INTO `products` (`product_name`, `brand`, `product_price`, `product_code`, `product_in_stock`, `product_discount`, `volume_ml`, `fragrance_type`, `product_detail`, `product_image`, `product_quantity`) VALUES
('Dior Sauvage', 'Dior', 120.00, 'DIOR-SAU-001', 10, 5.00, 100, 'Woody Aromatic', 'A fresh, spicy, and woody fragrance with notes of bergamot and ambroxan.', 'dior_sauvage.jpg', 10),
('Chanel Bleu de Chanel', 'Chanel', 150.00, 'CHANEL-BLEU-002', 12, 7.00, 100, 'Woody Aromatic', 'A sophisticated fragrance with citrus, cedar, and sandalwood.', 'bleu_de_chanel.jpg', 12),
('Armani Acqua di Gio', 'Giorgio Armani', 110.00, 'ARMANI-ACQUA-003', 15, 5.00, 100, 'Aquatic', 'A fresh and marine-inspired scent with citrus and musk.', 'acqua_di_gio.jpg', 15),
('Tom Ford Noir', 'Tom Ford', 180.00, 'TOM-NOIR-004', 8, 10.00, 100, 'Oriental', 'A bold, masculine fragrance with spicy and woody notes.', 'tom_ford_noir.jpg', 8),
('Creed Aventus', 'Creed', 350.00, 'CREED-AVENTUS-005', 5, 0.00, 100, 'Chypre Fruity', 'A rich, powerful scent with pineapple, birch, and musk.', 'creed_aventus.jpg', 5),
('Versace Eros', 'Versace', 130.00, 'VERSACE-EROS-006', 10, 5.00, 100, 'Fresh Oriental', 'A sensual blend of mint, green apple, and vanilla.', 'versace_eros.jpg', 10),
('Dior Homme Intense', 'Dior', 140.00, 'DIOR-HOMME-007', 8, 5.00, 100, 'Floral Woody', 'A rich iris fragrance blended with amber and vetiver.', 'dior_homme_intense.jpg', 8),
('Dior Fahrenheit', 'Dior', 135.00, 'DIOR-FAHRENHEIT-008', 10, 6.00, 100, 'Woody Spicy', 'A bold combination of leather, nutmeg, and lavender.', 'dior_fahrenheit.jpg', 10),
('Chanel Allure Homme Sport', 'Chanel', 145.00, 'CHANEL-ALLURE-009', 12, 5.50, 100, 'Woody Spicy', 'A fresh and invigorating scent.', 'allure_homme_sport.jpg', 12),
('Armani Code', 'Giorgio Armani', 125.00, 'ARMANI-CODE-011', 15, 6.00, 100, 'Oriental Spicy', 'A seductive scent with tonka bean and citrus.', 'armani_code.jpg', 15),
('Tom Ford Oud Wood', 'Tom Ford', 210.00, 'TOM-OUD-013', 6, 12.00, 100, 'Woody Oriental', 'A luxurious blend of oud and spices.', 'tom_ford_oud_wood.jpg', 6),
('Creed Green Irish Tweed', 'Creed', 310.00, 'CREED-IRISH-015', 5, 0.00, 100, 'Fresh Green', 'A classic blend of lemon and sandalwood.', 'green_irish_tweed.jpg', 5),
('Versace Dylan Blue', 'Versace', 120.00, 'VERSACE-DYLAN-017', 10, 5.00, 100, 'Aromatic Fougère', 'A modern fragrance with citrus and black pepper.', 'dylan_blue.jpg', 10),
('Yves Saint Laurent Libre', 'YSL', 155.00, 'YSL-LIBRE-020', 7, 5.00, 100, 'Floral', 'A bold floral scent with lavender and vanilla.', 'ysl_libre.jpg', 7),
('Paco Rabanne 1 Million', 'Paco Rabanne', 130.00, 'PACO-1MILLION-021', 10, 5.00, 100, 'Spicy Woody', 'A blend of cinnamon, rose, and leather.', '1_million.jpg', 10),
('Paco Rabanne Invictus', 'Paco Rabanne', 125.00, 'PACO-INVICTUS-022', 12, 4.50, 100, 'Aquatic Woody', 'A fresh marine scent with grapefruit and ambergris.', 'invictus.jpg', 12);

-- Table for Cart
CREATE TABLE `cart` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT DEFAULT 1,
    `added_on` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `contact` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


COMMIT;
