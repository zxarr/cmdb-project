CREATE DATABASE IF NOT EXISTS cmdb;
USE cmdb;

-- Ensure the user is created if it does not exist
CREATE USER IF NOT EXISTS 'cmdb_user'@'%' IDENTIFIED BY 'cmdb_pass';
GRANT ALL PRIVILEGES ON cmdb.* TO 'cmdb_user'@'%';
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
    ci_category ENUM('Physical', 'Virtual') NOT NULL,
    contract VARCHAR(255) NULL,
    os_type VARCHAR(100) NULL,
    os_support VARCHAR(255) NULL,
    service VARCHAR(255) NULL,
    support_group VARCHAR(255) NULL,
    application_support_group VARCHAR(255) NULL,
    vendor_support VARCHAR(255) NULL,
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

-- Insert default CI types
INSERT INTO ci_types (name, description) VALUES 
('Server', 'Physical or Virtual Server'),
('Appliance', 'Network or Security Appliance');

CREATE TABLE IF NOT EXISTS configurable_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    field_name VARCHAR(100) NOT NULL,  -- e.g., "location"
    field_value VARCHAR(255) NOT NULL, -- The selectable value
    is_default BOOLEAN DEFAULT FALSE   -- Radio button selection for default
);

-- Insert default locations
INSERT INTO configurable_fields (field_name, field_value, is_default) VALUES 
('location', 'St. Jacobs', TRUE),
('location', 'Elmira', FALSE),
('location', 'Wetaskawin', FALSE),
('location', 'Debert', FALSE);

-- Locations table
CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    street_address VARCHAR(255) NULL,
    city VARCHAR(100) NULL,
    state VARCHAR(100) NULL,
    postal_code VARCHAR(20) NULL,
    country VARCHAR(100) NULL,
    contact_number VARCHAR(20) NULL,
    contact_email VARCHAR(255) NULL,
    is_default BOOLEAN DEFAULT FALSE
);

-- Vendors Table
CREATE TABLE IF NOT EXISTS vendors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    contact_person VARCHAR(255) NULL,
    contact_phone VARCHAR(20) NULL,
    contact_email VARCHAR(255) NULL,
    support_website VARCHAR(255) NULL,
    support_phone VARCHAR(20) NULL,
    support_email VARCHAR(255) NULL,
    sales_email VARCHAR(255) NULL,
    is_default BOOLEAN DEFAULT FALSE
);


-- Include OS Tables
SOURCE /docker-entrypoint-initdb.d/os_tables.sql;

-- Include some Demo Tables
SOURCE /docker-entrypoint-initdb.d/z_demo_data.sql;