<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="font-['Poppins'] font-bold text-xl text-gray-800">Pengaturan QRIS Donasi Website</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi rekening dan QRIS donasi khusus untuk operasional & pengembangan platform Jejak Muslim Indonesia.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASE_URL ?>/donasi" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-sm font-semibold hover:bg-emerald-100 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Lihat Halaman Publik</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: Form Settings -->
    <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="<?= BASE_URL ?>/admin/superadmin/qris/update" method="POST" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

            <!-- Status Aktif Toggle -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200/80">
                <div>
                    <label for="is_active" class="font-semibold text-gray-800 text-sm cursor-pointer">Tampilkan QRIS di Halaman Donasi</label>
                    <p class="text-xs text-gray-500 mt-0.5">Jika dinonaktifkan, kartu QRIS donasi website tidak akan muncul di portal publik.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" <?= !empty($qris['is_active']) ? 'checked' : '' ?> class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- Judul Donasi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Judul Donasi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" required value="<?= htmlspecialchars($qris['title'] ?? '') ?>" placeholder="Contoh: Infaq & Donasi Pengembangan Website" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
            </div>

            <!-- Merchant / Atas Nama -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Atas Nama / Nama Merchant QRIS <span class="text-red-500">*</span>
                </label>
                <input type="text" name="atas_nama" required value="<?= htmlspecialchars($qris['atas_nama'] ?? '') ?>" placeholder="Contoh: Jejak Muslim Indonesia / Yayasan Jejak Muslim" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
            </div>

            <!-- Keterangan / Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Deskripsi & Ajakan Donasi <span class="text-red-500">*</span>
                </label>
                <textarea name="desc" rows="3" required placeholder="Tuliskan tujuan donasi website..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition"><?= htmlspecialchars($qris['desc'] ?? '') ?></textarea>
            </div>

            <!-- Catatan Kaki / Footer -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Catatan Kaki (Footer Note)
                </label>
                <input type="text" name="footer" value="<?= htmlspecialchars($qris['footer'] ?? '') ?>" placeholder="Contoh: Setiap infaq Anda menjadi amal jariyah untuk kemakmuran masjid digital." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
            </div>

            <!-- Upload File QRIS -->
            <div class="pt-3 border-t border-gray-100">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                    Unggah Gambar Kode QRIS (JPG, PNG, WEBP)
                </label>
                <input type="file" name="qris_file" accept=".jpg,.jpeg,.png,.webp" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer bg-gray-50 border border-gray-200 rounded-xl p-1.5">
                <p class="text-xs text-gray-400 mt-1">Ukuran maksimal file: 3 MB. Disarankan rasio kotak (1:1) dengan resolusi tinggi.</p>
            </div>

            <!-- Alternatif URL Gambar -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                    Atau Masukkan URL Gambar QRIS Eksternal
                </label>
                <input type="text" name="image_url" value="<?= (str_starts_with($qris['raw_image'] ?? '', 'http')) ? htmlspecialchars($qris['raw_image']) : '' ?>" placeholder="https://domain.com/qris.png (Opsional jika tidak mengunggah file)" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Right Column: Live Card Preview -->
    <div class="lg:col-span-5 space-y-4">
        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200/80">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider">Pratinjau Tampilan di Halaman Donasi</h3>
            </div>

            <!-- Card Preview Simulated -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-md text-center">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200/60 text-emerald-800 text-[11px] font-semibold mb-2">
                    <span>Donasi Platform</span>
                </div>

                <h3 class="font-heading font-bold text-base text-gray-900 mb-1.5 leading-snug">
                    <?= htmlspecialchars($qris['title'] ?? 'Infaq & Donasi Pengembangan Website') ?>
                </h3>

                <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                    <?= htmlspecialchars($qris['desc'] ?? '') ?>
                </p>

                <div class="inline-block p-3 bg-gray-50 border border-gray-200 rounded-2xl shadow-inner mb-3">
                    <img src="<?= htmlspecialchars($qris['image']) ?>" alt="QRIS Preview" class="w-44 h-44 object-contain mx-auto">
                </div>

                <div class="text-xs font-semibold text-gray-800 mb-1">
                    a.n <?= htmlspecialchars($qris['atas_nama'] ?? 'Jejak Muslim Indonesia') ?>
                </div>

                <p class="text-[10px] text-gray-400 leading-normal mt-2 border-t border-gray-100 pt-2">
                    <?= htmlspecialchars($qris['footer'] ?? '') ?>
                </p>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200/70 rounded-2xl p-4 text-xs text-blue-800 flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <span class="font-bold block mb-0.5">Informasi Transparansi Dana</span>
                <span>QRIS ini ditujukan khusus untuk mendanai pemeliharaan server cloud, lisensi database, dan operasional tim relawan pengembang Jejak Muslim Indonesia.</span>
            </div>
        </div>
    </div>
</div>
