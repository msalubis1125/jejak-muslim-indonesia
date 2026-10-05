<?php
$masjid = $masjid ?? [];
$isList = $isList ?? false;
$layoutClass = $isList ? 'flex flex-row items-center' : 'flex flex-col';
$imgClass = $isList ? 'w-28 sm:w-36 h-36 object-cover rounded-l-2xl' : 'w-full h-44 object-cover rounded-t-2xl';

$slugOrId = !empty($masjid['slug']) ? $masjid['slug'] : ($masjid['id'] ?? '');

$fotoUtama = !empty($masjid['foto_utama']) 
    ? ((strpos($masjid['foto_utama'], 'http') === 0) ? $masjid['foto_utama'] : BASE_URL . '/uploads/masjid/' . $masjid['foto_utama'])
    : 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80';
?>

<a href="<?= BASE_URL ?>/masjid/<?= htmlspecialchars($slugOrId) ?>" class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-emerald-200 transition-all duration-300 block overflow-hidden <?= $layoutClass ?>">
    <div class="relative overflow-hidden <?= $isList ? 'shrink-0' : 'w-full' ?>">
        <img src="<?= htmlspecialchars($fotoUtama) ?>" alt="<?= htmlspecialchars($masjid['nama'] ?? 'Masjid') ?>" class="<?= $imgClass ?> group-hover:scale-105 transition-transform duration-500">
        <?php if (!empty($masjid['buka_24jam'])): ?>
            <span class="absolute top-2 left-2 bg-emerald-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                24 Jam
            </span>
        <?php endif; ?>
    </div>

    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
        <div>
            <div class="flex items-start justify-between gap-2 mb-1.5">
                <h3 class="font-heading font-semibold text-gray-900 group-hover:text-emerald-700 transition text-base line-clamp-1">
                    <?= htmlspecialchars($masjid['nama'] ?? 'Nama Masjid') ?>
                </h3>
                <span class="text-[11px] bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full font-medium whitespace-nowrap shrink-0">
                    <?= htmlspecialchars($masjid['kota'] ?? 'Indonesia') ?>
                </span>
            </div>

            <p class="text-xs text-gray-500 line-clamp-2 mb-3 leading-relaxed">
                <?= htmlspecialchars($masjid['alamat'] ?? 'Alamat masjid tidak tersedia') ?>
            </p>
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-gray-50 text-xs text-gray-400">
            <span class="inline-flex items-center gap-1.5 text-gray-500">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <?= !empty($masjid['kapasitas']) ? number_format((int)$masjid['kapasitas'], 0, ',', '.') . ' Jamaah' : 'Kapasitas Besar' ?>
            </span>
            <span class="font-semibold text-emerald-600 group-hover:translate-x-1 transition-transform inline-flex items-center gap-0.5">
                Detail →
            </span>
        </div>
    </div>
</a>
