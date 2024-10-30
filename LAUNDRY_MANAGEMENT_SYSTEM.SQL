CREATE DATABASE NEW_DATABASE;

USE NEW_DATABASE;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL,
  `firstname` VARCHAR(50) NOT NULL,
  `lastname` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `confirmPassword` VARCHAR(50) NOT NULL,
  `role` ENUM('customer','admin') NOT NULL,
  `profile_picture` VARCHAR(255) DEFAULT NULL
);

CREATE TABLE `book_service` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `book_date` DATE NOT NULL,
  `product_id` INT(11) NOT NULL,
  `reply_message` TEXT DEFAULT NULL,
  `finish_day` DATE DEFAULT NULL,
  `status` ENUM('pending','replied') DEFAULT 'pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `progress` INT(11) DEFAULT 0
);

CREATE TABLE `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `file` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `category` VARCHAR(255) DEFAULT NULL
);

CREATE TABLE `book_requests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11) DEFAULT NULL,
  `product_id` INT(11) DEFAULT NULL,
  `request_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `reply_message` TEXT DEFAULT NULL,
  `finish_day` DATE DEFAULT NULL,
  `status` ENUM('pending','replied') DEFAULT 'pending'
);
