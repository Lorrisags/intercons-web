-- Membuat Database
CREATE DATABASE IF NOT EXISTS intercons_db;
USE intercons_db;

-- ==========================================
-- 1. TABEL ADMIN
-- ==========================================
CREATE TABLE `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (username: admin, password: admin123)
-- Catatan: Untuk keamanan produksi nyata, gunakan fungsi password_hash() (Bcrypt) di PHP, bukan sekadar MD5.
INSERT INTO `admins` (`username`, `password`) VALUES ('admin', MD5('admin123'));


-- ==========================================
-- 2. TABEL PRODUK (KATALOG)
-- ==========================================
CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `image_url` VARCHAR(255),
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert contoh data produk
INSERT INTO `products` (`name`, `category`, `image_url`, `description`) VALUES
('Industrial Gate Valve', 'Mechanical', 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4', 'Gate valve standar industri tahan karat.'),
('Heavy Duty Steel Pipe', 'Material', 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23', 'Pipa baja karbon untuk tekanan tinggi.'),
('Diesel Generator Set 500kVA', 'Electrical', 'https://images.unsplash.com/photo-1581092335397-9583eb92d232', 'Genset diesel untuk backup daya pabrik.');


-- ==========================================
-- 3. TABEL BOOKING & KLIEN
-- ==========================================
CREATE TABLE `bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `client_name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `service_type` VARCHAR(50) NOT NULL,
    `booking_date` DATE NOT NULL,
    `message` TEXT,
    `status` ENUM('Pending', 'Proses', 'Selesai') DEFAULT 'Pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert contoh data booking
INSERT INTO `bookings` (`client_name`, `email`, `service_type`, `booking_date`, `message`, `status`) VALUES
('PT Maju Bersama', 'contact@majubersama.co.id', 'Mechanical Engineering', '2026-04-10', 'Mohon penawaran untuk instalasi pipa pabrik baru kami.', 'Pending'),
('CV Teknik Jaya', 'purchasing@teknikjaya.com', 'Product', '2026-04-05', 'Kebutuhan 50 unit Valve.', 'Selesai');


-- ==========================================
-- 4. TABEL PENGATURAN WEB (STATISTIK DASHBOARD)
-- ==========================================
CREATE TABLE `settings` (
    `setting_key` VARCHAR(50) PRIMARY KEY,
    `setting_value` TEXT
);

-- Insert data default untuk statistik di halaman depan (Home)
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES 
('total_products', '150'), 
('total_reviews', '450'), 
('total_clients', '200'), 
('awards', '25'),
('company_name', 'Intercons'),
('company_email', 'info@intercons.co.id');