
-- Windows OS Table
CREATE TABLE IF NOT EXISTS windows_os (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version_name VARCHAR(100) NOT NULL,
    version VARCHAR(20) NOT NULL,
    codename VARCHAR(100),
    release_date DATE
);

INSERT INTO windows_os (version_name, version, codename, release_date) VALUES
('Windows XP', '5.1', 'Whistler', '2001-10-25'),
('Windows Vista', '6.0', 'Longhorn', '2007-01-30'),
('Windows 7', '6.1', 'Blackcomb', '2009-10-22'),
('Windows 8', '6.2', 'Jupiter', '2012-10-26'),
('Windows 8.1', '6.3', 'Blue', '2013-10-17'),
('Windows 10', '10.0', 'Threshold 1', '2015-07-29'),
('Windows 11', '10.0', 'Sun Valley', '2021-10-05');

CREATE TABLE IF NOT EXISTS windows_server_os (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version_name VARCHAR(100) NOT NULL,
    version VARCHAR(20) NOT NULL,
    codename VARCHAR(100),
    release_date DATE
);
-- Insert data into windows_server_os table
INSERT INTO windows_server_os (version_name, codename, version, release_date) VALUES
('Windows Server 2003', 'Whistler Server', '5.2', '2003-04-24'),
('Windows Server 2003 R2', 'Whistler Server R2', '5.2', '2005-12-06'),
('Windows Server 2008', 'Longhorn Server', '6.0', '2008-02-27'),
('Windows Server 2008 R2', 'Windows Server 7', '6.1', '2009-10-22'),
('Windows Server 2012', 'Windows Server 8', '6.2', '2012-09-04'),
('Windows Server 2012 R2', 'Windows Server Blue', '6.3', '2013-10-17'),
('Windows Server 2016', 'Redstone', '10.0', '2016-10-12'),
('Windows Server 2019', 'Redstone 5', '10.0', '2018-10-02'),
('Windows Server 2022', 'Iron', '10.0', '2021-08-18'),
('Windows Server 2025', 'Germanium', '10.0', '2024-11-01');

-- Linux OS Table
-- Create table for Linux operating systems
CREATE TABLE IF NOT EXISTS linux_os (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version_name VARCHAR(100) NOT NULL,
    version VARCHAR(20) NOT NULL,
    codename VARCHAR(100),
    release_date DATE
);

