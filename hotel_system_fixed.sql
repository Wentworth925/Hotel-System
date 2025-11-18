-- hotel_system_fixed.sql
CREATE DATABASE IF NOT EXISTS `hotel_system_fixed` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `hotel_system_fixed`;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_number VARCHAR(50) NOT NULL,
  type VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  description TEXT,
  image_path VARCHAR(255),
  status ENUM('available','unavailable') DEFAULT 'available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_id INT NOT NULL,
  guest_name VARCHAR(150) NOT NULL,
  guest_contact VARCHAR(150),
  check_in DATE NOT NULL,
  check_out DATE NOT NULL,
  notes TEXT,
  total_cost DECIMAL(10,2) NOT NULL,
  created_by INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO users (username, password_hash, role) VALUES
('admin', '$2y$10$8nTslrSFS6N0B47O6eQUAeonGNzcRCjSc5MiNmiY6L0H944kaW1Ee', 'admin');

INSERT INTO rooms (room_number, type, price, description, status) VALUES
('101', 'Single', 45.00, 'Cozy single room', 'available'),
('102', 'Double', 70.00, 'Double with balcony', 'available');
