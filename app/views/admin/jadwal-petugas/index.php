<?php
$list = $jadwal_list ?? [];
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
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">Jadwal Petugas Shalat & Khutbah</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Susun jadwal imam, khotib jumat, dan muadzin masjid secara rapi</p>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
            <a href="<?= BASE_URL ?>/admin/jadwalpetugas/create" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 sm:py-2.5 px-4 sm:px-5 rounded-xl shadow-sm hover:shadow transition text-xs sm:text-sm whitespace-nowrap text-center">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Jadwal</span>
            </a>
        </div>
    </div>

    <!-- Filter Periode -->
    <div class="bg-white p-3.5 sm:p-4 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" action="<?= BASE_URL ?>/admin/jadwalpetugas" class="flex flex-wrap items-center gap-2 sm:gap-3">
            <span class="text-xs sm:text-sm font-medium text-gray-700 whitespace-nowrap">Periode:</span>
            <select name="bulan" class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" <?= $selectedBulan == $m ? 'selected' : '' ?>>
                        <?= $namaBulan[$m] ?>
                    </option>
                <?php endfor; ?>
            </select>
            <select name="tahun" class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <?php for ($y = date('Y'); $y >= date('Y') - 2; $y--): ?>
                    <option value="<?= $y ?>" <?= $selectedTahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-5 rounded-xl text-xs sm:text-sm transition text-center">
                Filter
            </button>
        </form>
    </div>

    <!-- Table Jadwal -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[620px]">
                <thead class="bg-gray-50 text-gray-600 border-b border-gray-100 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                    <tr>
                        <th class="py-3 px-3 sm:px-5">Tanggal</th>
                        <th class="py-3 px-3 sm:px-5">Tipe Shalat</th>
                        <th class="py-3 px-3 sm:px-5">Imam / Khotib</th>
                        <th class="py-3 px-3 sm:px-5">Muadzin</th>
                        <th class="py-3 px-3 sm:px-5">Catatan</th>
                        <th class="py-3 px-3 sm:px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($list)): ?>
                        <tr>
                            <td colspan="6" class="py-10 sm:py-12 text-center text-gray-400">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 sm:mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <span class="text-xs sm:text-sm">Belum ada jadwal petugas pada periode ini.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list as $row): 
                            $isJumat = (strtolower($row['tipe'] ?? '') === 'jumat');
                        ?>
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3 sm:py-4 px-3 sm:px-5 font-medium text-gray-800 whitespace-nowrap">
                                    <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] sm:text-xs font-medium <?= $isJumat ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'bg-blue-50 text-blue-700' ?>">
                                        <?= $isJumat ? 'Shalat Jumat' : 'Harian / Rawatib' ?>
                                    </span>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 font-semibold text-gray-900">
                                    <?= htmlspecialchars(!empty($row['khotib']) ? $row['khotib'] : ($row['imam'] ?? '-')) ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-gray-600">
                                    <?= htmlspecialchars($row['muadzin'] ?? '-') ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-gray-500 max-w-[150px] sm:max-w-xs truncate text-xs">
                                    <?= htmlspecialchars($row['catatan'] ?? '-') ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1 sm:gap-2">
                                        <a href="<?= BASE_URL ?>/admin/jadwalpetugas/edit/<?= $row['id'] ?>" class="p-1.5 text-gray-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition" title="Edit Jadwal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="<?= BASE_URL ?>/admin/jadwalpetugas/delete/<?= $row['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal petugas ini?');" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus Jadwal">
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
    </div>
</div>
