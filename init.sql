-- init.sql: create database and tables, and insert a sample admin/doctor/patient
CREATE DATABASE IF NOT EXISTS hms_minimal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hms_minimal;


-- users table: admins, doctors, patients
CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY,
role ENUM('admin','doctor','patient') NOT NULL,
name VARCHAR(100) NOT NULL,
email VARCHAR(150) NOT NULL UNIQUE,
mobile VARCHAR(20) DEFAULT NULL,
password VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- patients table (extra info; optional)
CREATE TABLE IF NOT EXISTS patients (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
unique_id VARCHAR(50) NOT NULL UNIQUE,
dob DATE DEFAULT NULL,
address VARCHAR(255) DEFAULT NULL,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


-- appointments table
CREATE TABLE IF NOT EXISTS appointments (
id INT AUTO_INCREMENT PRIMARY KEY,
patient_id INT NOT NULL,
doctor_id INT NOT NULL,
appointment_date DATETIME NOT NULL,
reason VARCHAR(255) DEFAULT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE
);


-- sample users
INSERT INTO users (role, name, email, mobile, password) VALUES
('admin','Admin User','admin@example.com','+1000000000','$2y$10$w9dyzqG3MmaXFlFuAcFAeO9kZsNL3yz.G0sl9T3cZCwUepcF5pJ6y'),
('doctor','Dr. Smith','drsmith@example.com','+1000000001','$2y$10$ZfYqixN3Rmk8jE/wmThh4OSKBgQ9HEj.N3NQw4XatDZ5JpOtcnV3K'),
('patient','John Doe','john@example.com','+1000000002','$2y$10$CeWZFtLzC2uQOTZwROn9xOSvdQIMH6Ht4QGH2Y2ex3fXxZFTXtbZ2');



-- Note: The above uses inline PHP to show hashing idea. In practice, run PHP to get hashed values or use the provided credentials section below.