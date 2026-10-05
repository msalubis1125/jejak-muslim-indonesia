<div class="py-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading font-bold text-2xl sm:text-3xl text-gray-900">Direktori Masjid</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar masjid terverifikasi dengan informasi fasilitas, kajian, dan rekening infaq.</p>
        </div>
        <a href="<?= BASE_URL ?>/peta" class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition self-start">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
            Buka di Peta GIS
        </a>
    </div>

    <!-- Search Form -->
    <form action="<?= BASE_URL ?>/masjid" method="GET" class="relative mb-5 max-w-2xl">
        <input type="text" name="search" value="<?= htmlspecialchars($data['search'] ?? ($search ?? '')) ?>" placeholder="Cari nama atau lokasi masjid..." class="w-full pl-11 pr-24 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm text-gray-800 shadow-sm transition">
        <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <button type="submit" class="absolute right-2 top-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold py-1.5 px-4 rounded-xl transition">
            Cari
        </button>
    </form>

    <!-- Filter Chips Kota -->
    <?php 
    $activeKota = $data['kota'] ?? ($kota ?? '');
    ?>
    <div class="flex overflow-x-auto gap-2 mb-8 pb-2 hide-scrollbar">
        <a href="<?= BASE_URL ?>/masjid" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= empty($activeKota) ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Semua Wilayah
        </a>
        <a href="<?= BASE_URL ?>/masjid?kota=Jakarta Pusat" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= $activeKota === 'Jakarta Pusat' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Jakarta Pusat
        </a>
        <a href="<?= BASE_URL ?>/masjid?kota=Jakarta Selatan" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= $activeKota === 'Jakarta Selatan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Jakarta Selatan
        </a>
        <a href="<?= BASE_URL ?>/masjid?kota=Banda Aceh" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= $activeKota === 'Banda Aceh' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Banda Aceh
        </a>
    </div>

    <!-- Mosque Grid: 1 col mobile, 2 col tablet, 3 col desktop -->
    <?php 
    $masjids = $data['masjid_list'] ?? ($data['masjids'] ?? ($masjid_list ?? []));
    if (empty($masjids)): ?>
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-md mx-auto">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            </div>
            <h3 class="font-heading font-semibold text-gray-800 text-lg mb-1">Tidak Ada Masjid Ditemukan</h3>
            <p class="text-sm text-gray-500 mb-6">Coba gunakan kata kunci pencarian yang lain atau pilih wilayah yang berbeda.</p>
            <a href="<?= BASE_URL ?>/masjid" class="inline-block bg-emerald-600 text-white text-sm font-semibold py-2.5 px-6 rounded-xl">
                Reset Pencarian
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($masjids as $masjid): 
                $isList = false;
                include __DIR__ . '/../components/card-masjid.php'; 
            endforeach; ?>
        </div>
    <?php endif; ?>
</div>
