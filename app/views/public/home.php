<!-- Hero Section (Responsive 2-Column on Desktop) -->
<section class="mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <!-- Left Column: Headline & Search -->
        <div class="lg:col-span-7 space-y-5">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/60 text-emerald-800 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Ekosistem Digital Masjid Nusantara</span>
            </div>

            <h1 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-5xl text-gray-900 tracking-tight leading-[1.15]">
                Temukan Ketenangan & <span class="text-emerald-600">Kegiatan Masjid</span> di Sekitar Anda
            </h1>

            <p class="text-sm sm:text-base text-gray-600 leading-relaxed max-w-xl">
                Jadwal shalat akurat terintegrasi GPS, peta GIS masjid terdekat dengan rute navigasi, agenda kajian terupdate, dan kemudahan infaq digital yang transparan.
            </p>

            <!-- Search Box -->
            <form action="<?= BASE_URL ?>/masjid" method="GET" class="bg-white p-2 rounded-2xl shadow-sm border border-gray-200/80 flex flex-col sm:flex-row gap-2 max-w-xl">
                <div class="flex-1 flex items-center px-3">
                    <svg class="w-5 h-5 text-gray-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" name="search" placeholder="Cari nama masjid atau lokasi..." class="w-full text-sm outline-none bg-transparent placeholder-gray-400">
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-2.5 px-6 rounded-xl transition shadow-sm">
                    Cari Masjid
                </button>
            </form>

            <!-- Quick Action Badges -->
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a href="<?= BASE_URL ?>/peta" class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold px-4 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    Buka Peta Interaktif
                </a>
                <a href="<?= BASE_URL ?>/donasi" class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-semibold px-4 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    Infaq & Sedekah
                </a>
            </div>
        </div>

        <!-- Right Column: Shalat Live Countdown Card -->
        <div class="lg:col-span-5">
            <?php include __DIR__ . '/../components/shalat-countdown.php'; ?>
        </div>
    </div>
</section>

<!-- Section: Masjid Terdekat & Unggulan -->
<section class="mb-12">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="font-heading font-bold text-2xl text-gray-900">Masjid Terdaftar</h2>
            <p class="text-sm text-gray-500 mt-1">Jelajahi profil lengkap, fasilitas, dan jadwal kajian masjid</p>
        </div>
        <a href="<?= BASE_URL ?>/masjid" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition">
            <span>Lihat Semua</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
        </a>
    </div>

    <!-- Responsive Grid: 1 col mobile, 2 col tablet, 4 col desktop -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php 
        $masjids = $data['masjid_terdekat'] ?? [];
        if (empty($masjids)): ?>
            <div class="col-span-full bg-white rounded-3xl p-10 text-center border border-gray-100 shadow-sm">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-800 text-lg mb-1">Belum Ada Masjid Terdaftar</h3>
                <p class="text-sm text-gray-500">Masjid yang didaftarkan oleh takmir akan muncul di sini.</p>
            </div>
        <?php else: ?>
            <?php foreach (array_slice($masjids, 0, 4) as $masjid): ?>
                <a href="<?= BASE_URL ?>/masjid/<?= $masjid['slug'] ?? $masjid['id'] ?>" class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="relative h-44 bg-gray-100 overflow-hidden">
                        <img src="<?= htmlspecialchars($masjid['foto_utama'] ?? BASE_URL.'/public/img/placeholder.svg') ?>" alt="<?= htmlspecialchars($masjid['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="text-xs font-semibold bg-white/90 backdrop-blur-md text-emerald-800 px-2.5 py-1 rounded-lg shadow-sm">
                                <?= htmlspecialchars($masjid['kota'] ?? 'Indonesia') ?>
                            </span>
                        </div>
                        <?php if (!empty($masjid['buka_24jam'])): ?>
                            <div class="absolute top-3 right-3">
                                <span class="text-[10px] font-bold bg-emerald-600 text-white px-2 py-0.5 rounded-full shadow-sm uppercase tracking-wider">
                                    24 Jam
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-heading font-bold text-gray-900 text-base group-hover:text-emerald-600 transition-colors line-clamp-1">
                                <?= htmlspecialchars($masjid['nama']) ?>
                            </h3>
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed">
                                <?= htmlspecialchars($masjid['alamat'] ?? 'Alamat masjid') ?>
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <?= number_format($masjid['kapasitas'] ?? 0) ?> Jamaah
                            </span>
                            <span class="font-semibold text-emerald-600 group-hover:translate-x-1 transition-transform">
                                Detail →
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Section: Agenda & Kajian Mendatang -->
<section class="mb-12">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="font-heading font-bold text-2xl text-gray-900">Agenda & Kajian Mendatang</h2>
            <p class="text-sm text-gray-500 mt-1">Ikuti kajian dan majelis ilmu yang diselenggarakan oleh takmir</p>
        </div>
        <a href="<?= BASE_URL ?>/kegiatan" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition">
            <span>Lihat Semua</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
        </a>
    </div>

    <!-- Responsive Grid: 1 col mobile, 2 col desktop -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php 
        $kegiatans = $data['upcoming_events'] ?? ($data['kegiatan'] ?? []);
        if (empty($kegiatans)): ?>
            <div class="col-span-full bg-white rounded-3xl p-8 text-center border border-gray-100 text-gray-500">
                Belum ada kegiatan mendatang.
            </div>
        <?php else: ?>
            <?php foreach (array_slice($kegiatans, 0, 4) as $keg): ?>
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row gap-5">
                    <div class="w-full sm:w-36 h-32 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                        <?php 
                            $kegPoster = !empty($keg['poster']) 
                                ? ((strpos($keg['poster'], 'http') === 0) ? $keg['poster'] : BASE_URL . '/public/uploads/kegiatan/' . $keg['poster']) 
                                : BASE_URL . '/public/img/placeholder.svg';
                        ?>
                        <img src="<?= htmlspecialchars($kegPoster) ?>" alt="Poster" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-[11px] font-semibold bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full">
                                    <?= htmlspecialchars($keg['masjid_nama'] ?? 'Masjid') ?>
                                </span>
                                <?php if (!empty($keg['perlu_daftar'])): ?>
                                    <span class="text-[10px] font-bold bg-amber-50 text-amber-700 px-2 py-0.5 rounded-full">
                                        Wajib Daftar
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h3 class="font-heading font-bold text-gray-900 text-base line-clamp-2">
                                <?= htmlspecialchars($keg['judul']) ?>
                            </h3>
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-1">
                                <?= htmlspecialchars($keg['deskripsi'] ?? '') ?>
                            </p>
                        </div>
                        <div class="pt-3 mt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-600">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                <?= date('d M Y', strtotime($keg['tanggal_mulai'])) ?> • <?= substr($keg['jam_mulai'], 0, 5) ?> WIB
                            </span>
                            <a href="<?= BASE_URL ?>/kegiatan/<?= $keg['id'] ?>" class="text-emerald-600 font-semibold hover:text-emerald-700">
                                Detail →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Section: Buletin & Artikel Islami -->
