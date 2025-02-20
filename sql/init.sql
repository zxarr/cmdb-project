CREATE DATABASE IF NOT EXISTS cmdb;
USE cmdb;

-- Ensure the user is created if it does not exist
CREATE USER IF NOT EXISTS 'cmdb_user'@'%' IDENTIFIED BY 'cmdb_pass';

-- Grant all necessary privileges to the user
GRANT ALL PRIVILEGES ON cmdb.* TO 'cmdb_user'@'%';

-- Apply changes
FLUSH PRIVILEGES;

-- Table for storing CI types
CREATE TABLE IF NOT EXISTS ci_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Table for storing Configuration Items (CIs)
CREATE TABLE IF NOT EXISTS configuration_items (
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

-- Table for storing notes with timestamps
CREATE TABLE IF NOT EXISTS ci_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ci_id INT NOT NULL,
    note TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ci_id) REFERENCES configuration_items(id) ON DELETE CASCADE
);