-- Insert data into linux_os table
INSERT INTO linux_os (version_name, version, codename, release_date) VALUES
-- Red Hat Enterprise Linux (RHEL) Releases
('Red Hat Enterprise Linux', '2.1', 'Pensacola', '2002-05-17'),
('Red Hat Enterprise Linux', '2.1 Update 1', 'Pensacola', '2003-02-19'),
('Red Hat Enterprise Linux', '2.1 Update 2', 'Pensacola', '2003-09-03'),
('Red Hat Enterprise Linux', '2.1 Update 3', 'Pensacola', '2004-01-28'),
('Red Hat Enterprise Linux', '2.1 Update 4', 'Pensacola', '2004-08-18'),
('Red Hat Enterprise Linux', '2.1 Update 5', 'Pensacola', '2005-05-18'),
('Red Hat Enterprise Linux', '2.1 Update 6', 'Pensacola', '2006-03-15'),
('Red Hat Enterprise Linux', '2.1 Update 7', 'Pensacola', '2007-02-07'),
('Red Hat Enterprise Linux', '3', 'Taroon', '2003-10-22'),
('Red Hat Enterprise Linux', '3 Update 1', 'Taroon', '2004-02-17'),
('Red Hat Enterprise Linux', '3 Update 2', 'Taroon', '2004-06-16'),
('Red Hat Enterprise Linux', '3 Update 3', 'Taroon', '2004-12-01'),
('Red Hat Enterprise Linux', '3 Update 4', 'Taroon', '2005-06-09'),
('Red Hat Enterprise Linux', '3 Update 5', 'Taroon', '2005-11-15'),
('Red Hat Enterprise Linux', '3 Update 6', 'Taroon', '2006-07-20'),
('Red Hat Enterprise Linux', '3 Update 7', 'Taroon', '2006-12-13'),
('Red Hat Enterprise Linux', '3 Update 8', 'Taroon', '2007-07-20'),
('Red Hat Enterprise Linux', '3 Update 9', 'Taroon', '2007-12-12'),
('Red Hat Enterprise Linux', '4', 'Nahant', '2005-02-14'),
('Red Hat Enterprise Linux', '4 Update 1', 'Nahant', '2005-06-09'),
('Red Hat Enterprise Linux', '4 Update 2', 'Nahant', '2005-10-05'),
('Red Hat Enterprise Linux', '4 Update 3', 'Nahant', '2006-03-15'),
('Red Hat Enterprise Linux', '4 Update 4', 'Nahant', '2006-08-11'),
('Red Hat Enterprise Linux', '4 Update 5', 'Nahant', '2007-03-14'),
('Red Hat Enterprise Linux', '4 Update 6', 'Nahant', '2007-08-15'),
('Red Hat Enterprise Linux', '4 Update 7', 'Nahant', '2008-03-19'),
('Red Hat Enterprise Linux', '4 Update 8', 'Nahant', '2008-11-19'),
('Red Hat Enterprise Linux', '4 Update 9', 'Nahant', '2011-02-16'),
('Red Hat Enterprise Linux', '5', 'Tikanga', '2007-03-14'),
('Red Hat Enterprise Linux', '5.1', 'Tikanga', '2007-11-07'),
('Red Hat Enterprise Linux', '5.2', 'Tikanga', '2008-05-21'),
('Red Hat Enterprise Linux', '5.3', 'Tikanga', '2009-01-20'),
('Red Hat Enterprise Linux', '5.4', 'Tikanga', '2009-09-02'),
('Red Hat Enterprise Linux', '5.5', 'Tikanga', '2010-03-30'),
('Red Hat Enterprise Linux', '5.6', 'Tikanga', '2011-01-13'),
('Red Hat Enterprise Linux', '5.7', 'Tikanga', '2011-07-21'),
('Red Hat Enterprise Linux', '5.8', 'Tikanga', '2012-02-20'),
('Red Hat Enterprise Linux', '5.9', 'Tikanga', '2013-01-08'),
('Red Hat Enterprise Linux', '5.10', 'Tikanga', '2013-10-01'),
('Red Hat Enterprise Linux', '5.11', 'Tikanga', '2014-09-16'),
('Red Hat Enterprise Linux', '6', 'Santiago', '2010-11-10'),
('Red Hat Enterprise Linux', '6.1', 'Santiago', '2011-05-19'),
('Red Hat Enterprise Linux', '6.2', 'Santiago', '2011-12-06'),
('Red Hat Enterprise Linux', '6.3', 'Santiago', '2012-06-20'),
('Red Hat Enterprise Linux', '6.4', 'Santiago', '2013-02-21'),
('Red Hat Enterprise Linux', '6.5', 'Santiago', '2013-11-21'),
('Red Hat Enterprise Linux', '6.6', 'Santiago', '2014-10-14'),
('Red Hat Enterprise Linux', '6.7', 'Santiago', '2015-07-22'),
('Red Hat Enterprise Linux', '6.8', 'Santiago', '2016-05-10'),
('Red Hat Enterprise Linux', '6.9', 'Santiago', '2017-03-21'),
('Red Hat Enterprise Linux', '6.10', 'Santiago', '2018-06-19'),
('Red Hat Enterprise Linux', '7', 'Maipo', '2014-06-10'),
('Red Hat Enterprise Linux', '7.1', 'Maipo', '2015-03-05'),
('Red Hat Enterprise Linux', '7.2', 'Maipo', '2015-11-19'),
('Red Hat Enterprise Linux', '7.3', 'Maipo', '2016-11-03'),
('Red Hat Enterprise Linux', '7.4', 'Maipo', '2017-08-01'),
('Red Hat Enterprise Linux', '7.5', 'Maipo', '2018-04-10'),
('Red Hat Enterprise Linux', '7.6', 'Maipo', '2018-10-30'),
('Red Hat Enterprise Linux', '7.7', 'Maipo', '2019-08-06'),
('Red Hat Enterprise Linux', '7.8', 'Maipo', '2020-03-31'),
('Red Hat Enterprise Linux', '7.9', 'Maipo', '2020-09-29'),
('Red Hat Enterprise Linux', '8', 'Ootpa', '2019-05-07'),
('Red Hat Enterprise Linux', '8.1', 'Ootpa', '2019-11-05'),
('Red Hat Enterprise Linux', '8.2', 'Ootpa', '2020-04-28'),
('Red Hat Enterprise Linux', '8.3', 'Ootpa', '2020-10-29'),
('Red Hat Enterprise Linux', '8.4', 'Ootpa', '2021-05-18'),
('Red Hat Enterprise Linux', '8.5', 'Ootpa', '2021-11-09'),
('Red Hat Enterprise Linux', '8.6', 'Ootpa', '2022-05-11'),
('Red Hat Enterprise Linux', '8.7', 'Ootpa', '2022-11-09'),
('Red Hat Enterprise Linux', '8.8', 'Ootpa', '2023-05-16'),
('Red Hat Enterprise Linux', '9', 'Plow', '2022-05-17'),
('Red Hat Enterprise Linux', '9.1', 'Plow', '2022-11-15'),
('Red Hat Enterprise Linux', '9.2', 'Plow', '2023-05-10');

-- Create table for macOS versions
CREATE TABLE IF NOT EXISTS macos_versions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version_name VARCHAR(100) NOT NULL,
    version VARCHAR(20) NOT NULL,
    codename VARCHAR(100),
    release_date DATE
);

-- Insert data into macos_versions table
INSERT INTO macos_versions (version_name, version, codename, release_date) VALUES
('MacOS', '10.0', 'Cheetah', '2001-03-24'),
('MacOS', '10.1', 'Puma', '2001-09-25'),
('MacOS', '10.2', 'Jaguar', '2002-08-24'),
('MacOS', '10.3', 'Panther', '2003-10-24'),
('MacOS', '10.4', 'Tiger', '2005-04-29'),
('MacOS', '10.5', 'Leopard', '2007-10-26'),
('MacOS', '10.6', 'Snow Leopard', '2009-08-28'),
('MacOS', '10.7', 'Lion', '2011-07-20'),
('MacOS', '10.8', 'Mountain Lion', '2012-07-25'),
('MacOS', '10.9', 'Mavericks', '2013-10-22'),
('MacOS', '10.10', 'Yosemite', '2014-10-16'),
('MacOS', '10.11', 'El Capitan', '2015-09-30'),
('MacOS', '10.12', 'Sierra', '2016-09-20'),
('MacOS', '10.13', 'High Sierra', '2017-09-25'),
('MacOS', '10.14', 'Mojave', '2018-09-24'),
('MacOS', '10.15', 'Catalina', '2019-10-07'),
('MacOS', '11.0', 'Big Sur', '2020-11-12'),
('MacOS', '12.0', 'Monterey', '2021-10-25'),
('MacOS', '13.0', 'Ventura', '2022-10-24'),
('MacOS', '14.0', 'Sonoma', '2023-09-26'),
('MacOS', '15.0', 'Sequoia', '2024-09-16');