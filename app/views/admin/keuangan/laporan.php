<?php
$sum = $summary ?? ['total_masuk' => 0, 'total_keluar' => 0, 'saldo' => 0];
$txList = $transaksi ?? [];
$selectedBulan = (int)($bulan ?? date('m'));
$selectedTahun = (int)($tahun ?? date('Y'));

$namaBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
?>

<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">Laporan Keuangan Bulanan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Periode: <?= $namaBulan[$selectedBulan] ?? $selectedBulan ?> <?= $selectedTahun ?></p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="<?= BASE_URL ?>/admin/keuangan" class="flex-1 sm:flex-initial inline-flex justify-center items-center px-3.5 py-2 border border-gray-200 rounded-xl text-xs sm:text-sm font-medium text-gray-600 hover:bg-gray-50 transition text-center whitespace-nowrap">
                ← Kembali
            </a>
            <button onclick="window.print()" class="flex-1 sm:flex-initial inline-flex justify-center items-center gap-1.5 sm:gap-2 bg-gray-800 hover:bg-black text-white font-medium py-2 px-3.5 sm:px-4 rounded-xl text-xs sm:text-sm transition text-center whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                <span>Cetak</span>
            </button>
        </div>
    </div>

    <!-- Filter Periode -->
    <div class="bg-white p-3.5 sm:p-4 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" action="<?= BASE_URL ?>/admin/keuangan/laporan" class="flex flex-wrap items-center gap-2 sm:gap-3">
            <span class="text-xs sm:text-sm font-medium text-gray-700 whitespace-nowrap">Pilih Periode:</span>
            <select name="bulan" class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" <?= $selectedBulan == $m ? 'selected' : '' ?>>
                        <?= $namaBulan[$m] ?>
                    </option>
                <?php endfor; ?>
            </select>
            <select name="tahun" class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <?php for ($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
                    <option value="<?= $y ?>" <?= $selectedTahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-5 rounded-xl text-xs sm:text-sm transition text-center">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Ringkasan Periode -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6">
        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-100 shadow-sm">
            <h3 class="text-[11px] sm:text-xs font-semibold text-emerald-600 uppercase tracking-wider mb-1">Total Pemasukan</h3>
            <p class="text-lg sm:text-2xl font-bold text-emerald-600 font-mono">Rp <?= number_format($sum['total_masuk'], 0, ',', '.') ?></p>
        </div>
        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-100 shadow-sm">
            <h3 class="text-[11px] sm:text-xs font-semibold text-rose-600 uppercase tracking-wider mb-1">Total Pengeluaran</h3>
            <p class="text-lg sm:text-2xl font-bold text-rose-600 font-mono">Rp <?= number_format($sum['total_keluar'], 0, ',', '.') ?></p>
        </div>
        <div class="bg-white rounded-2xl p-4 sm:p-6 border border-gray-100 shadow-sm">
            <h3 class="text-[11px] sm:text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">Saldo Periode Ini</h3>
            <p class="text-lg sm:text-2xl font-bold <?= $sum['saldo'] >= 0 ? 'text-blue-600' : 'text-rose-600' ?> font-mono">
                Rp <?= number_format($sum['saldo'], 0, ',', '.') ?>
            </p>
        </div>
    </div>

    <!-- Skala & Visual Analisis Keuangan Bulanan -->
    <?php
    $vol = (float)($sum['total_masuk'] ?? 0) + (float)($sum['total_keluar'] ?? 0);
    $pMasuk = $vol > 0 ? round(((float)$sum['total_masuk'] / $vol) * 100, 1) : 0;
    $pKeluar = $vol > 0 ? round(((float)$sum['total_keluar'] / $vol) * 100, 1) : 0;

    $katMasuk = [];
    $katKeluar = [];
    foreach ($txList as $t) {
        $kNama = $t['nama_kategori'] ?? 'Umum';
        $nom = (float)($t['nominal'] ?? 0);
        if (($t['tipe'] ?? '') === 'masuk') {
            $katMasuk[$kNama] = ($katMasuk[$kNama] ?? 0) + $nom;
        } else {
            $katKeluar[$kNama] = ($katKeluar[$kNama] ?? 0) + $nom;
        }
    }
    arsort($katMasuk);
    arsort($katKeluar);
    ?>
    <div class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5 sm:space-y-6">
        <!-- Scale Bar -->
        <div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                <h3 class="text-xs sm:text-sm font-bold text-gray-800 uppercase tracking-wider">Perbandingan Arus Kas Masuk vs Keluar</h3>
                <div class="flex items-center gap-3 sm:gap-4 text-[11px] sm:text-xs font-semibold">
                    <span class="text-emerald-700">Masuk: <?= $pMasuk ?>%</span>
                    <span class="text-rose-700">Keluar: <?= $pKeluar ?>%</span>
                </div>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-3 sm:h-4 flex overflow-hidden p-0.5 border border-gray-200">
                <?php if ($vol > 0): ?>
                    <div class="bg-emerald-500 h-full rounded-l-full transition-all duration-500" style="width: <?= $pMasuk ?>%" title="Pemasukan: <?= $pMasuk ?>%"></div>
                    <div class="bg-rose-500 h-full rounded-r-full transition-all duration-500" style="width: <?= $pKeluar ?>%" title="Pengeluaran: <?= $pKeluar ?>%"></div>
                <?php else: ?>
                    <div class="bg-gray-200 h-full w-full rounded-full"></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Category Breakdown Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 pt-4 border-t border-gray-100">
            <!-- Pos Pemasukan Breakdown -->
            <div>
                <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2 sm:mb-3 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Distribusi Pos Pemasukan
                </h4>
                <?php if (empty($katMasuk)): ?>
                    <p class="text-xs text-gray-400 italic">Belum ada pemasukan pada periode ini.</p>
                <?php else: ?>
                    <div class="space-y-2.5">
                        <?php foreach ($katMasuk as $kName => $kNom): 
                            $pct = $sum['total_masuk'] > 0 ? round(($kNom / $sum['total_masuk']) * 100, 1) : 0;
                        ?>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-gray-700"><?= htmlspecialchars($kName) ?></span>
                                    <span class="font-mono text-gray-600 font-semibold">Rp <?= number_format($kNom, 0, ',', '.') ?> (<?= $pct ?>%)</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: <?= $pct ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pos Pengeluaran Breakdown -->
            <div>
                <h4 class="text-xs font-bold text-rose-700 uppercase tracking-wider mb-2 sm:mb-3 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    Distribusi Pos Pengeluaran
                </h4>
                <?php if (empty($katKeluar)): ?>
                    <p class="text-xs text-gray-400 italic">Belum ada pengeluaran pada periode ini.</p>
                <?php else: ?>
                    <div class="space-y-2.5">
                        <?php foreach ($katKeluar as $kName => $kNom): 
                            $pct = $sum['total_keluar'] > 0 ? round(($kNom / $sum['total_keluar']) * 100, 1) : 0;
                        ?>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-gray-700"><?= htmlspecialchars($kName) ?></span>
                                    <span class="font-mono text-gray-600 font-semibold">Rp <?= number_format($kNom, 0, ',', '.') ?> (<?= $pct ?>%)</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-rose-500 h-full rounded-full" style="width: <?= $pct ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Detail Rincian Transaksi -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
        <div class="p-4 sm:p-5 border-b border-gray-100">
            <h2 class="font-heading font-semibold text-sm sm:text-base text-gray-800">Rincian Mutasi Kas (<?= count($txList) ?> Transaksi)</h2>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[550px]">
                <thead class="bg-gray-50 text-gray-600 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                    <tr>
                        <th class="py-3 px-3 sm:px-5">Tanggal</th>
                        <th class="py-3 px-3 sm:px-5">Buku Kas</th>
                        <th class="py-3 px-3 sm:px-5">Kategori</th>
                        <th class="py-3 px-3 sm:px-5">Keterangan</th>
                        <th class="py-3 px-3 sm:px-5 text-right">Pemasukan</th>
                        <th class="py-3 px-3 sm:px-5 text-right">Pengeluaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($txList)): ?>
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-400 text-xs sm:text-sm">
                                Tidak ada mutasi transaksi pada periode bulan ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($txList as $row): 
                            $isMasuk = ($row['tipe'] === 'masuk');
                            $nom = (float)$row['nominal'];
                        ?>
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 sm:py-3.5 px-3 sm:px-5 font-medium text-gray-800 whitespace-nowrap">
                                    <?= date('d/m/Y', strtotime($row['tanggal'])) ?>
                                </td>
                                <td class="py-3 sm:py-3.5 px-3 sm:px-5 text-gray-600 whitespace-nowrap"><?= htmlspecialchars($row['nama_kas'] ?? 'Kas Umum') ?></td>
                                <td class="py-3 sm:py-3.5 px-3 sm:px-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] sm:text-xs font-medium <?= $isMasuk ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' ?>">
                                        <?= htmlspecialchars($row['nama_kategori'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="py-3 sm:py-3.5 px-3 sm:px-5 text-gray-600 max-w-[150px] sm:max-w-xs truncate"><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
                                <td class="py-3 sm:py-3.5 px-3 sm:px-5 text-right font-mono font-semibold whitespace-nowrap text-emerald-600">
                                    <?= $isMasuk ? '+Rp ' . number_format($nom, 0, ',', '.') : '-' ?>
                                </td>
                                <td class="py-3 sm:py-3.5 px-3 sm:px-5 text-right font-mono font-semibold whitespace-nowrap text-rose-600">
                                    <?= !$isMasuk ? '-Rp ' . number_format($nom, 0, ',', '.') : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
