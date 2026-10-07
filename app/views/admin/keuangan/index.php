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
    <!-- Header Banner: Clean Typography & Balanced Actions -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl sm:rounded-3xl shadow-sm border border-gray-100 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100/60">
                    Akuntansi & Kas
                </span>
                <span class="text-xs text-gray-400 font-medium">&bull; Transparansi Keuangan Masjid</span>
            </div>
            <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-gray-900 tracking-tight">Buku Kas & Transaksi Keuangan</h1>
            <p class="text-xs sm:text-sm text-gray-500">Pencatatan real-time infaq, sedekah, dan operasional masjid yang akuntabel</p>
        </div>
        
        <!-- Action Buttons: Clean & Proportional Grouping -->
        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap shrink-0">
            <button type="button" onclick="openKategoriModal()" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-3.5 sm:py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 font-medium text-xs sm:text-sm transition shadow-2xs whitespace-nowrap" title="Atur kategori kas masjid">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.386a48.09 48.09 0 0 0 5.405-5.405c.486-.827.313-1.908-.386-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
                <span>Kategori</span>
            </button>
            <a href="<?= BASE_URL ?>/admin/keuangan/laporan" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-3.5 sm:py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 font-medium text-xs sm:text-sm transition shadow-2xs whitespace-nowrap" title="Lihat grafik tren bulanan">
                <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
                <span>Grafik</span>
            </a>
            <button type="button" onclick="openPrintModal()" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 sm:px-3.5 sm:py-2.5 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-semibold text-xs sm:text-sm transition shadow-2xs whitespace-nowrap">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span>Cetak / Ekspor</span>
            </button>
            <a href="<?= BASE_URL ?>/admin/keuangan/create" class="inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm shadow-sm hover:shadow transition whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Catat Transaksi</span>
            </a>
        </div>
    </div>

    <!-- Saldo & Rekap 4 Cards: Symmetrical & Balanced -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
        <!-- Card 1: Total Seluruh Kas -->
        <div class="bg-gradient-to-br from-[#064e3b] via-[#065f46] to-teal-800 rounded-2xl p-5 text-white shadow-sm flex flex-col justify-between min-h-[118px] relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/5 rounded-full pointer-events-none transition-transform group-hover:scale-125"></div>
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-semibold text-emerald-200 uppercase tracking-wider">Total Kas Masjid</span>
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center shrink-0 border border-white/10">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-xl sm:text-2xl font-extrabold font-mono text-white">
                    Rp <?= number_format($total_saldo ?? 0, 0, ',', '.') ?>
                </p>
                <p class="text-[11px] text-emerald-200/80 mt-0.5">Saldo riil seluruh kantong kas</p>
            </div>
        </div>

        <!-- Card 2: Pemasukan -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between min-h-[118px]">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemasukan</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100/60">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m0 0-6.75-6.75M12 19.5l6.75-6.75" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 font-mono">
                    +Rp <?= number_format($totalMasuk, 0, ',', '.') ?>
                </p>
                <p class="text-[11px] text-gray-400 mt-0.5">Total debit tersaring</p>
            </div>
        </div>

        <!-- Card 3: Pengeluaran -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between min-h-[118px]">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengeluaran</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100/60">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0-6.75 6.75M12 4.5l6.75 6.75" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-xl sm:text-2xl font-extrabold text-rose-600 font-mono">
                    -Rp <?= number_format($totalKeluar, 0, ',', '.') ?>
                </p>
                <p class="text-[11px] text-gray-400 mt-0.5">Total kredit tersaring</p>
            </div>
        </div>

        <!-- Card 4: Selisih Mutasi -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between min-h-[118px]">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Selisih Mutasi</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100/60">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <?php $selisih = $totalMasuk - $totalKeluar; ?>
                <p class="text-xl sm:text-2xl font-extrabold <?= $selisih >= 0 ? 'text-blue-600' : 'text-rose-600' ?> font-mono">
                    <?= $selisih >= 0 ? '+' : '' ?>Rp <?= number_format($selisih, 0, ',', '.') ?>
                </p>
                <p class="text-[11px] text-gray-400 mt-0.5">Surplus / defisit periode</p>
            </div>
        </div>
    </div>

    <!-- Visual Scale & Cashflow Ratio Bar: Compact & Streamlined -->
    <?php
    $totalVolume = $totalMasuk + $totalKeluar;
    $pctMasuk = $totalVolume > 0 ? round(($totalMasuk / $totalVolume) * 100, 1) : 0;
    $pctKeluar = $totalVolume > 0 ? round(($totalKeluar / $totalVolume) * 100, 1) : 0;
    ?>
    <div class="bg-white px-4 py-3 sm:px-5 sm:py-3.5 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Rasio Arus Kas:</span>
            <div class="flex items-center gap-3 text-xs font-semibold">
                <span class="inline-flex items-center gap-1.5 text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Masuk <?= $pctMasuk ?>%
                </span>
                <span class="inline-flex items-center gap-1.5 text-rose-700">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    Keluar <?= $pctKeluar ?>%
                </span>
            </div>
        </div>
        <div class="flex-1 max-w-md w-full bg-gray-100 rounded-full h-2.5 flex overflow-hidden p-0.5 border border-gray-200">
            <?php if ($totalVolume > 0): ?>
                <div class="bg-emerald-500 h-full rounded-l-full transition-all duration-500" style="width: <?= $pctMasuk ?>%"></div>
                <div class="bg-rose-500 h-full rounded-r-full transition-all duration-500" style="width: <?= $pctKeluar ?>%"></div>
            <?php else: ?>
                <div class="bg-gray-200 h-full w-full rounded-full"></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter Form: Sleek & Aligned -->
    <div class="bg-white p-3.5 sm:p-4 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" action="<?= BASE_URL ?>/admin/keuangan" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
            <div>
                <select name="kas" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                    <option value="">Semua Kas</option>
                    <?php foreach ($kas_list as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= (isset($_GET['kas']) && $_GET['kas'] == $k['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <select id="filterTipe" name="tipe" onchange="syncKategoriOptions()" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                    <option value="">Semua Tipe Transaksi</option>
                    <option value="masuk" <?= (isset($_GET['tipe']) && $_GET['tipe'] === 'masuk') ? 'selected' : '' ?>>Pemasukan (+)</option>
                    <option value="keluar" <?= (isset($_GET['tipe']) && $_GET['tipe'] === 'keluar') ? 'selected' : '' ?>>Pengeluaran (-)</option>
                </select>
            </div>
            <div>
                <?php
                $katMasukList = [];
                $katKeluarList = [];
                foreach ($kategori_list as $kat) {
                    $t = strtolower($kat['tipe'] ?? '');
                    if ($t === 'pemasukan' || $t === 'masuk') {
                        $katMasukList[] = $kat;
                    } else {
                        $katKeluarList[] = $kat;
                    }
                }
                $selectedKatId = $_GET['kategori'] ?? '';
                ?>
                <select id="filterKategori" name="kategori" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                    <option value="" data-tipe="all">Semua Kategori</option>
                    
                    <optgroup label="── Pos Pemasukan ──" id="optgroupMasuk">
                        <?php foreach ($katMasukList as $kat): ?>
                            <option value="<?= $kat['id'] ?>" data-tipe="masuk" <?= ($selectedKatId == $kat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>

                    <optgroup label="── Pos Pengeluaran ──" id="optgroupKeluar">
                        <?php foreach ($katKeluarList as $kat): ?>
                            <option value="<?= $kat['id'] ?>" data-tipe="keluar" <?= ($selectedKatId == $kat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kat['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-black text-white font-semibold py-2.5 rounded-xl text-xs sm:text-sm transition text-center shadow-xs">
                    Filter
                </button>
                <a href="<?= BASE_URL ?>/admin/keuangan" class="px-3.5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold rounded-xl text-xs sm:text-sm transition text-center shrink-0">
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
                            <td colspan="6" class="py-14 text-center">
                                <div class="max-w-sm mx-auto flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-gray-800 text-sm sm:text-base">Belum Ada Transaksi Tercatat</h4>
                                    <p class="text-xs text-gray-500 mt-1 mb-4 leading-relaxed">
                                        Mulai catat penerimaan kotak infaq, sedekah subuh, atau belanja operasional masjid.
                                    </p>
                                    <a href="<?= BASE_URL ?>/admin/keuangan/create" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Catat Transaksi Sekarang</span>
                                    </a>
                                </div>
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

            <!-- 2. Pilihan Kantong Kas & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">2. Pos / Kantong Kas</label>
                    <select name="kas_id" class="w-full text-xs sm:text-sm border border-gray-200 rounded-xl p-2.5 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Semua Kantong Kas</option>
                        <?php if (!empty($kas_list)): ?>
                            <?php foreach ($kas_list as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kas']) ?> (Saldo: Rp <?= number_format($k['saldo'] ?? 0, 0, ',', '.') ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kategori Transaksi</label>
                    <select name="kategori_id" class="w-full text-xs sm:text-sm border border-gray-200 rounded-xl p-2.5 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Semua Kategori (Pemasukan & Pengeluaran)</option>
                        <optgroup label="── Pos Pemasukan ──">
                            <?php foreach ($katMasukList as $kat): ?>
                                <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="── Pos Pengeluaran ──">
                            <?php foreach ($katKeluarList as $kat): ?>
                                <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
            </div>

            <!-- Pilihan Tipe Transaksi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tipe Mutasi Dicetak</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="flex items-center justify-center p-2 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 text-center has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/40">
                        <input type="radio" name="tipe" value="" checked class="hidden">
                        <span class="text-xs font-semibold text-gray-800">Semua Mutasi</span>
                    </label>
                    <label class="flex items-center justify-center p-2 border border-gray-200 rounded-xl cursor-pointer hover:bg-emerald-50 text-center has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/40">
                        <input type="radio" name="tipe" value="masuk" class="hidden">
                        <span class="text-xs font-semibold text-emerald-700">Pemasukan Saja (+)</span>
                    </label>
                    <label class="flex items-center justify-center p-2 border border-gray-200 rounded-xl cursor-pointer hover:bg-rose-50 text-center has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/40">
                        <input type="radio" name="tipe" value="keluar" class="hidden">
                        <span class="text-xs font-semibold text-rose-700">Pengeluaran Saja (-)</span>
                    </label>
                </div>
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

function syncKategoriOptions() {
    const tipe = document.getElementById('filterTipe')?.value || '';
    const katSelect = document.getElementById('filterKategori');
    const groupMasuk = document.getElementById('optgroupMasuk');
    const groupKeluar = document.getElementById('optgroupKeluar');

    if (!katSelect) return;

    if (tipe === 'masuk') {
        if (groupMasuk) groupMasuk.style.display = '';
        if (groupKeluar) groupKeluar.style.display = 'none';
        // Reset pilihan jika saat ini kategori terpilih bertipe keluar
        const currentSelected = katSelect.options[katSelect.selectedIndex];
        if (currentSelected && currentSelected.dataset.tipe === 'keluar') {
            katSelect.value = '';
        }
    } else if (tipe === 'keluar') {
        if (groupMasuk) groupMasuk.style.display = 'none';
        if (groupKeluar) groupKeluar.style.display = '';
        // Reset pilihan jika saat ini kategori terpilih bertipe masuk
        const currentSelected = katSelect.options[katSelect.selectedIndex];
        if (currentSelected && currentSelected.dataset.tipe === 'masuk') {
            katSelect.value = '';
        }
    } else {
        // Tampilkan kedua grup
        if (groupMasuk) groupMasuk.style.display = '';
        if (groupKeluar) groupKeluar.style.display = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    syncKategoriOptions();
});

// Tutup modal jika klik di luar box
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePrintModal();
        closeKategoriModal();
    }
});

function openKategoriModal() {
    const modal = document.getElementById('kategoriModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeKategoriModal() {
    const modal = document.getElementById('kategoriModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}
</script>

<!-- Modal Kelola Kategori Mandiri Takmir Masjid -->
<div id="kategoriModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/60 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Header Modal -->
        <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-emerald-50/50 shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 font-heading">Kelola Kategori Kas Masjid</h3>
                <p class="text-xs text-gray-500">Kategori mandiri khusus masjid Anda (Masjid, Anak Yatim, MDA, Dhuafa, dll)</p>
            </div>
            <button type="button" onclick="closeKategoriModal()" class="w-8 h-8 rounded-full bg-white hover:bg-gray-100 text-gray-400 hover:text-gray-600 flex items-center justify-center transition border border-gray-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-5 sm:p-6 overflow-y-auto space-y-5 custom-scrollbar flex-1">
            <!-- Form Tambah Kategori Baru -->
            <form action="<?= BASE_URL ?>/admin/keuangan/addKategori" method="POST" class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-3">
                <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">+ Tambah Kategori Baru</span>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-1">Nama Kategori</label>
                        <input type="text" name="nama" required placeholder="Contoh: Anak Yatim, MDA, Dhuafa" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-1">Tipe Mutasi</label>
                        <select name="tipe" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="pemasukan">Pemasukan (+)</option>
                            <option value="pengeluaran">Pengeluaran (-)</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Simpan Kategori Baru</span>
                </button>
            </form>

            <!-- Daftar Kategori Aktif -->
            <div>
                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2.5">Daftar Kategori Kas Masjid</span>
                <div class="space-y-1.5 max-h-56 overflow-y-auto pr-1 custom-scrollbar">
                    <?php foreach ($kategori_list as $kItem): 
                        $isCustom = !empty($kItem['masjid_id']);
                        $isMasuk = strtolower($kItem['tipe']) === 'pemasukan' || strtolower($kItem['tipe']) === 'masuk';
                    ?>
                        <div class="flex items-center justify-between p-2.5 bg-white border border-gray-100 rounded-xl hover:border-gray-200 transition">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full <?= $isMasuk ? 'bg-emerald-500' : 'bg-rose-500' ?>"></span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-800"><?= htmlspecialchars($kItem['nama']) ?></span>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-medium <?= $isMasuk ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' ?>">
                                    <?= $isMasuk ? 'Pemasukan' : 'Pengeluaran' ?>
                                </span>
                                <?php if ($isCustom): ?>
                                    <span class="text-[9px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded font-medium">Khusus Masjid</span>
                                <?php else: ?>
                                    <span class="text-[9px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">Default Sistem</span>
                                <?php endif; ?>
                            </div>

                            <?php if ($isCustom): ?>
                                <form action="<?= BASE_URL ?>/admin/keuangan/deleteKategori/<?= $kItem['id'] ?>" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                    <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                    <button type="submit" class="p-1 text-gray-400 hover:text-rose-600 transition" title="Hapus Kategori">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex justify-end shrink-0">
            <button type="button" onclick="closeKategoriModal()" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-white rounded-xl text-xs sm:text-sm font-medium transition">
                Tutup
            </button>
        </div>
    </div>
</div>
