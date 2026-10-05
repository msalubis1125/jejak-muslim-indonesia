<?php
$isSuperAdmin = !empty($is_super_admin);
?>

<div class="space-y-4 sm:space-y-6">
    <?php if ($isSuperAdmin): ?>
        <!-- SUPER ADMIN DASHBOARD -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] sm:text-xs font-semibold bg-emerald-50 text-emerald-700 mb-1.5 sm:mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Super Administrator Panel
                </span>
                <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">Pusat Kendali Jejak Muslim Indonesia</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Pemantauan ekosistem masjid digital, verifikasi takmir, dan master data nasional</p>
            </div>
            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold py-2 sm:py-2.5 px-4 sm:px-5 rounded-xl shadow-sm transition text-center whitespace-nowrap">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Verifikasi Masjid (<?= $pending_verifikasi ?? 0 ?>)</span>
                </a>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Total Masjid</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900 mt-0.5 font-mono truncate"><?= number_format($total_masjid ?? 0) ?></p>
                </div>
            </div>

            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.745 3.745 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Terverifikasi</p>
                    <p class="text-lg sm:text-2xl font-bold text-blue-600 mt-0.5 font-mono truncate"><?= number_format($verified_masjid ?? 0) ?></p>
                </div>
            </div>

            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Menunggu</p>
                    <p class="text-lg sm:text-2xl font-bold text-amber-600 mt-0.5 font-mono truncate"><?= number_format($pending_verifikasi ?? 0) ?></p>
                </div>
            </div>

            <div class="bg-white p-3.5 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">User & Takmir</p>
                    <p class="text-lg sm:text-2xl font-bold text-purple-600 mt-0.5 font-mono truncate"><?= number_format($total_users ?? 0) ?></p>
                </div>
            </div>
        </div>

        <!-- Daftar Masjid Terdaftar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
            <div class="p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="font-heading font-semibold text-base sm:text-lg text-gray-800">Daftar Masjid Terdaftar</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pantau status verifikasi dan lokasi masjid</p>
                </div>
                <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 whitespace-nowrap">Semua →</a>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm min-w-[550px]">
                    <thead class="bg-gray-50 text-gray-600 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                        <tr>
                            <th class="py-3 px-4 sm:px-6">Nama Masjid</th>
                            <th class="py-3 px-4 sm:px-6">Kota / Wilayah</th>
                            <th class="py-3 px-4 sm:px-6">Kapasitas</th>
                            <th class="py-3 px-4 sm:px-6">Status</th>
                            <th class="py-3 px-4 sm:px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach (($masjid_list ?? []) as $m): ?>
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="py-3.5 px-4 sm:px-6 font-medium text-gray-900">
                                    <?= htmlspecialchars($m['nama']) ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-gray-600">
                                    <?= htmlspecialchars($m['kota'] ?? '-') ?>, <?= htmlspecialchars($m['provinsi'] ?? '') ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-gray-600 font-mono">
                                    <?= !empty($m['kapasitas']) ? number_format((int)$m['kapasitas'], 0, ',', '.') . ' Jamaah' : '-' ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                    <?php if ($m['status'] === 'verified'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                            Terverifikasi
                                        </span>
                                    <?php elseif ($m['status'] === 'pending'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                            Pending
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">
                                            Suspended
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-center whitespace-nowrap">
                                    <a href="<?= BASE_URL ?>/masjid/<?= htmlspecialchars($m['slug'] ?? $m['id']) ?>" target="_blank" class="text-xs font-medium text-emerald-600 hover:underline">
                                        Lihat Portal
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <!-- TAKMIR DASHBOARD -->
        <div class="bg-gradient-to-r from-emerald-800 to-emerald-950 text-white p-4 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] sm:text-xs font-semibold bg-white/10 text-emerald-200 mb-2 sm:mb-3 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Portal Takmir Pengurus
                </span>
                <h1 class="font-heading font-bold text-xl sm:text-2xl lg:text-3xl text-white">
                    <?= htmlspecialchars($masjid['nama'] ?? 'Masjid Kita') ?>
                </h1>
                <p class="text-emerald-200 text-xs sm:text-sm mt-1 max-w-xl">
                    <?= htmlspecialchars($masjid['alamat'] ?? 'Wilayah ' . ($masjid['kota'] ?? '')) ?>
                </p>
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-4 sm:mt-5">
                    <a href="<?= BASE_URL ?>/admin/masjid" class="inline-flex items-center gap-1.5 sm:gap-2 bg-white text-emerald-800 hover:bg-emerald-50 text-xs font-semibold py-2 sm:py-2.5 px-3.5 sm:px-4 rounded-xl transition shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <span>Edit Profil & Peta GIS</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/keuangan/create" class="inline-flex items-center gap-1.5 sm:gap-2 bg-emerald-700/80 hover:bg-emerald-700 text-white text-xs font-semibold py-2 sm:py-2.5 px-3.5 sm:px-4 rounded-xl transition border border-emerald-600/50 whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Catat Mutasi Kas</span>
                    </a>
                    <a href="<?= BASE_URL ?>/masjid/<?= htmlspecialchars($masjid['slug'] ?? $masjid['id'] ?? '') ?>" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-200 hover:text-white text-xs font-medium py-2 sm:py-2.5 px-2.5 sm:px-3 transition whitespace-nowrap">
                        <span>Lihat Publik →</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Takmir Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-5">
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Total Saldo Kas</p>
                    <p class="text-lg sm:text-2xl font-bold text-emerald-600 mt-0.5 font-mono truncate">Rp <?= number_format($total_saldo ?? 0, 0, ',', '.') ?></p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Kegiatan Bulan Ini</p>
                    <p class="text-lg sm:text-2xl font-bold text-blue-600 mt-0.5 font-mono truncate"><?= number_format($kegiatan_bulan_ini ?? 0) ?> Agenda</p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Jamaah Terdaftar</p>
                    <p class="text-lg sm:text-2xl font-bold text-purple-600 mt-0.5 font-mono truncate"><?= number_format($jumlah_jamaah ?? 0) ?> Orang</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Left Col (2/3): Transaksi Terbaru -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
                    <div class="p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="font-heading font-semibold text-base sm:text-lg text-gray-800">Mutasi Kas Terbaru</h2>
                            <p class="text-xs text-gray-500 mt-0.5">5 transaksi terakhir di pembukuan</p>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/keuangan" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 whitespace-nowrap">Semua →</a>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left text-xs sm:text-sm min-w-[500px]">
                            <thead class="bg-gray-50 text-gray-600 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                                <tr>
                                    <th class="py-3 px-4 sm:px-6">Tanggal</th>
                                    <th class="py-3 px-4 sm:px-6">Kategori</th>
                                    <th class="py-3 px-4 sm:px-6">Keterangan</th>
                                    <th class="py-3 px-4 sm:px-6 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if (empty($transaksi_terakhir)): ?>
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-400 text-xs sm:text-sm">
                                            Belum ada transaksi mutasi kas tercatat.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($transaksi_terakhir as $tx): 
                                        $isMasuk = ($tx['tipe'] === 'masuk');
                                        $nom = (float)$tx['nominal'];
                                    ?>
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 whitespace-nowrap text-gray-700 font-medium">
                                                <?= date('d M Y', strtotime($tx['tanggal'])) ?>
                                            </td>
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] sm:text-xs font-medium <?= $isMasuk ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' ?>">
                                                    <?= htmlspecialchars($tx['nama_kategori'] ?? 'Kas') ?>
                                                </span>
                                            </td>
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 text-gray-600 max-w-[150px] sm:max-w-xs truncate">
                                                <?= htmlspecialchars($tx['keterangan'] ?? '-') ?>
                                            </td>
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 text-right font-mono font-semibold whitespace-nowrap <?= $isMasuk ? 'text-emerald-600' : 'text-rose-600' ?>">
                                                <?= $isMasuk ? '+Rp ' : '-Rp ' ?><?= number_format($nom, 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Col (1/3): Agenda Terdekat -->
            <div class="space-y-4 sm:space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-3 sm:mb-4">
                        <h2 class="font-heading font-semibold text-sm sm:text-base text-gray-800">Kegiatan Terdekat</h2>
                        <a href="<?= BASE_URL ?>/admin/kegiatan" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 whitespace-nowrap">Kelola →</a>
                    </div>
                    <?php if (empty($kegiatan_mendatang)): ?>
                        <div class="py-6 sm:py-8 text-center text-gray-400 text-xs">
                            Tidak ada agenda kegiatan terdekat.
                        </div>
                    <?php else: ?>
                        <div class="space-y-2.5 sm:space-y-3">
                            <?php foreach ($kegiatan_mendatang as $keg): ?>
                                <div class="p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition">
                                    <div class="text-xs font-semibold text-emerald-700 flex items-center gap-1.5 mb-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        <span><?= date('d M Y', strtotime($keg['tanggal_mulai'])) ?></span>
                                    </div>
                                    <h3 class="font-medium text-xs sm:text-sm text-gray-900 line-clamp-1"><?= htmlspecialchars($keg['judul']) ?></h3>
                                    <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5 line-clamp-1"><?= htmlspecialchars($keg['lokasi_detail'] ?? 'Area Masjid') ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
