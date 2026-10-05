<?php
$isEdit = !empty($aset);
$a = $aset ?? [];
?>

<div class="max-w-2xl mx-auto space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white sm:bg-transparent p-4 sm:p-0 rounded-2xl sm:rounded-none border sm:border-0 border-gray-100 shadow-sm sm:shadow-none">
        <div>
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">
                <?= $isEdit ? 'Edit Data Aset' : 'Tambah Aset & Inventaris' ?>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                <?= $isEdit ? 'Perbarui data sarana dan inventaris masjid.' : 'Catat aset atau fasilitas baru yang dimiliki masjid.' ?>
            </p>
        </div>
        <a href="<?= BASE_URL ?>/admin/aset" class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium text-gray-600 hover:bg-gray-50 transition whitespace-nowrap self-start sm:self-auto">
            Kembali
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/aset/<?= $isEdit ? 'update/' . $a['id'] : 'store' ?>" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-5">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Nama Aset <span class="text-rose-500">*</span></label>
            <input type="text" name="nama_aset" required value="<?= htmlspecialchars($a['nama_aset'] ?? '') ?>" placeholder="Contoh: Sound System Ruang Utama" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                <input type="text" name="kategori" required value="<?= htmlspecialchars($a['kategori'] ?? '') ?>" placeholder="Contoh: Elektronik, Perlengkapan" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Kondisi <span class="text-rose-500">*</span></label>
                <select name="kondisi" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm bg-white">
                    <option value="baik" <?= ($a['kondisi'] ?? '') === 'baik' ? 'selected' : '' ?>>Baik (Dapat digunakan)</option>
                    <option value="rusak_ringan" <?= ($a['kondisi'] ?? '') === 'rusak_ringan' ? 'selected' : '' ?>>Rusak Ringan (Perlu Servis)</option>
                    <option value="rusak_berat" <?= ($a['kondisi'] ?? '') === 'rusak_berat' ? 'selected' : '' ?>>Rusak Berat</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Jumlah & Satuan <span class="text-rose-500">*</span></label>
                <input type="text" name="jumlah" required value="<?= htmlspecialchars($a['jumlah'] ?? '1 Unit') ?>" placeholder="Contoh: 2 Unit, 10 Gulung" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tanggal Diperoleh</label>
                <input type="date" name="tanggal_diperoleh" value="<?= htmlspecialchars($a['tanggal_diperoleh'] ?? date('Y-m-d')) ?>" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Keterangan / Lokasi Penyimpanan</label>
            <textarea name="keterangan" rows="3" placeholder="Contoh: Hibah dari H. Fulan, disimpan di gudang lantai 2..." class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm"><?= htmlspecialchars($a['keterangan'] ?? '') ?></textarea>
        </div>

        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-gray-100">
            <a href="<?= BASE_URL ?>/admin/aset" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-medium transition text-center">
                Batal
            </a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow transition text-xs sm:text-sm inline-flex items-center justify-center gap-2 text-center">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Aset' ?></span>
            </button>
        </div>
    </form>
</div>
