-- Sample Seed Data for Jejak Muslim Indonesia
USE jmi_db;

-- 1. Insert Sample Masjids
INSERT INTO masjid (id, nama, slug, alamat, kelurahan, kecamatan, kota, provinsi, latitude, longitude, sejarah, visi_misi, kapasitas, foto_utama, no_hp_takmir, wa_link, status, buka_24jam, jeda_iqomah_menit, is_deleted) VALUES
(1, 'Masjid Istiqlal', 'masjid-istiqlal', 'Jl. Taman Wijaya Kusuma, Ps. Baru', 'Pasar Baru', 'Sawah Besar', 'Jakarta Pusat', 'DKI Jakarta', -6.17017000, 106.83152000, 'Masjid Istiqlal adalah masjid terbesar di Asia Tenggara yang diprakarsai oleh Presiden Ir. Soekarno pada tahun 1951.', 'Menjadi pusat peradaban Islam yang moderat, toleran, dan memberdayakan umat.', 200000, 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=800&q=80', '081234567890', 'https://wa.me/6281234567890', 'verified', 1, 15, 0),

(2, 'Masjid Agung Al-Azhar', 'masjid-agung-al-azhar', 'Jl. Sisingamangaraja No.1, Selong', 'Selong', 'Kebayoran Baru', 'Jakarta Selatan', 'DKI Jakarta', -6.23524000, 106.79921000, 'Didirikan pada tahun 1953 oleh tokoh-tokoh Masyumi termasuk Buya Hamka yang menjadi imam besar pertamanya.', 'Membina generasi muslim yang berakhlak mulia, cerdas, dan mandiri.', 12000, 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80', '081298765432', 'https://wa.me/6281298765432', 'verified', 0, 10, 0),

(3, 'Masjid Sunda Kelapa', 'masjid-sunda-kelapa', 'Jl. Taman Sunda Kelapa No.16, Menteng', 'Menteng', 'Menteng', 'Jakarta Pusat', 'DKI Jakarta', -6.19942000, 106.83294000, 'Masjid tanpa kubah dengan arsitektur berbentuk perahu melambangkan pelabuhan bersejarah Sunda Kelapa.', 'Pemberdayaan ekonomi dan pendidikan umat berbasis masjid.', 4500, 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=800&q=80', '081311223344', 'https://wa.me/6281311223344', 'verified', 1, 10, 0),

(4, 'Masjid Raya Baiturrahman', 'masjid-raya-baiturrahman', 'Jl. Moh. Jam No.1, Kp. Baru', 'Kampung Baru', 'Baiturrahman', 'Banda Aceh', 'Aceh', 5.55364000, 95.31731000, 'Masjid bersejarah Kesultanan Aceh yang selamat dari gempa dan tsunami besar tahun 2004.', 'Pusat syiar Islam di Serambi Mekkah.', 30000, 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?auto=format&fit=crop&w=800&q=80', '081255667788', 'https://wa.me/6281255667788', 'verified', 1, 15, 0)
ON DUPLICATE KEY UPDATE nama=VALUES(nama);

-- 2. Insert Fasilitas Masjid
DELETE FROM fasilitas_masjid WHERE masjid_id IN (1,2,3,4);
INSERT INTO fasilitas_masjid (masjid_id, nama_fasilitas, tersedia) VALUES
(1, 'Parkir Luas', 1), (1, 'Ruang AC', 1), (1, 'Ramah Difabel', 1), (1, 'Perpustakaan', 1), (1, 'Klinik Kesehatan', 1), (1, 'Wi-Fi Gratis', 1),
(2, 'Parkir Luas', 1), (2, 'Ruang AC', 1), (2, 'Ramah Difabel', 1), (2, 'Perpustakaan', 1), (2, 'Aula Serbaguna', 1),
(3, 'Parkir Luas', 1), (3, 'Ruang AC', 1), (3, 'Bazar UMKM', 1), (3, 'Koperasi Syariah', 1),
(4, 'Payung Elektrik', 1), (4, 'Parkir Luas', 1), (4, 'Taman Air Mancur', 1), (4, 'Perpustakaan Digital', 1);

-- 3. Insert Kas & Keuangan
DELETE FROM kas WHERE masjid_id IN (1,2,3,4);
INSERT INTO kas (id, masjid_id, nama_kas, deskripsi, saldo, is_active) VALUES
(1, 1, 'Kas Operasional Istiqlal', 'Untuk listrik, kebersihan, dan pemeliharaan', 145000000.00, 1),
(2, 1, 'Kas Anak Yatim & Dhuafa', 'Penyaluran santunan rutin bulanan', 85000000.00, 1),
(3, 2, 'Kas Umum Al-Azhar', 'Kas operasional harian masjid', 56250000.00, 1),
(4, 3, 'Kas Pembangunan Sunda Kelapa', 'Renovasi area wudhu dan perluasan sound system', 34700000.00, 1);

-- 4. Insert Rekening & QRIS
DELETE FROM rekening WHERE masjid_id IN (1,2,3,4);
INSERT INTO rekening (id, masjid_id, nama_bank, no_rekening, atas_nama, qris_path, is_active) VALUES
(1, 1, 'Bank Syariah Indonesia (BSI)', '7001234567', 'Badan Pengelola Masjid Istiqlal', 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg', 1),
(2, 1, 'Bank Mandiri', '1230009876543', 'BPMI Infaq dan Sedekah', NULL, 1),
(3, 2, 'Bank Syariah Indonesia (BSI)', '7112233445', 'YPI Al-Azhar Jakarta', 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg', 1),
(4, 3, 'Bank BCA Syariah', '0088997766', 'Masjid Sunda Kelapa Infaq', 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg', 1);

-- 5. Insert Upcoming Events / Kegiatan
DELETE FROM kegiatan WHERE masjid_id IN (1,2,3,4);
INSERT INTO kegiatan (id, masjid_id, judul, deskripsi, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, lokasi_detail, poster, perlu_daftar, kuota, status, is_deleted) VALUES
(1, 1, 'Tabligh Akbar: Merawat Ukhuwah di Era Digital', 'Kajian akbar bersama ulama nasional membahas pentingnya persatuan umat dan etika bermedia sosial.', CURDATE() + INTERVAL 1 DAY, CURDATE() + INTERVAL 1 DAY, '19:30:00', '21:30:00', 'Ruang Utama Shalat Masjid Istiqlal', 'https://images.unsplash.com/photo-1585036156171-384164a8c675?auto=format&fit=crop&w=600&q=80', 1, 500, 'upcoming', 0),

(2, 2, 'Kajian Shubuh Berjamaah & Bedah Tafsir Jalalain', 'Kajian rutin ba\'da Shubuh bersama Buya membahas ayat-ayat tazkiyatun nafs.', CURDATE() + INTERVAL 2 DAY, CURDATE() + INTERVAL 2 DAY, '04:45:00', '06:30:00', 'Aula Buya Hamka Lantai 2', 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80', 0, 0, 'upcoming', 0),

(3, 3, 'Pelatihan Manajemen Keuangan Masjid Berbasis IT', 'Workshop interaktif untuk takmir masjid se-Jabodetabek tentang pembukuan kas digital dan pelaporan transparan.', CURDATE() + INTERVAL 4 DAY, CURDATE() + INTERVAL 4 DAY, '08:30:00', '15:00:00', 'Gedung Pertemuan Sunda Kelapa', 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=600&q=80', 1, 100, 'upcoming', 0),

(4, 1, 'Iktikaf 10 Malam Terakhir & Qiyamul Lail', 'Program iktikaf terpadu dilengkapi sahur bersama dan kajian tadabbur Al-Qur\'an.', CURDATE() + INTERVAL 7 DAY, CURDATE() + INTERVAL 10 DAY, '23:00:00', '04:00:00', 'Area Iktikaf Lantai Dasar Istiqlal', 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=600&q=80', 1, 1000, 'upcoming', 0);

-- 6. Insert Artikel & Buletin
DELETE FROM artikel WHERE masjid_id IN (1,2,3,4);
INSERT INTO artikel (id, masjid_id, judul, slug, konten, gambar, kategori, is_published, is_deleted, published_at) VALUES
(1, 1, 'Memakmurkan Masjid: Dari Tempat Ibadah Menuju Pusat Peradaban', 'memakmurkan-masjid-pusat-peradaban', 'Masjid pada zaman Rasulullah SAW bukan hanya tempat sujud, namun juga balai musyawarah, pusat logistik, pengadilan, dan pendidikan umat. Di era digital saat ini, revitalisasi fungsi masjid menjadi semakin penting untuk menjawab tantangan zaman melalui integrasi teknologi informasi.', 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=800&q=80', 'buletin', 1, 0, NOW() - INTERVAL 1 DAY),

(2, 2, 'Adab dan Keutamaan Berjalan Menuju Rumah Allah', 'adab-keutamaan-berjalan-menuju-masjid', 'Setiap langkah seorang muslim menuju masjid untuk menunaikan shalat berjamaah akan menghapus dosa dan meninggikan derajatnya di sisi Allah SWT. Artikel ini mengulas sunnah-sunnah Rasulullah SAW ketika berangkat ke masjid.', 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=800&q=80', 'berita', 1, 0, NOW() - INTERVAL 2 DAY),

(3, 3, 'Transparansi Infaq Jumat: Membangun Kepercayaan Jamaah', 'transparansi-infaq-jumat', 'Kepercayaan jamaah adalah aset terbesar pengurus masjid. Dengan mempublikasikan laporan kas pemasukan dan pengeluaran secara digital, umat dapat melihat secara nyata bagaimana setiap rupiah infaq mereka berbuah manfaat bagi masyarakat.', 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=800&q=80', 'pengumuman', 1, 0, NOW() - INTERVAL 3 DAY);

-- 7. Insert/Update Users (Super Admin & Takmir)
-- Password for admin: admin123
-- Password for takmir: takmir123
INSERT INTO users (id, nama, email, password_hash, role, masjid_id, is_active) VALUES
(1, 'Super Administrator', 'admin@jmi.id', '$2y$10$/fXU6wZWMQ6.0Q3/5rp.oe2oZHf/39M9ZDA1.MKIidkG7RL2ex/kq', 'super_admin', NULL, 1),
(2, 'H. Ahmad Syarif (Takmir Istiqlal)', 'takmir.istiqlal@jmi.id', '$2y$10$77QQJUFgo3.y50A/V.RLSewxxmf0ecLX8B.yzvGp.TJ3bzC26xVoW', 'takmir', 1, 1),
(3, 'Ust. Ridwan Fauzi (Takmir Al-Azhar)', 'takmir.alazhar@jmi.id', '$2y$10$77QQJUFgo3.y50A/V.RLSewxxmf0ecLX8B.yzvGp.TJ3bzC26xVoW', 'takmir', 2, 1),
(4, 'Drs. H. Mulyadi (Takmir Sunda Kelapa)', 'takmir.sundakelapa@jmi.id', '$2y$10$77QQJUFgo3.y50A/V.RLSewxxmf0ecLX8B.yzvGp.TJ3bzC26xVoW', 'takmir', 3, 1),
(5, 'Teuku Muhammad (Takmir Baiturrahman)', 'takmir.baiturrahman@jmi.id', '$2y$10$77QQJUFgo3.y50A/V.RLSewxxmf0ecLX8B.yzvGp.TJ3bzC26xVoW', 'takmir', 4, 1)
ON DUPLICATE KEY UPDATE nama=VALUES(nama), role=VALUES(role), masjid_id=VALUES(masjid_id);

