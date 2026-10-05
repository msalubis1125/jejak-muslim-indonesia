<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="font-['Poppins'] font-bold text-xl text-gray-800">Antrean Verifikasi Masjid</h2>
        <p class="text-sm text-gray-500 mt-1">Review dan verifikasi pendaftaran masjid baru sebelum dipublikasikan.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/superadmin/masjidverif/allMasjid" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl text-sm font-medium hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            Semua Data Masjid
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                <tr>
                    <th class="py-4 px-6 font-semibold">Nama Masjid</th>
                    <th class="py-4 px-6 font-semibold">Wilayah</th>
                    <th class="py-4 px-6 font-semibold">Kontak Takmir</th>
                    <th class="py-4 px-6 font-semibold">Tanggal Daftar</th>
                    <th class="py-4 px-6 font-semibold text-center">Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                <?php if (empty($pending_list)): ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-emerald-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <p class="text-base font-medium text-gray-600">Tidak ada antrean verifikasi</p>
                                <p class="text-xs text-gray-400 mt-1">Semua pendaftaran masjid baru telah diproses.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pending_list as $masjid): ?>
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800"><?= htmlspecialchars($masjid['nama']) ?></div>
                                <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($masjid['alamat'] ?? '-') ?></div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <?= htmlspecialchars($masjid['kota'] ?? '-') ?>, <?= htmlspecialchars($masjid['provinsi'] ?? '') ?>
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-800 font-medium"><?= htmlspecialchars($masjid['no_hp_takmir'] ?? '-') ?></div>
                                <?php if (!empty($masjid['wa_link'])): ?>
                                    <a href="<?= htmlspecialchars($masjid['wa_link']) ?>" target="_blank" class="text-xs text-emerald-600 hover:underline">Hubungi via WA →</a>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-xs text-gray-500">
                                <?= date('d M Y H:i', strtotime($masjid['created_at'] ?? 'now')) ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="<?= BASE_URL ?>/admin/superadmin/masjidverif/verify/<?= $masjid['id'] ?>" method="POST" onsubmit="return confirm('Verifikasi dan setujui masjid ini?');">
                                        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="<?= BASE_URL ?>/admin/superadmin/masjidverif/reject/<?= $masjid['id'] ?>" method="POST" onsubmit="return confirm('Tolak pendaftaran masjid ini?');">
                                        <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                            Tolak
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