<?php if (!empty($data['recent_articles'])): ?>
<section class="mb-12">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="font-heading font-bold text-2xl text-gray-900">Buletin & Kabar Umat</h2>
            <p class="text-sm text-gray-500 mt-1">Artikel islami, panduan ibadah, dan berita transparansi masjid</p>
        </div>
        <a href="<?= BASE_URL ?>/artikel" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition">
            <span>Lihat Semua</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach (array_slice($data['recent_articles'], 0, 3) as $art): ?>
            <a href="<?= BASE_URL ?>/artikel/<?= $art['slug'] ?>" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                <div class="h-44 bg-gray-100 overflow-hidden">
                    <img src="<?= htmlspecialchars($art['gambar'] ?? BASE_URL.'/public/img/placeholder.svg') ?>" alt="Artikel" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-emerald-700 tracking-wider">
                            <?= htmlspecialchars($art['kategori'] ?? 'Buletin') ?>
                        </span>
                        <h3 class="font-heading font-bold text-gray-900 text-base mt-1.5 group-hover:text-emerald-600 transition line-clamp-2">
                            <?= htmlspecialchars($art['judul']) ?>
                        </h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                            <?= htmlspecialchars($art['konten'] ?? '') ?>
                        </p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                        <span><?= date('d F Y', strtotime($art['published_at'] ?? $art['created_at'])) ?></span>
                        <span class="text-emerald-600 font-semibold group-hover:translate-x-1 transition-transform">Baca →</span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Takmir Callout Banner -->
<section class="bg-gradient-to-r from-emerald-800 to-emerald-950 rounded-3xl p-8 sm:p-10 text-white relative overflow-hidden shadow-xl mb-6">
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative z-10 max-w-2xl">
        <span class="text-xs font-semibold bg-white/10 px-3 py-1 rounded-full text-emerald-200 uppercase tracking-wider">Khusus Pengurus Masjid</span>
        <h2 class="font-heading font-bold text-2xl sm:text-3xl text-white mt-3 mb-3">
            Daftarkan Masjid Anda ke Ekosistem Jejak Muslim
        </h2>
        <p class="text-sm text-emerald-100/90 leading-relaxed mb-6">
            Dapatkan akses penuh ke sistem pencatatan keuangan transparan, pengelolaan QRIS & donasi jamaah, inventaris aset, dan publikasi kegiatan secara mudah.
        </p>
        <div class="flex flex-wrap items-center gap-4">
            <a href="<?= BASE_URL ?>/auth/register" class="bg-white text-emerald-900 hover:bg-emerald-50 text-sm font-bold py-3 px-6 rounded-xl transition shadow">
                Daftarkan Masjid Sekarang
            </a>
            <a href="<?= BASE_URL ?>/auth/login" class="text-white hover:text-emerald-200 text-sm font-semibold underline underline-offset-4 transition">
                Sudah Punya Akun? Masuk
            </a>
        </div>
    </div>
</section>
