<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-['Poppins'] font-bold text-gray-800">Manajemen Artikel & Buletin</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Publikasi artikel, kajian, dan buletin dakwah digital masjid.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/artikelmgmt/create" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-xl shadow-sm text-sm transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tulis Artikel Baru
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($artikels)): ?>
            <div class="p-12 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <p class="font-medium text-sm">Belum ada artikel yang ditulis.</p>
                <p class="text-xs text-gray-400 mt-1">Mulai publikasikan kajian dan buletin masjid Anda sekarang.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="py-3.5 px-4 font-semibold">Judul & Kategori</th>
                            <?php if (Auth::isSuperAdmin()): ?>
                                <th class="py-3.5 px-4 font-semibold">Masjid / Sumber</th>
                            <?php endif; ?>
                            <th class="py-3.5 px-4 font-semibold text-center">Status</th>
                            <th class="py-3.5 px-4 font-semibold">Tanggal Publikasi</th>
                            <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <?php foreach ($artikels as $art): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3.5 px-4">
                                    <div class="font-medium text-gray-900"><?= htmlspecialchars($art['judul']) ?></div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">
                                            <?= htmlspecialchars($art['kategori'] ?? 'Kajian') ?>
                                        </span>
                                        <a href="<?= BASE_URL ?>/artikel/<?= htmlspecialchars($art['slug']) ?>" target="_blank" class="text-xs text-gray-400 hover:text-emerald-600 transition inline-flex items-center gap-1">
                                            Lihat di web ↗
                                        </a>
                                    </div>
                                </td>
                                <?php if (Auth::isSuperAdmin()): ?>
                                    <td class="py-3.5 px-4 text-xs text-gray-600">
                                        <?= !empty($art['masjid_nama']) ? htmlspecialchars($art['masjid_nama']) : '<span class="text-indigo-600 font-semibold">Pusat / Nasional</span>' ?>
                                    </td>
                                <?php endif; ?>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if (!empty($art['is_published'])): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            Tayang
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            Draft
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500">
                                    <?= !empty($art['published_at']) ? date('d M Y, H:i', strtotime($art['published_at'])) : '-' ?>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <!-- Toggle Publish Form -->
                                        <form action="<?= BASE_URL ?>/admin/artikelmgmt/togglePublish/<?= $art['id'] ?>" method="POST" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="text-xs px-2.5 py-1 rounded-lg border border-gray-200 hover:bg-gray-100 font-medium text-gray-600 transition">
                                                <?= !empty($art['is_published']) ? 'Draft' : 'Terbitkan' ?>
                                            </button>
                                        </form>

                                        <!-- Edit -->
                                        <a href="<?= BASE_URL ?>/admin/artikelmgmt/edit/<?= $art['id'] ?>" class="text-xs px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium transition">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form action="<?= BASE_URL ?>/admin/artikelmgmt/delete/<?= $art['id'] ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="text-xs px-2.5 py-1 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 font-medium transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
