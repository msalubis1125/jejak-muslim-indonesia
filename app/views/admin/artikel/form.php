<?php
$isEdit = !empty($artikel);
$art = $artikel ?? [];
?>

<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-['Poppins'] font-bold text-gray-800">
                <?= $isEdit ? 'Edit Artikel' : 'Tulis Artikel & Buletin Baru' ?>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                <?= $isEdit ? 'Perbarui informasi dan konten artikel masjid.' : 'Bagikan informasi pengumuman, kajian, atau buletin dakwah digital.' ?>
            </p>
        </div>
        <a href="<?= BASE_URL ?>/admin/artikelmgmt" class="text-xs sm:text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 px-3.5 py-2 rounded-xl transition">
            ← Kembali
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/artikelmgmt/<?= $isEdit ? 'update/' . $art['id'] : 'store' ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

        <!-- Judul -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Judul Artikel <span class="text-red-500">*</span></label>
            <input type="text" name="judul" required value="<?= htmlspecialchars($art['judul'] ?? '') ?>" placeholder="Masukkan judul artikel yang informatif..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Kategori -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                    <?php
                    $kategoris = ['kajian' => 'Kajian & Tausiyah', 'buletin' => 'Buletin Dakwah', 'berita' => 'Berita Masjid', 'pengumuman' => 'Pengumuman Resmi'];
                    $selected = $art['kategori'] ?? 'kajian';
                    foreach ($kategoris as $kVal => $kLabel):
                    ?>
                        <option value="<?= $kVal ?>" <?= $selected === $kVal ? 'selected' : '' ?>><?= $kLabel ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status Publikasi -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Status Publikasi</label>
                <div class="flex items-center h-10">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" <?= (!empty($art['is_published']) || !$isEdit) ? 'checked' : '' ?>>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ml-3 text-xs sm:text-sm font-medium text-gray-700">Terbitkan langsung ke publik</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Cover Image -->
        <div class="pt-2 border-t border-gray-100">
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Gambar Sampul / Cover (JPG, PNG, WEBP)</label>
            <?php if (!empty($art['gambar'])): ?>
                <div class="mb-3 flex items-center gap-3">
                    <?php
                    $imgSrc = (strpos($art['gambar'], 'http') === 0) ? $art['gambar'] : BASE_URL . '/' . ltrim($art['gambar'], '/');
                    ?>
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Cover Saat Ini" class="w-24 h-16 object-cover rounded-xl border border-gray-200">
                    <span class="text-xs text-gray-500">Gambar saat ini terpasang. Unggah baru untuk mengganti.</span>
                </div>
            <?php endif; ?>
            <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer bg-gray-50 border border-gray-200 rounded-xl p-1.5">
            <p class="text-[11px] text-gray-400 mt-1">Atau masukkan URL gambar eksternal (Unsplash, dll):</p>
            <input type="text" name="gambar_url" value="<?= (str_starts_with($art['gambar'] ?? '', 'http')) ? htmlspecialchars($art['gambar']) : '' ?>" placeholder="https://images.unsplash.com/..." class="mt-1.5 w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
        </div>

        <!-- Konten -->
        <div class="pt-2 border-t border-gray-100">
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Isi Konten Artikel <span class="text-red-500">*</span></label>
            <textarea name="konten" rows="12" required placeholder="Tuliskan isi artikel, pengumuman, atau tausiyah secara lengkap..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition font-sans leading-relaxed"><?= htmlspecialchars($art['konten'] ?? '') ?></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="<?= BASE_URL ?>/admin/artikelmgmt" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                Batal
            </a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl shadow-sm text-sm transition">
                <?= $isEdit ? 'Simpan Perubahan' : 'Terbitkan Artikel' ?>
            </button>
        </div>
    </form>
</div>
