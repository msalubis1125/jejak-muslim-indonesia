CREATE DATABASE IF NOT EXISTS jmi_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE jmi_db;

CREATE TABLE masjid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    alamat TEXT,
    kelurahan VARCHAR(100),
    kecamatan VARCHAR(100),
    kota VARCHAR(100),
    provinsi VARCHAR(100),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    sejarah TEXT,
    visi_misi TEXT,
    kapasitas INT,
    foto_utama VARCHAR(255),
    no_hp_takmir VARCHAR(20),
    wa_link VARCHAR(255),
    status ENUM('pending','verified','suspended') DEFAULT 'pending',
    buka_24jam BOOLEAN DEFAULT 0,
    jeda_iqomah_menit INT DEFAULT 10,
    is_deleted BOOLEAN DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_status (status)
) ENGINE=InnoDB;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('super_admin','takmir','jamaah') NOT NULL,
    no_hp VARCHAR(20),
    masjid_id INT NULL,
    foto VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    login_attempts INT DEFAULT 0,
    locked_until DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE SET NULL,
    INDEX idx_email (email)
) ENGINE=InnoDB;

CREATE TABLE fasilitas_masjid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    nama_fasilitas VARCHAR(255) NOT NULL,
    tersedia BOOLEAN DEFAULT 1,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE galeri_masjid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    urutan INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE kas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    nama_kas VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    saldo DECIMAL(15,2) DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE kategori_keuangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    tipe ENUM('pemasukan','pengeluaran') NOT NULL,
    is_default BOOLEAN DEFAULT 0,
    masjid_id INT NULL,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE keuangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    kas_id INT NOT NULL,
    kategori_id INT NOT NULL,
    tipe ENUM('masuk','keluar') NOT NULL,
    nominal DECIMAL(15,2) NOT NULL,
    keterangan TEXT,
    tanggal DATE NOT NULL,
    created_by INT NULL,
    is_deleted BOOLEAN DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE,
    FOREIGN KEY (kas_id) REFERENCES kas(id) ON DELETE CASCADE,
    FOREIGN KEY (kategori_id) REFERENCES kategori_keuangan(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_tanggal (tanggal),
    INDEX idx_masjid_id (masjid_id)
) ENGINE=InnoDB;

CREATE TABLE kegiatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    lokasi_detail VARCHAR(255),
    poster VARCHAR(255),
    perlu_daftar BOOLEAN DEFAULT 0,
    kuota INT,
    status ENUM('upcoming','ongoing','done','cancelled') DEFAULT 'upcoming',
    is_deleted BOOLEAN DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_masjid_id (masjid_id)
) ENGINE=InnoDB;

CREATE TABLE pendaftaran_kegiatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kegiatan_id INT NOT NULL,
    user_id INT NULL,
    nama_peserta VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    status ENUM('registered','confirmed','cancelled') DEFAULT 'registered',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kegiatan_id) REFERENCES kegiatan(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE jadwal_petugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    tanggal DATE NOT NULL,
    tipe ENUM('harian','jumat') NOT NULL,
    imam VARCHAR(255),
    muadzin VARCHAR(255),
    khotib VARCHAR(255),
    catatan TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE,
    INDEX idx_tanggal (tanggal)
) ENGINE=InnoDB;

CREATE TABLE aset (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    kategori VARCHAR(100),
    jumlah INT DEFAULT 1,
    kondisi ENUM('baik','rusak_ringan','rusak_berat') DEFAULT 'baik',
    tanggal_perolehan DATE,
    keterangan TEXT,
    is_deleted BOOLEAN DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE rekening (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    nama_bank VARCHAR(100) NOT NULL,
    no_rekening VARCHAR(100) NOT NULL,
    atas_nama VARCHAR(255) NOT NULL,
    qris_path VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    masjid_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    konten TEXT NOT NULL,
    gambar VARCHAR(255),
    kategori ENUM('buletin','pengumuman','berita') NOT NULL,
    created_by INT NULL,
    is_published BOOLEAN DEFAULT 0,
    is_deleted BOOLEAN DEFAULT 0,
    published_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_masjid_id (masjid_id)
) ENGINE=InnoDB;

CREATE TABLE masjid_favorit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    masjid_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (masjid_id) REFERENCES masjid(id) ON DELETE CASCADE,
    UNIQUE(user_id, masjid_id)
) ENGINE=InnoDB;

CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    email VARCHAR(255) NOT NULL,
    success BOOLEAN NOT NULL,
    attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE csrf_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(64) NOT NULL,
    session_id VARCHAR(128) NOT NULL,
    expires_at DATETIME NOT NULL
) ENGINE=InnoDB;

-- SEED DATA
-- super_admin: admin@jmi.id / admin123
INSERT INTO users (nama, email, password_hash, role) VALUES 
('Super Administrator', 'admin@jmi.id', '$2y$10$/fXU6wZWMQ6.0Q3/5rp.oe2oZHf/39M9ZDA1.MKIidkG7RL2ex/kq', 'super_admin');

-- Kategori Keuangan
INSERT INTO kategori_keuangan (nama, tipe, is_default) VALUES
('Infaq Jumat', 'pemasukan', 1),
('Sedekah Umum', 'pemasukan', 1),
('Donasi Khusus', 'pemasukan', 1),
('Operasional', 'pengeluaran', 1),
('Pembangunan', 'pengeluaran', 1),
('Kegiatan', 'pengeluaran', 1);

CREATE TABLE IF NOT EXISTS pengaturan (
    `key` VARCHAR(100) PRIMARY KEY,
    `value` TEXT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO pengaturan (`key`, `value`) VALUES 
('qris_website_title', 'Infaq & Donasi Pengembangan Website'),
('qris_website_desc', 'Dukung keberlanjutan dan pemeliharaan platform digital Jejak Muslim Indonesia. Donasi Anda membantu pembiayaan server, integrasi peta GIS, dan digitalisasi masjid di seluruh pelosok Nusantara.'),
('qris_website_image', 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg'),
('qris_website_atas_nama', 'Jejak Muslim Indonesia'),
('qris_website_footer', 'Setiap rupiah donasi Anda menjadi amal jariyah untuk dakwah dan kemakmuran masjid digital di Indonesia.'),
('qris_website_is_active', '1');

