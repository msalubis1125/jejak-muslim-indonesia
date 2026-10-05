# Jejak Muslim Indonesia 🕌

Jejak Muslim Indonesia adalah platform portal masjid, sistem informasi keuangan, dan pemetaan GIS (Geographic Information System) untuk menemukan masjid terdekat di Indonesia.

## 🚀 Fitur Utama
- **Peta GIS Interaktif**: Pencarian masjid terdekat, arah navigasi, dan filter fasilitas.
- **Jadwal Shalat**: Waktu shalat akurat berdasarkan lokasi pengguna (Kemenag).
- **Portal Informasi**: Profil masjid, kegiatan, dan laporan keuangan transparan.
- **Donasi Online**: Integrasi dengan payment gateway / informasi rekening.
- **Admin Dashboard**: Manajemen data masjid, kegiatan, jamaah, dan keuangan.

## 🛠️ Tech Stack
- **Backend**: PHP 8+ Native (MVC Architecture)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, Tailwind CSS, Vanilla JS
- **Maps**: Leaflet.js & OpenStreetMap
- **Charts**: Chart.js

## 📦 Instalasi
1. Clone atau copy folder project ke dalam direktori server lokal Anda (misal: `xampp/htdocs/`).
2. Buat database baru di MySQL/phpMyAdmin (contoh: `jejak_muslim`).
3. Import file database schema yang ada di `database/schema.sql` (jika ada).
4. Sesuaikan konfigurasi database di `app/config/database.php`.
5. Buka terminal di folder project dan jalankan `npm install` (opsional jika ingin build CSS).
6. Akses aplikasi melalui browser di `http://localhost/jejak-muslim-indonesia`.

### Akun Default Admin
- **Email**: admin@jmi.id
- **Password**: admin123

## 📁 Struktur Direktori
- `app/` - Core PHP MVC (Controllers, Models, Views, Config)
- `public/` - Asset publik (CSS, JS, Images, Uploads)
  - `css/` - Styling & Tailwind output
  - `js/` - Frontend logic
  - `img/` - Gambar statis & SVG
- `database/` - File SQL / Migration

## 📄 Lisensi
MIT License
