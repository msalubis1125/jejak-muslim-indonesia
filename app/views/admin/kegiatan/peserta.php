<div class="space-y-4 sm:space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="<?= BASE_URL ?>/admin/kegiatan" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">← Kembali ke Kegiatan</a>
            </div>
            <h1 class="font-heading font-bold text-lg sm:text-xl text-gray-800">Peserta: <?= htmlspecialchars($kegiatan['judul'] ?? 'Kegiatan') ?></h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                Jadwal: <?= !empty($kegiatan['tanggal_mulai']) ? date('d M Y', strtotime($kegiatan['tanggal_mulai'])) : '-' ?> 
                <?php if (!empty($kegiatan['jam_mulai'])): ?>
                    (<?= date('H:i', strtotime($kegiatan['jam_mulai'])) ?> WIB)
                <?php endif; ?>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-gray-50 border border-gray-200 px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-medium">
                Pendaftar: <strong class="text-emerald-700"><?= count($peserta_list ?? []) ?></strong>
                <?php if (!empty($kegiatan['kuota'])): ?>
                    <span class="text-gray-400">/ <?= number_format($kegiatan['kuota']) ?> Kuota</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[550px]">
                <thead class="bg-gray-50 text-gray-600 border-b border-gray-100 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                    <tr>
                        <th class="py-3 px-3 sm:px-5">No</th>
                        <th class="py-3 px-3 sm:px-5">Nama Peserta</th>
                        <th class="py-3 px-3 sm:px-5">WhatsApp / HP</th>
                        <th class="py-3 px-3 sm:px-5">Waktu Daftar</th>
                        <th class="py-3 px-3 sm:px-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php if (empty($peserta_list)): ?>
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    <p class="text-xs sm:text-sm font-medium text-gray-500">Belum ada jamaah yang mendaftar pada kegiatan ini.</p>
                                </div>
                            </td>
                        </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($peserta_list as $p): ?>
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-4 px-6 text-gray-400"><?= $no++ ?></td>
                            <td class="py-4 px-6 font-semibold text-gray-800">
                                <?= htmlspecialchars($p['nama_peserta'] ?? '-') ?>
                            </td>
                            <td class="py-4 px-6 font-medium">
                                <span class="text-gray-700"><?= htmlspecialchars($p['no_hp'] ?? '-') ?></span>
                                <?php if (!empty($p['no_hp'])): 
                                    $waNumber = preg_replace('/[^0-9]/', '', $p['no_hp']);
                                    if (substr($waNumber, 0, 1) === '0') $waNumber = '62' . substr($waNumber, 1);
                                ?>
                                    <a href="https://wa.me/<?= $waNumber ?>" target="_blank" class="ml-1 sm:ml-2 text-xs text-emerald-600 hover:underline">Chat WA →</a>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 sm:py-4 px-3 sm:px-5 text-xs text-gray-500 whitespace-nowrap">
                                <?= !empty($p['created_at']) ? date('d M Y H:i', strtotime($p['created_at'])) : '-' ?>
                            </td>
                            <td class="py-3 sm:py-4 px-3 sm:px-5 text-center whitespace-nowrap">
                                <?php if (($p['status'] ?? '') === 'confirmed'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Terkonfirmasi</span>
                                <?php elseif (($p['status'] ?? '') === 'cancelled'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">Batal</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Terdaftar</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
