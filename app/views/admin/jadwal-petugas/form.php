<?php
$isEdit = !empty($jadwal);
$j = $jadwal ?? [];
?>

<div class="max-w-2xl mx-auto space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white sm:bg-transparent p-4 sm:p-0 rounded-2xl sm:rounded-none border sm:border-0 border-gray-100 shadow-sm sm:shadow-none">
        <div>
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">
                <?= $isEdit ? 'Edit Jadwal Petugas' : 'Tambah Jadwal Petugas Baru' ?>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                <?= $isEdit ? 'Perbarui informasi imam atau khotib masjid.' : 'Tetapkan jadwal imam shalat fardhu atau khotib Jumat.' ?>
            </p>
        </div>
        <a href="<?= BASE_URL ?>/admin/jadwalpetugas" class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium text-gray-600 hover:bg-gray-50 transition whitespace-nowrap self-start sm:self-auto">
            Kembali
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/jadwalpetugas/<?= $isEdit ? 'update/' . $j['id'] : 'store' ?>" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-5">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tipe Shalat <span class="text-rose-500">*</span></label>
                <select name="tipe" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm bg-white">
                    <option value="harian" <?= ($j['tipe'] ?? '') === 'harian' ? 'selected' : '' ?>>Harian (Rawatib / Fardhu)</option>
                    <option value="jumat" <?= ($j['tipe'] ?? '') === 'jumat' ? 'selected' : '' ?>>Shalat Jumat</option>
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tanggal <span class="text-rose-500">*</span></label>
                <input type="date" name="tanggal" required value="<?= htmlspecialchars($j['tanggal'] ?? date('Y-m-d')) ?>" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Imam / Khotib <span class="text-rose-500">*</span></label>
            <input type="text" name="imam" required value="<?= htmlspecialchars(!empty($j['khotib']) ? $j['khotib'] : ($j['imam'] ?? '')) ?>" placeholder="Nama Ustadz / Imam" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Muadzin / Bilal (Opsional)</label>
            <input type="text" name="muadzin" value="<?= htmlspecialchars($j['muadzin'] ?? '') ?>" placeholder="Nama Muadzin" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
        </div>

        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Catatan / Tema Khutbah (Opsional)</label>
            <textarea name="catatan" rows="2" placeholder="Contoh: Tema khutbah: Keutamaan Menjaga Silaturahmi" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm"><?= htmlspecialchars($j['catatan'] ?? '') ?></textarea>
        </div>

        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-gray-100">
            <a href="<?= BASE_URL ?>/admin/jadwalpetugas" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-medium transition text-center">
                Batal
            </a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow transition text-xs sm:text-sm inline-flex items-center justify-center gap-2 text-center">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Jadwal' ?></span>
            </button>
        </div>
    </form>
</div>
