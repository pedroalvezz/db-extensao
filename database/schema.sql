-- Schema for Charity Portal
SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS `charity_portal` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `charity_portal`;

-- Users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','donor','volunteer') NOT NULL DEFAULT 'donor',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Institutions
CREATE TABLE IF NOT EXISTS institutions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  email VARCHAR(150),
  phone VARCHAR(50),
  address VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Events
CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  institution_id INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  event_date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_events_institution FOREIGN KEY (institution_id) REFERENCES institutions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Donations
CREATE TABLE IF NOT EXISTS donations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  institution_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  description VARCHAR(255),
  donated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_donations_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_donations_institution FOREIGN KEY (institution_id) REFERENCES institutions(id) ON DELETE CASCADE,
  INDEX idx_donations_inst (institution_id),
  INDEX idx_donations_user (user_id)
) ENGINE=InnoDB;

-- Gamification: badges and user points
CREATE TABLE IF NOT EXISTS badges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  criteria VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user_badges (
  user_id INT NOT NULL,
  badge_id INT NOT NULL,
  awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, badge_id),
  CONSTRAINT fk_user_badges_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_user_badges_badge FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
) ENGINE=InnoDB;

ALTER TABLE users ADD COLUMN IF NOT EXISTS points INT NOT NULL DEFAULT 0;

-- Seed data
INSERT IGNORE INTO users (id, name, email, password_hash, role, points) VALUES
  (1, 'Admin', 'admin@local', '$2y$10$T8gJk7Lh2XxPz8y1tV0N3uJK0uV3Nf1sAyU4b1tE4K6jE6t2dBG4e', 'admin', 0);

INSERT IGNORE INTO institutions (id, name, description, email, phone, address) VALUES
  (1, 'Instituto Esperança', 'Apoio a famílias carentes', 'contato@esperanca.org', '1199999-9999', 'Rua A, 123, SP'),
  (2, 'Lar dos Amigos', 'Abrigo de idosos', 'contato@lardosamigos.org', '1188888-8888', 'Av B, 456, SP');

INSERT IGNORE INTO badges (id, name, criteria) VALUES
  (1, 'Primeira Doação', 'first_donation'),
  (2, 'Doações Bronze', 'total_amount>=100'),
  (3, 'Doações Prata', 'total_amount>=500'),
  (4, 'Doações Ouro', 'total_amount>=1000');
