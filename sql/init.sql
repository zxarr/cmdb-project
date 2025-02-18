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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ci_type_id) REFERENCES ci_types(id) ON DELETE SET NULL
);