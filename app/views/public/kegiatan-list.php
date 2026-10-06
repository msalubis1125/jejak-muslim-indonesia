<div class="py-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-heading font-bold text-2xl sm:text-3xl text-gray-900">Jadwal Kajian & Kegiatan Masjid</h1>
            <p class="text-sm text-gray-500 mt-1">Ikuti majelis taklim, kajian sunnah, dan kegiatan sosial umat Islam di berbagai masjid.</p>
        </div>
    </div>

    <!-- Event Grid: 1 col mobile, 2 col tablet, 3 col desktop -->
    <?php 
    $kegiatans = $data['kegiatan_list'] ?? ($data['kegiatans'] ?? ($kegiatan_list ?? []));
    if (empty($kegiatans)): ?>
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-md mx-auto">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="font-heading font-semibold text-gray-800 text-lg mb-1">Belum Ada Kegiatan</h3>
            <p class="text-sm text-gray-500">Jadwal kegiatan atau kajian yang dipublikasikan oleh takmir masjid akan tampil di sini.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($kegiatans as $keg): ?>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            <?php 
                                $kegPoster = !empty($keg['poster']) 
                                    ? ((strpos($keg['poster'], 'http') === 0) ? $keg['poster'] : BASE_URL . '/public/uploads/kegiatan/' . $keg['poster']) 
                                    : BASE_URL . '/public/img/placeholder.svg';
                            ?>
                            <img src="<?= htmlspecialchars($kegPoster) ?>" alt="<?= htmlspecialchars($keg['judul']) ?>" class="w-full h-full object-cover">
                            <div class="absolute top-3 left-3">
                                <span class="text-xs font-semibold bg-white/95 backdrop-blur-md text-emerald-800 px-2.5 py-1 rounded-lg shadow-sm">
                                    <?= htmlspecialchars($keg['masjid_nama'] ?? 'Masjid') ?>
                                </span>
                            </div>
                            <?php if (!empty($keg['perlu_daftar'])): ?>
                                <div class="absolute top-3 right-3">
                                    <span class="text-[10px] font-bold bg-amber-500 text-white px-2.5 py-1 rounded-full shadow-sm">
                                        Wajib Daftar
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-5">
                            <h3 class="font-heading font-bold text-gray-900 text-base line-clamp-2 leading-snug">
                                <?= htmlspecialchars($keg['judul']) ?>
                            </h3>
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                                <?= htmlspecialchars($keg['deskripsi'] ?? '') ?>
                            </p>

                            <div class="space-y-1.5 mt-4 text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                    <span><?= date('l, d F Y', strtotime($keg['tanggal_mulai'])) ?></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    <span><?= substr($keg['jam_mulai'], 0, 5) ?> - <?= substr($keg['jam_selesai'], 0, 5) ?> WIB</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                    <span class="truncate"><?= htmlspecialchars($keg['lokasi_detail'] ?? ($keg['masjid_nama'] ?? 'Lokasi')) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <a href="<?= BASE_URL ?>/kegiatan/<?= $keg['id'] ?>" class="block w-full text-center bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white font-semibold py-2.5 rounded-xl text-xs transition">
                            Lihat Detail & Pendaftaran →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
