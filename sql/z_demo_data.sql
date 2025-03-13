-- Insert Sample Locations
INSERT INTO locations (name, street_address, city, state, postal_code, country, contact_number, contact_email)
VALUES
('St. Jacobs', '34 Henry Street W', 'St. Jacobs', 'ON', 'N0B 2N0', 'Canada', '(519) 664-2252', 'itsm@homehardware.ca'),
('Elmira', '49 Industrial Dr', 'Elmira', 'ON', 'N3B 3L5', 'Canada', '(519) 669-7841', 'contact@homehardware.ca');

-- Insert sample vendors
INSERT INTO vendors (name, contact_person, contact_phone, contact_email, support_website, support_phone, support_email, sales_email, is_default) VALUES
('TechCorp', 'John Doe', '555-1234', 'support@techcorp.com', 'https://techcorp.com/support', '555-5678', 'help@techcorp.com', 'sales@techcorp.com', TRUE),
('NetSolutions', 'Jane Smith', '555-8765', 'contact@netsolutions.com', 'https://netsolutions.com/help', '555-4321', 'support@netsolutions.com', 'sales@netsolutions.com', FALSE);

-- Insert Sample CI's
INSERT INTO configuration_items (
    name, ci_type_id, description, status, owner, location, ip_address, os_version,
    serial_number, vendor, purchase_date, warranty_expiry, ci_category, contract,
    os_type, service, support_group, application_support_group, vendor_support
) VALUES
('Web Server 1', 1, 'Primary web server', 'Active', 'John Doe', 'Toronto Office', '192.168.1.10', 'Windows Server 2019',
 'ABC12345', 'Dell Technologies', '2021-01-15', '2024-01-15', 'Physical', 'Web Hosting Contract',
 'Windows Server', 'Web Services', 'Support Team A', 'App Support Group B', 'Dell Technologies'),
('Database Server', 1, 'Main Database Server', 'Active', 'Jane Smith', 'Vancouver Office', '192.168.2.20', 'RHEL 8.4',
 'XYZ98765', 'Red Hat Inc.', '2022-05-01', '2025-05-01', 'Virtual', 'Database Management Contract',
 'Linux', 'Database Services', 'Support Team B', 'App Support Group A', 'Red Hat Inc.');