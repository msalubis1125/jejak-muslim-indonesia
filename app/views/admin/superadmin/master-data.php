<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="font-['Poppins'] font-bold text-xl text-gray-800">Master Data Kategori Keuangan</h2>
        <p class="text-sm text-gray-500 mt-1">Standarisasi kategori pos pemasukan dan pengeluaran kas masjid nasional.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Pemasukan -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <h3 class="font-bold text-gray-800">Kategori Pemasukan</h3>
                </div>
                <span class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full font-medium border border-emerald-200">
                    Pos Penerimaan
                </span>
            </div>
            
            <ul class="space-y-2 mb-6 max-h-80 overflow-y-auto pr-1">
                <?php 
                $pemasukanList = array_filter($kategori_list ?? [], function($k) {
                    return ($k['tipe'] ?? '') === 'pemasukan' || ($k['tipe'] ?? '') === 'masuk';
                });
                if (empty($pemasukanList)): ?>
                    <li class="p-3 text-center text-xs text-gray-400 bg-gray-50 rounded-xl">Belum ada kategori pemasukan.</li>
                <?php else: ?>
                    <?php foreach ($pemasukanList as $kat): ?>
                        <li class="flex justify-between items-center bg-gray-50/80 hover:bg-gray-100/80 p-3 rounded-xl text-sm text-gray-700 transition">
                            <span class="font-medium"><?= htmlspecialchars($kat['nama'] ?? $kat['nama_kategori'] ?? '') ?></span>
                            <form action="<?= BASE_URL ?>/admin/superadmin/masterdata/deleteKategori/<?= $kat['id'] ?>" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <form action="<?= BASE_URL ?>/admin/superadmin/masterdata/storeKategori" method="POST" class="border-t border-gray-100 pt-4">
            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
            <input type="hidden" name="tipe_default" value="pemasukan">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tambah Pos Pemasukan Baru</label>
            <div class="flex gap-2">
                <input type="text" name="nama_kategori" required placeholder="Contoh: Kotak Amal Subuh" class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">Tambah</button>
            </div>
        </form>
    </div>

    <!-- Pengeluaran -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <h3 class="font-bold text-gray-800">Kategori Pengeluaran</h3>
                </div>
                <span class="text-xs bg-red-50 text-red-700 px-2.5 py-0.5 rounded-full font-medium border border-red-200">
                    Pos Belanja
                </span>
            </div>
            
            <ul class="space-y-2 mb-6 max-h-80 overflow-y-auto pr-1">
                <?php 
                $pengeluaranList = array_filter($kategori_list ?? [], function($k) {
                    return ($k['tipe'] ?? '') === 'pengeluaran' || ($k['tipe'] ?? '') === 'keluar';
                });
                if (empty($pengeluaranList)): ?>
                    <li class="p-3 text-center text-xs text-gray-400 bg-gray-50 rounded-xl">Belum ada kategori pengeluaran.</li>
                <?php else: ?>
                    <?php foreach ($pengeluaranList as $kat): ?>
                        <li class="flex justify-between items-center bg-gray-50/80 hover:bg-gray-100/80 p-3 rounded-xl text-sm text-gray-700 transition">
                            <span class="font-medium"><?= htmlspecialchars($kat['nama'] ?? $kat['nama_kategori'] ?? '') ?></span>
                            <form action="<?= BASE_URL ?>/admin/superadmin/masterdata/deleteKategori/<?= $kat['id'] ?>" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <form action="<?= BASE_URL ?>/admin/superadmin/masterdata/storeKategori" method="POST" class="border-t border-gray-100 pt-4">
            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
            <input type="hidden" name="tipe_default" value="pengeluaran">
            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tambah Pos Pengeluaran Baru</label>
            <div class="flex gap-2">
                <input type="text" name="nama_kategori" required placeholder="Contoh: Honorarium Penceramah" class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">Tambah</button>
            </div>
        </form>
    </div>
</div>
