<div class="py-4">
    <div class="mb-6">
        <h1 class="font-heading font-bold text-2xl sm:text-3xl text-gray-900">Buletin & Artikel Islami</h1>
        <p class="text-sm text-gray-500 mt-1">Kumpulan tulisan islami, wawasan fikih ibadah, dan pengumuman kegiatan umat.</p>
    </div>
    
    <!-- Filter Pills -->
    <?php 
    $activeKat = $data['kategori'] ?? ($kategori ?? '');
    ?>
    <div class="flex overflow-x-auto gap-2 mb-8 pb-2 hide-scrollbar">
        <a href="<?= BASE_URL ?>/artikel" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= empty($activeKat) ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Semua
        </a>
        <a href="<?= BASE_URL ?>/artikel?kategori=buletin" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= $activeKat === 'buletin' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Buletin Jumat
        </a>
        <a href="<?= BASE_URL ?>/artikel?kategori=berita" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= $activeKat === 'berita' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Berita Masjid
        </a>
        <a href="<?= BASE_URL ?>/artikel?kategori=pengumuman" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition <?= $activeKat === 'pengumuman' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
            Pengumuman
        </a>
    </div>

    <!-- Article Grid: 1 col mobile, 2 col tablet, 3 col desktop -->
    <?php 
    $artikels = $data['artikel_list'] ?? ($data['artikels'] ?? ($artikel_list ?? []));
    if (empty($artikels)): ?>
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-md mx-auto text-gray-400">
            Belum ada artikel pada kategori ini.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($artikels as $art): ?>
                <a href="<?= BASE_URL ?>/artikel/<?= $art['slug'] ?? $art['id'] ?>" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="h-48 bg-gray-100 overflow-hidden">
                            <img src="<?= htmlspecialchars($art['gambar'] ?? BASE_URL.'/public/img/placeholder.svg') ?>" alt="Artikel" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-5">
                            <span class="text-[10px] uppercase font-bold text-emerald-700 tracking-wider">
                                <?= htmlspecialchars($art['kategori'] ?? 'Buletin') ?>
                            </span>
                            <h3 class="font-heading font-bold text-gray-900 text-base mt-1.5 group-hover:text-emerald-600 transition line-clamp-2">
                                <?= htmlspecialchars($art['judul']) ?>
                            </h3>
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                                <?= htmlspecialchars($art['konten'] ?? '') ?>
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-2 border-t border-gray-50 flex items-center justify-between text-xs text-gray-400">
                        <span><?= date('d M Y', strtotime($art['published_at'] ?? $art['created_at'])) ?></span>
                        <span class="text-emerald-600 font-semibold group-hover:translate-x-1 transition-transform">Baca →</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
