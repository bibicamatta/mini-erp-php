CREATE DATABASE IF NOT EXISTS mini_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mini_erp;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS clients (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NULL,
    company VARCHAR(150) NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_clients_status (status),
    INDEX idx_clients_name (name)
);

INSERT INTO users (name, email, password)
VALUES ('Beatriz', 'demo@mini-erp.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC2z4LyhJQ0VgQX1QmK')
ON DUPLICATE KEY UPDATE email = email;

INSERT INTO clients (name, email, phone, company, status) VALUES
('Marina Oliveira', 'marina@example.com', '(11) 99999-1111', 'Trama Audiovisual', 'active'),
('Lucas Mendes', 'lucas@example.com', '(11) 98888-2222', 'Mendes Tech', 'active'),
('Ana Souza', 'ana@example.com', '(11) 97777-3333', 'Studio Ana', 'inactive');
