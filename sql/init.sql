CREATE DATABASE IF NOT EXISTS cmdb;
USE cmdb;

CREATE TABLE ci_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE configuration_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ci_type_id INT,
    description TEXT,
    status ENUM('Active', 'Inactive', 'Retired') DEFAULT 'Active',
    owner VARCHAR(255) NOT NULL,
    location VARCHAR(255) NULL,
    ip_address VARCHAR(45) NULL,
    os_version VARCHAR(100) NULL,
    serial_number VARCHAR(100) NULL,
    vendor VARCHAR(255) NULL,
    purchase_date DATE NULL,
    warranty_expiry DATE NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ci_type_id) REFERENCES ci_types(id) ON DELETE SET NULL
);

CREATE TABLE ci_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ci_id INT NOT NULL,
    note TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ci_id) REFERENCES configuration_items(id) ON DELETE CASCADE
);
