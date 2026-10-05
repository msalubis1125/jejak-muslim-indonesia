<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="font-['Poppins'] font-bold text-xl sm:text-2xl text-gray-800">Direktori Jamaah & Peserta Kajian</h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Daftar jamaah umum yang pernah mendaftar kegiatan atau kajian di masjid Anda.</p>
    </div>
    <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-800 px-3.5 py-1.5 rounded-full text-xs font-semibold self-start sm:self-auto border border-emerald-200">
        <span>Total Terdata:</span>
        <span class="font-bold"><?= count($jamaah_list ?? []) ?> Orang</span>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-left text-xs sm:text-sm min-w-[600px]">
            <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                <tr>
                    <th class="py-3.5 px-4 sm:px-6 font-semibold">Nama Jamaah</th>
                    <th class="py-3.5 px-4 sm:px-6 font-semibold">WhatsApp / No HP</th>
                    <th class="py-3.5 px-4 sm:px-6 font-semibold">Kegiatan Terakhir Diikuti</th>
                    <th class="py-3.5 px-4 sm:px-6 font-semibold text-center">Partisipasi</th>
                    <th class="py-3.5 px-4 sm:px-6 font-semibold text-center">Tanggal Pendaftaran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                <?php if (empty($jamaah_list)): ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3 text-gray-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada jamaah yang mendaftar kegiatan.</p>
                            <p class="text-xs text-gray-400 mt-1">Data jamaah akan otomatis tercatat setiap kali ada pendaftaran kegiatan/kajian.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($jamaah_list as $j): ?>
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="font-semibold text-gray-800"><?= htmlspecialchars($j['nama']) ?></div>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6">
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $j['no_hp']) ?>" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 font-medium text-xs">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    <span><?= htmlspecialchars($j['no_hp']) ?></span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6">
                                <span class="text-xs text-gray-700 line-clamp-1"><?= htmlspecialchars($j['kegiatan_terakhir'] ?? '-') ?></span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <?= (int)($j['total_partisipasi'] ?? 1) ?>x Kegiatan
                                </span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-center text-xs text-gray-400">
                                <?= !empty($j['tanggal_terakhir']) ? date('d M Y, H:i', strtotime($j['tanggal_terakhir'])) : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
