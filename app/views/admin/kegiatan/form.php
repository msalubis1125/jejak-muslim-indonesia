<?php
$isEdit = !empty($kegiatan);
$k = $kegiatan ?? [];
?>

<div class="max-w-3xl mx-auto space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white sm:bg-transparent p-4 sm:p-0 rounded-2xl sm:rounded-none border sm:border-0 border-gray-100 shadow-sm sm:shadow-none">
        <div>
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">
                <?= $isEdit ? 'Edit Agenda Kegiatan' : 'Tambah Agenda Kegiatan Baru' ?>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                <?= $isEdit ? 'Perbarui informasi agenda kegiatan masjid Anda.' : 'Publikasikan kajian atau program dakwah agar dapat dilihat jamaah.' ?>
            </p>
        </div>
        <a href="<?= BASE_URL ?>/admin/kegiatan" class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium text-gray-600 hover:bg-gray-50 transition whitespace-nowrap self-start sm:self-auto">
            Kembali
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/kegiatan/<?= $isEdit ? 'update/' . $k['id'] : 'store' ?>" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-5">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Judul Kegiatan <span class="text-rose-500">*</span></label>
            <input type="text" name="judul" required value="<?= htmlspecialchars($k['judul'] ?? '') ?>" placeholder="Contoh: Kajian Rutin Ahad Pagi" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Deskripsi / Rincian Kegiatan</label>
            <textarea name="deskripsi" rows="4" placeholder="Tuliskan pemateri, tema kajian, dan informasi penting lainnya..." class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm"><?= htmlspecialchars($k['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai <span class="text-rose-500">*</span></label>
                <input type="date" name="tanggal_mulai" required value="<?= htmlspecialchars($k['tanggal_mulai'] ?? date('Y-m-d')) ?>" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai <span class="text-rose-500">*</span></label>
                <input type="date" name="tanggal_selesai" required value="<?= htmlspecialchars($k['tanggal_selesai'] ?? date('Y-m-d')) ?>" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Jam Mulai</label>
                <input type="time" name="jam_mulai" value="<?= htmlspecialchars(!empty($k['jam_mulai']) ? date('H:i', strtotime($k['jam_mulai'])) : '08:00') ?>" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Jam Selesai</label>
                <input type="time" name="jam_selesai" value="<?= htmlspecialchars(!empty($k['jam_selesai']) ? date('H:i', strtotime($k['jam_selesai'])) : '10:00') ?>" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Lokasi Spesifik</label>
            <input type="text" name="lokasi_detail" value="<?= htmlspecialchars($k['lokasi_detail'] ?? '') ?>" placeholder="Contoh: Ruang Utama Masjid Lt. 1" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Poster Kegiatan (Opsional)</label>
            <?php if (!empty($k['poster'])): ?>
                <div class="mb-2 flex items-center gap-3">
                    <?php
                        $posterSrc = (strpos($k['poster'], 'http') === 0) ? $k['poster'] : BASE_URL . '/public/uploads/kegiatan/' . $k['poster'];
                    ?>
                    <img src="<?= htmlspecialchars($posterSrc) ?>" class="w-16 h-16 object-cover rounded-xl border border-gray-200" alt="Poster Saat Ini">
                    <span class="text-xs text-gray-500">Poster saat ini terpasang. Unggah baru untuk mengganti.</span>
                </div>
            <?php endif; ?>
            <input type="file" name="poster" accept="image/*" class="w-full px-3.5 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
        </div>

        <div class="p-3.5 sm:p-4 bg-gray-50 rounded-xl border border-gray-100 space-y-3">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="perlu_daftar" value="1" <?= !empty($k['perlu_daftar']) ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 rounded">
                <span class="text-xs sm:text-sm font-medium text-gray-700">Aktifkan Formulir Pendaftaran Jamaah Online</span>
            </label>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500 whitespace-nowrap">Kuota Peserta:</span>
                <input type="number" name="kuota" value="<?= htmlspecialchars($k['kuota'] ?? 0) ?>" min="0" placeholder="0 = Tanpa batas" class="w-32 px-3 py-1.5 bg-white border border-gray-200 rounded-lg outline-none text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500">
                <span class="text-[11px] text-gray-400">(Isi 0 untuk kapasitas tanpa batas)</span>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-gray-100">
            <a href="<?= BASE_URL ?>/admin/kegiatan" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-medium transition text-center">
                Batal
            </a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow transition text-xs sm:text-sm inline-flex items-center justify-center gap-2 text-center">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span><?= $isEdit ? 'Simpan Perubahan' : 'Terbitkan Kegiatan' ?></span>
            </button>
        </div>
    </form>
</div>
