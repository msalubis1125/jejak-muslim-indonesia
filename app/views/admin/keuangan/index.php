<?php
$list = $transaksi['data'] ?? [];
$totalRows = $transaksi['total'] ?? 0;
$page = $transaksi['page'] ?? 1;
$totalPages = $transaksi['total_pages'] ?? 1;

$totalMasuk = 0;
$totalKeluar = 0;
foreach ($list as $t) {
    $nom = (float)($t['nominal'] ?? 0);
    if (($t['tipe'] ?? '') === 'masuk') {
        $totalMasuk += $nom;
    } else {
        $totalKeluar += $nom;
    }
}
?>

<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">Buku Kas & Transaksi Keuangan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola pencatatan infaq, sedekah, dan operasional masjid secara transparan</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
            <button type="button" onclick="openPrintModal()" class="flex-1 sm:flex-initial inline-flex justify-center items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 text-xs sm:text-sm font-semibold transition text-center whitespace-nowrap">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span>Cetak / Ekspor</span>
            </button>
            <a href="<?= BASE_URL ?>/admin/keuangan/laporan" class="flex-1 sm:flex-initial inline-flex justify-center items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs sm:text-sm font-medium transition text-center whitespace-nowrap">
                <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span>Grafik Bulanan</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/keuangan/create" class="flex-1 sm:flex-initial inline-flex justify-center items-center gap-1.5 sm:gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 sm:py-2.5 px-3 sm:px-5 rounded-xl shadow-sm hover:shadow transition text-xs sm:text-sm text-center whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Catat Transaksi</span>
            </a>
        </div>
    </div>

    <!-- Saldo & Rekap Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-5">
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0-6.75-6.75M12 19.5l6.75-6.75" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider truncate">Pemasukan (Halaman Ini)</p>
                <p class="text-base sm:text-xl font-bold text-emerald-600 mt-0.5 sm:mt-1 font-mono truncate">Rp <?= number_format($totalMasuk, 0, ',', '.') ?></p>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0-6.75 6.75M12 4.5l6.75 6.75" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider truncate">Pengeluaran (Halaman Ini)</p>
                <p class="text-base sm:text-xl font-bold text-rose-600 mt-0.5 sm:mt-1 font-mono truncate">Rp <?= number_format($totalKeluar, 0, ',', '.') ?></p>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider truncate">Selisih Bersih</p>
                <?php $selisih = $totalMasuk - $totalKeluar; ?>
                <p class="text-base sm:text-xl font-bold <?= $selisih >= 0 ? 'text-blue-600' : 'text-rose-600' ?> mt-0.5 sm:mt-1 font-mono truncate">
                    Rp <?= number_format($selisih, 0, ',', '.') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Visual Scale & Cashflow Ratio Bar -->
    <?php
    $totalVolume = $totalMasuk + $totalKeluar;
    $pctMasuk = $totalVolume > 0 ? round(($totalMasuk / $totalVolume) * 100, 1) : 0;
    $pctKeluar = $totalVolume > 0 ? round(($totalKeluar / $totalVolume) * 100, 1) : 0;
    ?>
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2 sm:mb-3">
            <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Skala & Proporsi Arus Kas</span>
                <span class="text-[11px] sm:text-xs text-gray-400 font-mono">(<?= count($list) ?> Transaksi)</span>
            </div>
            <div class="flex items-center gap-3 sm:gap-4 text-[11px] sm:text-xs font-medium">
                <span class="inline-flex items-center gap-1.5 text-emerald-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                    Pemasukan: <?= $pctMasuk ?>%
                </span>
                <span class="inline-flex items-center gap-1.5 text-rose-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shrink-0"></span>
                    Pengeluaran: <?= $pctKeluar ?>%
                </span>
            </div>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-3 sm:h-3.5 flex overflow-hidden p-0.5 border border-gray-200">
            <?php if ($totalVolume > 0): ?>
                <div class="bg-emerald-500 h-full rounded-l-full transition-all duration-500" style="width: <?= $pctMasuk ?>%" title="Pemasukan: <?= $pctMasuk ?>%"></div>
                <div class="bg-rose-500 h-full rounded-r-full transition-all duration-500" style="width: <?= $pctKeluar ?>%" title="Pengeluaran: <?= $pctKeluar ?>%"></div>
            <?php else: ?>
                <div class="bg-gray-300 h-full w-full rounded-full"></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-3.5 sm:p-4 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" action="<?= BASE_URL ?>/admin/keuangan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
            <div>
                <select name="kas" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="">Semua Kas</option>
                    <?php foreach ($kas_list as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= (isset($_GET['kas']) && $_GET['kas'] == $k['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <select name="tipe" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="">Semua Tipe Transaksi</option>
                    <option value="masuk" <?= (isset($_GET['tipe']) && $_GET['tipe'] === 'masuk') ? 'selected' : '' ?>>Pemasukan</option>
                    <option value="keluar" <?= (isset($_GET['tipe']) && $_GET['tipe'] === 'keluar') ? 'selected' : '' ?>>Pengeluaran</option>
                </select>
            </div>
            <div>
                <select name="kategori" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori_list as $kat): ?>
                        <option value="<?= $kat['id'] ?>" <?= (isset($_GET['kategori']) && $_GET['kategori'] == $kat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kat['nama']) ?> (<?= ucfirst($kat['tipe']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-black text-white font-medium py-2 rounded-xl text-xs sm:text-sm transition text-center">
                    Filter
                </button>
                <a href="<?= BASE_URL ?>/admin/keuangan" class="px-3.5 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium rounded-xl text-xs sm:text-sm transition text-center shrink-0">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table Transaksi -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[620px]">
                <thead class="bg-gray-50 text-gray-600 border-b border-gray-100 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                    <tr>
                        <th class="py-3 px-3 sm:px-5">Tanggal</th>
                        <th class="py-3 px-3 sm:px-5">Kas & Kategori</th>
                        <th class="py-3 px-3 sm:px-5">Keterangan</th>
                        <th class="py-3 px-3 sm:px-5 text-right">Pemasukan</th>
                        <th class="py-3 px-3 sm:px-5 text-right">Pengeluaran</th>
                        <th class="py-3 px-3 sm:px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($list)): ?>
                        <tr>
                            <td colspan="6" class="py-10 sm:py-12 text-center text-gray-400">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 sm:mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                <span class="text-xs sm:text-sm">Belum ada transaksi yang tercatat. Silakan tambah transaksi baru.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list as $row): 
                            $isMasuk = ($row['tipe'] === 'masuk');
                            $nominal = (float)$row['nominal'];
                        ?>
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3 sm:py-4 px-3 sm:px-5 font-medium text-gray-800 whitespace-nowrap text-xs sm:text-sm">
                                    <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5">
                                    <div class="font-semibold text-gray-900 text-xs sm:text-sm"><?= htmlspecialchars($row['nama_kategori'] ?? 'Umum') ?></div>
                                    <div class="text-[11px] sm:text-xs text-gray-500"><?= htmlspecialchars($row['nama_kas'] ?? 'Kas Utama') ?></div>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-gray-600 max-w-[150px] sm:max-w-xs truncate text-xs sm:text-sm">
                                    <?= htmlspecialchars($row['keterangan'] ?? '-') ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-right font-mono font-semibold whitespace-nowrap text-xs sm:text-sm">
                                    <?php if ($isMasuk): ?>
                                        <span class="text-emerald-600">+Rp <?= number_format($nominal, 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-right font-mono font-semibold whitespace-nowrap text-xs sm:text-sm">
                                    <?php if (!$isMasuk): ?>
                                        <span class="text-rose-600">-Rp <?= number_format($nominal, 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1 sm:gap-2">
                                        <a href="<?= BASE_URL ?>/admin/keuangan/edit/<?= $row['id'] ?>" class="p-1.5 text-gray-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition" title="Edit Transaksi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="<?= BASE_URL ?>/admin/keuangan/delete/<?= $row['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Saldo kas terkait akan disesuaikan otomatis.');" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus Transaksi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 sm:px-6 py-3.5 border-t border-gray-100 bg-gray-50 text-xs sm:text-sm">
                <span class="text-gray-500 text-center sm:text-left">
                    Halaman <strong class="text-gray-800"><?= $page ?></strong> dari <strong class="text-gray-800"><?= $totalPages ?></strong> (Total <?= $totalRows ?> transaksi)
                </span>
                <div class="flex gap-2 w-full sm:w-auto justify-center">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="flex-1 sm:flex-initial px-3 py-1.5 border border-gray-200 bg-white rounded-lg hover:bg-gray-100 transition text-gray-700 text-center">Sebelumnya</a>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="flex-1 sm:flex-initial px-3 py-1.5 border border-gray-200 bg-white rounded-lg hover:bg-gray-100 transition text-gray-700 text-center">Selanjutnya</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Filter Cetak & Ekspor Laporan Keuangan -->
<div id="printModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-gray-100 overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-teal-700 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-white">Cetak & Ekspor Laporan</h3>
                    <p class="text-xs text-emerald-100">Sesuaikan periode, format, dan kantong kas</p>
                </div>
            </div>
            <button type="button" onclick="closePrintModal()" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body Form -->
        <form id="printFilterForm" method="GET" action="<?= BASE_URL ?>/admin/keuangan/print" target="_blank" class="p-6 space-y-5">
            <!-- 1. Pilihan Periode -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">1. Periode Waktu Laporan</label>
                <div class="grid grid-cols-2 gap-2 sm:gap-3">
                    <label class="flex items-center gap-2.5 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 border-emerald-500 bg-emerald-50/40" id="label_opt_jumat">
                        <input type="radio" name="periode" value="jumat" checked onchange="handlePeriodeChange('jumat')" class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs sm:text-sm font-semibold text-gray-800">Shalat Jumat</span>
                            <span class="block text-[11px] text-gray-500">1 pekan terakhir (mading/mimbar)</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-2.5 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 border-gray-200" id="label_opt_bulan">
                        <input type="radio" name="periode" value="bulan" onchange="handlePeriodeChange('bulan')" class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs sm:text-sm font-semibold text-gray-800">Bulanan</span>
                            <span class="block text-[11px] text-gray-500">Pilih bulan & tahun</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-2.5 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 border-gray-200" id="label_opt_tahun">
                        <input type="radio" name="periode" value="tahun" onchange="handlePeriodeChange('tahun')" class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs sm:text-sm font-semibold text-gray-800">Tahunan</span>
                            <span class="block text-[11px] text-gray-500">1 tahun buku penuh</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-2.5 p-3 border rounded-xl cursor-pointer hover:bg-gray-50 border-gray-200" id="label_opt_custom">
                        <input type="radio" name="periode" value="custom" onchange="handlePeriodeChange('custom')" class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs sm:text-sm font-semibold text-gray-800">Rentang Kustom</span>
                            <span class="block text-[11px] text-gray-500">Tentukan tanggal bebas</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Input Dinamis Berdasarkan Periode -->
            <div id="dynamicBulanBox" class="hidden p-3.5 bg-gray-50 rounded-xl border border-gray-100 flex gap-2">
                <div class="flex-1">
                    <label class="block text-[11px] font-medium text-gray-600 mb-1">Bulan</label>
                    <select name="bulan" class="w-full text-xs sm:text-sm border-gray-200 rounded-lg p-2 bg-white">
                        <?php
                        $mList = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                        foreach ($mList as $mNum => $mNama):
                        ?>
                            <option value="<?= str_pad($mNum, 2, '0', STR_PAD_LEFT) ?>" <?= date('m') == $mNum ? 'selected' : '' ?>><?= $mNama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="w-1/3">
                    <label class="block text-[11px] font-medium text-gray-600 mb-1">Tahun</label>
                    <select name="tahun" class="w-full text-xs sm:text-sm border-gray-200 rounded-lg p-2 bg-white">
                        <?php for ($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div id="dynamicCustomBox" class="hidden p-3.5 bg-gray-50 rounded-xl border border-gray-100 flex gap-2">
                <div class="flex-1">
                    <label class="block text-[11px] font-medium text-gray-600 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="<?= date('Y-m-01') ?>" class="w-full text-xs sm:text-sm border-gray-200 rounded-lg p-2 bg-white">
                </div>
                <div class="flex-1">
                    <label class="block text-[11px] font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="<?= date('Y-m-d') ?>" class="w-full text-xs sm:text-sm border-gray-200 rounded-lg p-2 bg-white">
                </div>
            </div>

            <!-- 2. Pilihan Kantong Kas -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">2. Pilih Pos / Kantong Kas</label>
                <select name="kas_id" class="w-full text-xs sm:text-sm border border-gray-200 rounded-xl p-2.5 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="">Semua Kantong Kas (Kas Operasional, Yatim, Pembangunan, dll)</option>
                    <?php if (!empty($kas_list)): ?>
                        <?php foreach ($kas_list as $k): ?>
                            <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kas']) ?> (Saldo: Rp <?= number_format($k['saldo'] ?? 0, 0, ',', '.') ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- 3. Format & Layout Tampilan -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">3. Format Layout</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 border-emerald-500 bg-emerald-50/30">
                        <input type="radio" name="format" value="ringkasan" checked class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs sm:text-sm font-semibold text-gray-800">Ringkasan Pos (1 Halaman)</span>
                            <span class="block text-[10px] text-gray-500">Hemat kertas, cocok untuk mading</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 p-2.5 border rounded-xl cursor-pointer hover:bg-gray-50 border-gray-200">
                        <input type="radio" name="format" value="detail" class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-xs sm:text-sm font-semibold text-gray-800">Buku Kas Rinci</span>
                            <span class="block text-[10px] text-gray-500">Seluruh tabel mutasi transaksi</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 4. Opsi Tanda Tangan Resmi -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-700">Cantumkan Kolom Tanda Tangan Pengurus (DKM & Bendahara)</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="ttd" value="1" checked class="sr-only peer">
                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- Modal Footer Buttons -->
            <div class="pt-2 flex flex-col sm:flex-row items-center gap-2 sm:gap-3">
                <button type="button" onclick="submitToExportCsv()" class="w-full sm:flex-1 inline-flex justify-center items-center gap-1.5 px-4 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 text-xs sm:text-sm font-semibold transition text-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Unduh File CSV / Excel</span>
                </button>
                <button type="submit" onclick="submitToPrintView()" class="w-full sm:flex-1 inline-flex justify-center items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold shadow-sm hover:shadow transition text-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Buka Tampilan Cetak</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPrintModal() {
    const modal = document.getElementById('printModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closePrintModal() {
    const modal = document.getElementById('printModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function handlePeriodeChange(val) {
    const bulanBox = document.getElementById('dynamicBulanBox');
    const customBox = document.getElementById('dynamicCustomBox');
    
    // Reset border styling pada label
    ['jumat', 'bulan', 'tahun', 'custom'].forEach(p => {
        const el = document.getElementById('label_opt_' + p);
        if (el) {
            if (p === val) {
                el.classList.add('border-emerald-500', 'bg-emerald-50/40');
                el.classList.remove('border-gray-200');
            } else {
                el.classList.remove('border-emerald-500', 'bg-emerald-50/40');
                el.classList.add('border-gray-200');
            }
        }
    });

    if (val === 'bulan') {
        bulanBox.classList.remove('hidden');
        customBox.classList.add('hidden');
    } else if (val === 'custom') {
        bulanBox.classList.add('hidden');
        customBox.classList.remove('hidden');
    } else {
        bulanBox.classList.add('hidden');
        customBox.classList.add('hidden');
    }
}

function submitToPrintView() {
    const form = document.getElementById('printFilterForm');
    form.action = '<?= BASE_URL ?>/admin/keuangan/print';
    form.target = '_blank';
}

function submitToExportCsv() {
    const form = document.getElementById('printFilterForm');
    form.action = '<?= BASE_URL ?>/admin/keuangan/exportCsv';
    form.target = '_self';
    form.submit();
}

// Tutup modal jika klik di luar box
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePrintModal();
});
</script>
