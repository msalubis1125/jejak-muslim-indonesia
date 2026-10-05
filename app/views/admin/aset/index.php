<?php
$list = $aset_list ?? [];
?>

<div class="space-y-4 sm:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h1 class="font-heading font-bold text-xl sm:text-2xl text-gray-800">Manajemen Aset & Inventaris</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Pencatatan sarana, prasarana, dan fasilitas masjid secara transparan</p>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
            <a href="<?= BASE_URL ?>/admin/aset/create" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 sm:py-2.5 px-4 sm:px-5 rounded-xl shadow-sm hover:shadow transition text-xs sm:text-sm whitespace-nowrap text-center">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Aset</span>
            </a>
        </div>
    </div>

    <!-- Table Aset -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[550px]">
                <thead class="bg-gray-50 text-gray-600 border-b border-gray-100 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                    <tr>
                        <th class="py-3 px-3 sm:px-5">Nama Aset</th>
                        <th class="py-3 px-3 sm:px-5">Kategori</th>
                        <th class="py-3 px-3 sm:px-5">Jumlah</th>
                        <th class="py-3 px-3 sm:px-5">Kondisi</th>
                        <th class="py-3 px-3 sm:px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($list)): ?>
                        <tr>
                            <td colspan="5" class="py-10 sm:py-12 text-center text-gray-400">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 sm:mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                <span class="text-xs sm:text-sm">Belum ada data aset yang terdaftar.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($list as $row): 
                            $kondisi = strtolower($row['kondisi'] ?? 'baik');
                        ?>
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3 sm:py-4 px-3 sm:px-5">
                                    <div class="font-semibold text-gray-900 text-xs sm:text-sm"><?= htmlspecialchars($row['nama_aset'] ?? '-') ?></div>
                                    <?php if (!empty($row['keterangan'])): ?>
                                        <div class="text-[11px] sm:text-xs text-gray-500 max-w-xs truncate"><?= htmlspecialchars($row['keterangan']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-gray-600 whitespace-nowrap">
                                    <?= htmlspecialchars($row['kategori'] ?? 'Umum') ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 font-mono font-medium text-gray-800 whitespace-nowrap">
                                    <?= htmlspecialchars($row['jumlah'] ?? '1') ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 whitespace-nowrap">
                                    <?php if ($kondisi === 'baik'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Baik
                                        </span>
                                    <?php elseif ($kondisi === 'rusak_ringan'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            Rusak Ringan
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            Rusak Berat
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 sm:py-4 px-3 sm:px-5 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1 sm:gap-2">
                                        <a href="<?= BASE_URL ?>/admin/aset/edit/<?= $row['id'] ?>" class="p-1.5 text-gray-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition" title="Edit Aset">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="<?= BASE_URL ?>/admin/aset/delete/<?= $row['id'] ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?');" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Hapus Aset">
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
