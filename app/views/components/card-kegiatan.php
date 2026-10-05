<?php
$kegiatan = $kegiatan ?? [];
?>
<a href="<?= BASE_URL ?>/kegiatan/<?= $kegiatan['id'] ?? '' ?>" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
    <div class="relative w-full h-32 bg-gray-200">
        <img src="<?= htmlspecialchars($kegiatan['poster'] ?? BASE_URL.'/public/img/kegiatan-placeholder.jpg') ?>" alt="Poster" class="w-full h-full object-cover">
        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-xs font-semibold px-2 py-1 rounded-lg text-emerald-700 shadow-sm">
            <?= htmlspecialchars($kegiatan['kategori'] ?? 'Kajian') ?>
        </div>
    </div>
    <div class="p-4">
        <h3 class="font-['Poppins'] font-semibold text-gray-800 text-sm mb-2 line-clamp-2"><?= htmlspecialchars($kegiatan['judul'] ?? 'Judul Kegiatan') ?></h3>
        <div class="space-y-1 mb-3">
            <div class="flex items-center text-xs text-gray-500">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <?= htmlspecialchars($kegiatan['tanggal'] ?? 'Tanggal') ?>
            </div>
            <div class="flex items-center text-xs text-gray-500">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <span class="line-clamp-1"><?= htmlspecialchars($kegiatan['masjid_nama'] ?? 'Lokasi') ?></span>
            </div>
        </div>
        <?php if ($kegiatan['perlu_daftar'] ?? false): ?>
            <div class="text-[10px] font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-md inline-block">Wajib Daftar</div>
        <?php endif; ?>
    </div>
</a>
