<?php
$extraCss = '
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
';
$extraJs = '
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="' . BASE_URL . '/public/js/geocoding.js"></script>
';
$m = $masjid ?? [];
?>

<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h1 class="font-heading font-bold text-2xl text-gray-800">Profil Masjid</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi publik, lokasi peta GIS, dan fasilitas masjid Anda</p>
        </div>
        <div class="flex items-center gap-3">
            <?php if (!empty($m['slug'])): ?>
                <a href="<?= BASE_URL ?>/masjid/detail/<?= htmlspecialchars($m['slug']) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-emerald-600 text-emerald-700 hover:bg-emerald-50 text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    Lihat Halaman Publik
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Form -->
    <form action="<?= BASE_URL ?>/admin/masjid/save" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-8">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
        <?php if (!empty($m['id'])): ?>
            <input type="hidden" name="masjid_id" value="<?= htmlspecialchars($m['id']) ?>">
        <?php endif; ?>

        <!-- Informasi Utama -->
        <div>
            <h2 class="font-heading font-semibold text-lg text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <span class="w-2 h-6 bg-emerald-600 rounded-full"></span>
                Informasi Utama
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Masjid <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required value="<?= htmlspecialchars($m['nama'] ?? '') ?>" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kota / Kabupaten <span class="text-rose-500">*</span></label>
                    <input type="text" name="kota" required value="<?= htmlspecialchars($m['kota'] ?? '') ?>" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi <span class="text-rose-500">*</span></label>
                    <input type="text" name="provinsi" required value="<?= htmlspecialchars($m['provinsi'] ?? '') ?>" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition"><?= htmlspecialchars($m['alamat'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Jamaah (Orang)</label>
                    <input type="number" name="kapasitas" value="<?= htmlspecialchars($m['kapasitas'] ?? '') ?>" placeholder="Contoh: 1500" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jeda Iqomah (Menit)</label>
                    <input type="number" name="jeda_iqomah_menit" value="<?= htmlspecialchars($m['jeda_iqomah_menit'] ?? '10') ?>" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-sm transition">
                </div>
            </div>
        </div>

        <!-- Pemetaan GIS & Koordinat -->
        <div>
            <h2 class="font-heading font-semibold text-lg text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <span class="w-2 h-6 bg-emerald-600 rounded-full"></span>
                Titik Koordinat GIS (Leaflet Map)
            </h2>
            <p class="text-xs text-gray-500 mt-2">Cari nama lokasi atau seret (drag) pin hijau pada peta untuk menentukan koordinat presisi masjid Anda.</p>
            
            <!-- Pencarian Alamat Nominatim -->
            <div class="mt-4 flex gap-2">
                <div class="relative flex-1">
                    <input type="text" id="search-location" placeholder="Ketik nama jalan atau lokasi lalu klik Cari..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="button" id="btn-search-location" class="px-5 py-2.5 bg-gray-800 hover:bg-black text-white text-sm font-medium rounded-xl transition">
                    Cari Lokasi
                </button>
            </div>

            <!-- Leaflet Container -->
            <div id="geocoding-map" class="h-80 w-full rounded-2xl border border-gray-200 mt-4 shadow-sm z-10"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">Latitude</label>
                    <input type="text" id="latitude" name="latitude" value="<?= htmlspecialchars($m['latitude'] ?? '-6.200000') ?>" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-mono text-gray-700 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">Longitude</label>
                    <input type="text" id="longitude" name="longitude" value="<?= htmlspecialchars($m['longitude'] ?? '106.816666') ?>" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-mono text-gray-700 cursor-not-allowed">
                </div>
            </div>
        </div>

        <!-- Kontak & Media Sosial Takmir -->
        <div>
            <h2 class="font-heading font-semibold text-lg text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <span class="w-2 h-6 bg-emerald-600 rounded-full"></span>
                Kontak Takmir
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP / WhatsApp Takmir</label>
                    <input type="text" name="no_hp_takmir" value="<?= htmlspecialchars($m['no_hp_takmir'] ?? '') ?>" placeholder="Contoh: 08123456789" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tautan WhatsApp Langsung (Link)</label>
                    <input type="text" name="wa_link" value="<?= htmlspecialchars($m['wa_link'] ?? '') ?>" placeholder="https://wa.me/628123456789" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm transition">
                </div>
            </div>
        </div>

        <!-- Fasilitas Masjid -->
        <div>
            <h2 class="font-heading font-semibold text-lg text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <span class="w-2 h-6 bg-emerald-600 rounded-full"></span>
                Fasilitas Masjid
            </h2>
            <p class="text-xs text-gray-500 mt-2 mb-4">Centang fasilitas yang tersedia di masjid Anda agar jamaah mudah mencari masjid ramah disabilitas, musafir, dsb.</p>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                <?php 
                $activeFasilitas = $masjid_fasilitas ?? [];
                $defaultFasilitas = [
                    'Area Parkir Luas', 'Pendingin Ruangan (AC)', 'Ramah Disabilitas / Kursi Roda',
                    'Tempat Wudhu Nyaman', 'Toilet Bersih', 'Ruang Laktasi / Ibu Menyusui',
                    'Kantin / Koperasi Syariah', 'Ambulans Gratis', 'Perpustakaan Islam',
                    'Wi-Fi Gratis', 'Asrama / Penginapan Musafir'
                ];
                $listFas = !empty($fasilitas_list) ? $fasilitas_list : $defaultFasilitas;
                foreach ($listFas as $fas):
                    $namaFas = is_array($fas) ? ($fas['nama_fasilitas'] ?? $fas['nama'] ?? '') : (is_object($fas) ? ($fas->nama_fasilitas ?? $fas->nama ?? '') : $fas);
                    $isChecked = in_array($namaFas, $activeFasilitas);
                ?>
                    <label class="flex items-center gap-2.5 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer text-sm select-none transition">
                        <input type="checkbox" name="fasilitas[]" value="<?= htmlspecialchars($namaFas) ?>" <?= $isChecked ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500 border-gray-300">
                        <span class="text-gray-700"><?= htmlspecialchars($namaFas) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <div class="mt-4">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="buka_24jam" value="1" <?= !empty($m['buka_24jam']) ? 'checked' : '' ?> class="w-5 h-5 text-emerald-600 rounded focus:ring-emerald-500 border-gray-300">
                    <span class="text-sm font-semibold text-gray-800">Masjid Terbuka 24 Jam untuk Musafir & Jamaah</span>
                </label>
            </div>
        </div>

        <!-- Sejarah, Visi & Foto -->
        <div>
            <h2 class="font-heading font-semibold text-lg text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <span class="w-2 h-6 bg-emerald-600 rounded-full"></span>
                Sejarah, Profil & Foto Utama
            </h2>
            <div class="space-y-4 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sejarah Singkat Masjid</label>
                    <textarea name="sejarah" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm transition" placeholder="Ceritakan sejarah pendirian, arsitektur, atau latar belakang masjid..."><?= htmlspecialchars($m['sejarah'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Visi & Misi Masjid</label>
                    <textarea name="visi_misi" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm transition" placeholder="Visi dan program pemakmuran masjid..."><?= htmlspecialchars($m['visi_misi'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Utama Masjid</label>
                    <?php if (!empty($m['foto_utama'])): ?>
                        <div class="mb-3">
                            <img src="<?= (strpos($m['foto_utama'], 'http') === 0) ? $m['foto_utama'] : BASE_URL . '/public/uploads/masjid/' . $m['foto_utama'] ?>" alt="Foto Masjid" class="w-48 h-32 object-cover rounded-xl border border-gray-200 shadow-sm">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="foto_utama" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG maksimal 2MB</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
            <a href="<?= BASE_URL ?>/admin/dashboard" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl shadow-sm hover:shadow transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

