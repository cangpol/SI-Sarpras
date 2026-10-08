-- phpMyAdmin SQL Dump
-- Host: localhost
-- Generation Time: Oct 09, 2026

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `lost_found` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reporter_name` varchar(150) NOT NULL,
  `reporter_status` varchar(100) NOT NULL,
  `lost_item` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `incident_date` date NOT NULL,
  `incident_time` time NOT NULL,
  `status` enum('reported','found','claimed') NOT NULL DEFAULT 'reported',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `visitor_name` varchar(150) NOT NULL,
  `institution` varchar(150) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `host_name` varchar(150) NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `status` enum('checked_in','checked_out') NOT NULL DEFAULT 'checked_in',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rooms` (`id`, `room_name`, `capacity`) VALUES
(1, 'Excellence', 50),
(2, 'Compassion', 40),
(3, 'Integrity', 40),
(4, 'Auditorium', 200),
(5, 'Multi Function Hall', 150);

CREATE TABLE IF NOT EXISTS `room_bookings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_id` int(11) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `booker_name` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `setup` varchar(255) NOT NULL,
  `material_needed` text DEFAULT NULL,
  `special_request` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_name` varchar(100) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `vehicles` (`id`, `vehicle_name`, `plate_number`) VALUES
(1, 'Toyota Avanza', 'B 1234 ABC'),
(2, 'Toyota Innova', 'B 5678 DEF'),
(3, 'Isuzu Elf', 'B 9101 GHI');

CREATE TABLE IF NOT EXISTS `vehicle_bookings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `booking_day` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `booker_name` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `driver_name` varchar(150) NOT NULL,
  `km_in` int(11) DEFAULT NULL,
  `km_out` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `maintenance_requests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `requester_name` varchar(100) NOT NULL,
  `asset_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','in_progress','resolved') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `supplies` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `supplies` (`id`, `item_name`, `stock`, `unit`) VALUES
(1, 'Kertas A4', 50, 'Rim'),
(2, 'Tinta Printer Hitam', 20, 'Botol'),
(3, 'Spidol Papan Tulis', 100, 'Pcs');

CREATE TABLE IF NOT EXISTS `supply_requests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `supply_id` int(11) UNSIGNED NOT NULL,
  `requester_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`supply_id`) REFERENCES `supplies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;


