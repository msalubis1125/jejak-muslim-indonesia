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
2. Buat database baru di MySQL/phpMyAdmin (contoh: `jmi_db`).
3. Import file skema database dari `database/schema.sql` dan data awal `database/seed_sample_data.sql`.
4. Salin file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi database dan `APP_ENV`.
5. Akses aplikasi melalui browser di `http://localhost/jejak-muslim-indonesia` atau domain root hosting.

### ⚠️ Akun Awal & Keamanan
- **Email Default**: `admin@jmi.id`
- **Password Default**: `admin123`
> **PENTING**: Segera ubah password akun Super Administrator setelah instalasi awal pertama kali demi keamanan sistem. Pastikan file `.env` tidak pernah dipublikasikan ke publik.

## 📁 Struktur Direktori
- `app/` - Core PHP MVC (Controllers, Models, Views, Config)
- `public/` - Asset publik (CSS, JS, Images, Uploads)
  - `css/` - Styling & Tailwind output
  - `js/` - Frontend logic
  - `img/` - Gambar statis & SVG
- `database/` - File SQL / Migration

## 📄 Lisensi
MIT License
