-- =========================
-- DATABASE
-- =========================
CREATE DATABASE IF NOT EXISTS suro_fragrance;
USE suro_fragrance;

-- =========================
-- TABLE: KATEGORI
-- =========================
CREATE TABLE IF NOT EXISTS kategori (
                                        id_kategori INT AUTO_INCREMENT PRIMARY KEY,
                                        nama_kategori VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- =========================
-- TABLE: PARFUM
-- =========================
CREATE TABLE IF NOT EXISTS parfum (
                                      id_parfum INT AUTO_INCREMENT PRIMARY KEY,
                                      nama_parfum VARCHAR(150),
    brand VARCHAR(100),
    harga INT,
    stok INT,
    deskripsi TEXT,
    gambar TEXT,
    id_kategori INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
    );

-- =========================
-- TABLE: PELANGGAN
-- =========================
CREATE TABLE IF NOT EXISTS pelanggan (
                                         id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
                                         nama VARCHAR(100),
    email VARCHAR(100),
    no_hp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- =========================
-- TABLE: TRANSAKSI
-- =========================
CREATE TABLE IF NOT EXISTS transaksi (
                                         id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
                                         id_pelanggan INT,
                                         total INT,
                                         tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                         FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
    );

-- =========================
-- TABLE: DETAIL TRANSAKSI
-- =========================
CREATE TABLE IF NOT EXISTS detail_transaksi (
                                                id_detail INT AUTO_INCREMENT PRIMARY KEY,
                                                id_transaksi INT,
                                                id_produk INT,
                                                qty INT,
                                                harga INT,
                                                FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi),
    FOREIGN KEY (id_produk) REFERENCES parfum(id_parfum)
    );

-- =========================
-- TABLE: USERS (LOGIN)
-- =========================
CREATE TABLE IF NOT EXISTS users (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     username VARCHAR(100),
    email VARCHAR(100),
    password_hash VARCHAR(255),
    role ENUM('admin', 'customer') DEFAULT 'customer',
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- =========================
-- DATA KATEGORI
-- =========================
INSERT INTO kategori (nama_kategori) VALUES
                                         ('Eau de Parfum'),
                                         ('Eau de Toilette'),
                                         ('Hair Mist'),
                                         ('Scented Candle'),
                                         ('Extrait de Parfum');

-- =========================
-- DATA PARFUM
-- =========================
INSERT INTO parfum (nama_parfum, brand, harga, stok, deskripsi, gambar, id_kategori) VALUES
                                                                                         ('Santal 33', 'Le Labo', 5000000, 5, 'Aroma kayu cendana, kulit, dan rempah maskulin.', 'https://images.unsplash.com/photo-1600180758890-6c8c96c5b0b0', 1),

                                                                                         ('Au Hasard', 'Louis Vuitton', 6200000, 1, 'Aroma kayu cendana, kulit, dan pir yang mewah.', 'https://images.unsplash.com/photo-1615634262419-d9a71b2f1e52', 1),

                                                                                         ('Baies', 'Diptyque', 1200000, 2, 'Aroma beri hitam dan mawar.', 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad', 4),

                                                                                         ('Libre', 'YSL', 2900000, 2, 'Aroma bunga dengan sentuhan vanilla.', 'https://images.unsplash.com/photo-1615634262419-d9a71b2f1e52', 1),

                                                                                         ('Allure Homme Sport', 'Chanel', 1720000, 2, 'Segar, maskulin, energik.', 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad', 2),

                                                                                         ('Iris Torréfié', 'Guerlain', 5800000, 1, 'Elegant, smoky, aristokrat.', 'https://images.unsplash.com/photo-1615634262419-d9a71b2f1e52', 5);

-- =========================
-- DATA PELANGGAN
-- =========================
INSERT INTO pelanggan (nama, email, no_hp) VALUES
                                               ('Daffa', 'daffa@mail.com', '08123456789'),
                                               ('Riyan', 'riyan@mail.com', '08234567890');

-- =========================
-- DATA USER LOGIN
-- =========================
-- Password admin: 12345678 (Sudah di-hash agar bisa login)
INSERT INTO users (username, email, password_hash, role) VALUES
    ('admin', 'admin@gmail.com', '$2y$10$8.UnS3U.5W.jO1VpP6S87.qA36VpE.Nf.f/jB7XG2fXmB/L3C/P6S', 'admin'),
    ('daffa', 'daffa@mail.com', '$2y$10$8.UnS3U.5W.jO1VpP6S87.qA36VpE.Nf.f/jB7XG2fXmB/L3C/P6S', 'customer');