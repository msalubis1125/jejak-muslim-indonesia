<?php
$isEdit = !empty($transaksi);
$t = $transaksi ?? [];
$selectedTipe = $t['tipe'] ?? 'masuk';
$selectedKas = $t['kas_id'] ?? ($kas_list[0]['id'] ?? '');
$selectedKat = $t['kategori_id'] ?? '';
$selectedTanggal = $t['tanggal'] ?? date('Y-m-d');
$nominalVal = !empty($t['nominal']) ? number_format((float)$t['nominal'], 0, '', '') : '';
?>

<div class="max-w-2xl mx-auto space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white sm:bg-transparent p-4 sm:p-0 rounded-2xl sm:rounded-none border sm:border-0 border-gray-100 shadow-sm sm:shadow-none">
        <div>
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">
                <?= $isEdit ? 'Edit Transaksi Keuangan' : 'Catat Transaksi Keuangan Baru' ?>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                <?= $isEdit ? 'Perbarui data transaksi kas. Saldo akan otomatis disesuaikan.' : 'Catat pemasukan atau pengeluaran kas masjid secara akurat.' ?>
            </p>
        </div>
        <a href="<?= BASE_URL ?>/admin/keuangan" class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium text-gray-600 hover:bg-gray-50 transition whitespace-nowrap self-start sm:self-auto">
            Kembali
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/keuangan/save" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($t['id']) ?>">
        <?php endif; ?>

        <!-- Tipe Transaksi -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Jenis Transaksi <span class="text-rose-500">*</span></label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-4">
                <label class="flex items-center gap-3 p-3 sm:p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:bg-emerald-50/50 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 transition">
                    <input type="radio" name="tipe" value="masuk" <?= $selectedTipe === 'masuk' ? 'checked' : '' ?> class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 shrink-0">
                    <div class="min-w-0">
                        <div class="font-semibold text-xs sm:text-sm text-gray-900">Pemasukan Kas</div>
                        <div class="text-[11px] sm:text-xs text-gray-500 truncate">Infaq, Sedekah, Donasi</div>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-3 sm:p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:bg-rose-50/50 has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 transition">
                    <input type="radio" name="tipe" value="keluar" <?= $selectedTipe === 'keluar' ? 'checked' : '' ?> class="w-4 h-4 text-rose-600 focus:ring-rose-500 shrink-0">
                    <div class="min-w-0">
                        <div class="font-semibold text-xs sm:text-sm text-gray-900">Pengeluaran Kas</div>
                        <div class="text-[11px] sm:text-xs text-gray-500 truncate">Operasional, Listrik, Konsumsi</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            <!-- Akun Kas -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Buku Kas <span class="text-rose-500">*</span></label>
                <select name="kas_id" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <?php if (empty($kas_list)): ?>
                        <option value="1">Kas Umum (Default)</option>
                    <?php else: ?>
                        <?php foreach ($kas_list as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= $selectedKas == $k['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['nama_kas']) ?> (Saldo: Rp <?= number_format($k['saldo'] ?? 0, 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Kategori Transaksi <span class="text-rose-500">*</span></label>
                <?php
                $katMasuk = [];
                $katKeluar = [];
                foreach ($kategori_list as $kat) {
                    $t = strtolower($kat['tipe'] ?? '');
                    if ($t === 'pemasukan' || $t === 'masuk') {
                        $katMasuk[] = $kat;
                    } else {
                        $katKeluar[] = $kat;
                    }
                }
                ?>
                <select id="formKategori" name="kategori_id" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="">-- Pilih Kategori --</option>
                    <optgroup label="── Pos Pemasukan ──" id="formGroupMasuk">
                        <?php foreach ($katMasuk as $kat): ?>
                            <option value="<?= $kat['id'] ?>" data-tipe="masuk" <?= $selectedKat == $kat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="── Pos Pengeluaran ──" id="formGroupKeluar">
                        <?php foreach ($katKeluar as $kat): ?>
                            <option value="<?= $kat['id'] ?>" data-tipe="keluar" <?= $selectedKat == $kat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            <!-- Nominal -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Nominal (Rp) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-3.5 top-2.5 text-xs sm:text-sm font-bold text-gray-400">Rp</span>
                    <input type="number" name="nominal" required min="1" step="100" value="<?= htmlspecialchars($nominalVal) ?>" placeholder="Contoh: 500000" class="w-full pl-10 pr-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm font-mono font-semibold">
                </div>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Tanggal Transaksi <span class="text-rose-500">*</span></label>
                <input type="date" name="tanggal" required value="<?= htmlspecialchars($selectedTanggal) ?>" class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm">
            </div>
        </div>

        <!-- Keterangan -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">Keterangan / Uraian Transaksi</label>
            <textarea name="keterangan" rows="3" placeholder="Contoh: Infaq shalat Jumat dari kotak amal utama..." class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-xs sm:text-sm"><?= htmlspecialchars($t['keterangan'] ?? '') ?></textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-gray-100">
            <a href="<?= BASE_URL ?>/admin/keuangan" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-medium transition text-center">
                Batal
            </a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow transition text-xs sm:text-sm inline-flex items-center justify-center gap-2 text-center">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Transaksi' ?></span>
            </button>
        </div>
    </form>
</div>

<script>
function syncFormKategori() {
    const selectedTipe = document.querySelector('input[name="tipe"]:checked')?.value || 'masuk';
    const katSelect = document.getElementById('formKategori');
    const groupMasuk = document.getElementById('formGroupMasuk');
    const groupKeluar = document.getElementById('formGroupKeluar');

    if (!katSelect) return;

    if (selectedTipe === 'masuk') {
        if (groupMasuk) groupMasuk.style.display = '';
        if (groupKeluar) groupKeluar.style.display = 'none';
        const currentSelected = katSelect.options[katSelect.selectedIndex];
        if (currentSelected && currentSelected.dataset.tipe === 'keluar') {
            katSelect.value = '';
        }
    } else {
        if (groupMasuk) groupMasuk.style.display = 'none';
        if (groupKeluar) groupKeluar.style.display = '';
        const currentSelected = katSelect.options[katSelect.selectedIndex];
        if (currentSelected && currentSelected.dataset.tipe === 'masuk') {
            katSelect.value = '';
        }
    }
}

document.querySelectorAll('input[name="tipe"]').forEach(radio => {
    radio.addEventListener('change', syncFormKategori);
});

document.addEventListener('DOMContentLoaded', syncFormKategori);
</script>
