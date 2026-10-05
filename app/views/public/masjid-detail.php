<?php 
$masjid = $data['masjid'] ?? ($masjid ?? []); 
$fasilitas = $data['fasilitas'] ?? ($fasilitas ?? []);
$events = $data['upcoming_events'] ?? ($upcoming_events ?? []);
$keuangan = $data['keuangan_summary'] ?? ($keuangan_summary ?? []);
$rekeningList = $data['rekening'] ?? ($rekening ?? []);
$qris = $data['qris'] ?? null;

$mapsUrl = "https://www.google.com/maps/dir/?api=1&destination=" . ($masjid['latitude'] ?? '0') . "," . ($masjid['longitude'] ?? '0');
$waPhone = preg_replace('/[^0-9]/', '', $masjid['no_hp_takmir'] ?? '');
if (str_starts_with($waPhone, '0')) {
    $waPhone = '62' . substr($waPhone, 1);
}
$waUrl = !empty($masjid['wa_link']) ? $masjid['wa_link'] : "https://wa.me/{$waPhone}?text=" . urlencode("Assalamu'alaikum Pengurus " . ($masjid['nama'] ?? ''));
?>

<div class="max-w-4xl mx-auto py-1 sm:py-2 w-full min-w-0 overflow-hidden">
    <!-- Hero Cover & Header -->
    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-md h-52 sm:h-80 md:h-96 bg-gray-900 w-full">
        <img src="<?= htmlspecialchars($masjid['foto_utama'] ?? BASE_URL.'/public/img/placeholder.svg') ?>" alt="<?= htmlspecialchars($masjid['nama'] ?? 'Masjid') ?>" class="w-full h-full object-cover opacity-90">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>

        <!-- Top Controls -->
        <div class="absolute top-3 sm:top-4 left-3 sm:left-4 right-3 sm:right-4 flex items-center justify-between z-10">
            <a href="<?= BASE_URL ?>/masjid" class="w-9 h-9 sm:w-10 sm:h-10 bg-white/85 hover:bg-white backdrop-blur-md rounded-xl sm:rounded-2xl flex items-center justify-center text-gray-800 shadow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <?php if (!empty($masjid['buka_24jam'])): ?>
                    <span class="text-[10px] sm:text-xs font-bold bg-emerald-600 text-white px-2.5 py-1 rounded-full shadow">Buka 24 Jam</span>
                <?php endif; ?>
                <span class="text-[10px] sm:text-xs font-semibold bg-white/90 text-gray-800 px-2.5 py-1 rounded-full shadow truncate max-w-[120px] sm:max-w-none"><?= htmlspecialchars($masjid['kota'] ?? 'Indonesia') ?></span>
            </div>
        </div>

        <!-- Bottom Hero Text -->
        <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6 text-white z-10">
            <h1 class="font-heading font-extrabold text-xl sm:text-3xl md:text-4xl text-white tracking-tight leading-snug line-clamp-2">
                <?= htmlspecialchars($masjid['nama'] ?? 'Nama Masjid') ?>
            </h1>
            <p class="text-xs sm:text-sm text-gray-200 mt-1 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                <span class="truncate"><?= htmlspecialchars($masjid['alamat'] ?? 'Alamat masjid') ?></span>
            </p>
        </div>
    </div>

    <!-- Action Buttons Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 mt-3 sm:mt-4">
        <a href="<?= $mapsUrl ?>" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl sm:rounded-2xl flex items-center justify-center gap-2 text-xs sm:text-sm shadow-sm transition">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            <span>Arahkan Navigasi (Google Maps)</span>
        </a>
        <a href="<?= $waUrl ?>" target="_blank" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold py-3 px-4 rounded-xl sm:rounded-2xl flex items-center justify-center gap-2 text-xs sm:text-sm transition border border-emerald-200/60">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.542 1.897.886 2.791.886 3.181 0 5.767-2.587 5.768-5.766.001-3.181-2.585-5.772-5.768-5.772zm3.385 8.156c-.145.407-.847.781-1.183.83-.336.05-.774.072-2.316-.566-1.843-.763-3.023-2.654-3.115-2.776-.092-.122-.743-.988-.743-1.884 0-.896.471-1.336.638-1.517.168-.181.367-.227.489-.227.122 0 .245.002.352.007.113.006.264-.043.413.315.153.367.52 1.27.566 1.362.046.092.077.2.015.321-.061.122-.092.199-.184.306-.092.107-.193.239-.276.321-.092.092-.187.191-.081.374.107.184.477.786 1.023 1.272.704.627 1.297.822 1.481.913.183.092.291.077.398-.046.107-.122.459-.535.581-.719.122-.183.245-.153.413-.092.168.061 1.07.505 1.254.596.183.092.306.138.352.214.046.077.046.444-.099.851z"/></svg>
            <span>Hubungi Takmir / Pengurus</span>
        </a>
    </div>

    <!-- Quick Stats Bar (Clean 2-col on mobile, 4-col on tablet/desktop) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 my-4 sm:my-6 bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-sm text-center">
        <div class="p-1 sm:p-2">
            <span class="text-[11px] sm:text-xs text-gray-400 block mb-0.5">Kapasitas</span>
            <span class="font-heading font-bold text-gray-800 text-sm sm:text-base md:text-lg block truncate"><?= number_format($masjid['kapasitas'] ?? 0) ?> Jamaah</span>
        </div>
        <div class="p-1 sm:p-2">
            <span class="text-[11px] sm:text-xs text-gray-400 block mb-0.5">Jeda Iqomah</span>
            <span class="font-heading font-bold text-gray-800 text-sm sm:text-base md:text-lg block"><?= $masjid['jeda_iqomah_menit'] ?? 10 ?> Menit</span>
        </div>
        <div class="p-1 sm:p-2">
            <span class="text-[11px] sm:text-xs text-gray-400 block mb-0.5">Operasional</span>
            <span class="font-heading font-bold text-emerald-600 text-sm sm:text-base md:text-lg block"><?= !empty($masjid['buka_24jam']) ? '24 Jam' : 'Waktu Shalat' ?></span>
        </div>
        <div class="p-1 sm:p-2">
            <span class="text-[11px] sm:text-xs text-gray-400 block mb-0.5">Verifikasi</span>
            <span class="font-heading font-bold text-emerald-700 text-sm sm:text-base md:text-lg block">Terverifikasi ✓</span>
        </div>
    </div>

    <!-- Interactive Navigation Tabs with Horizontal Scroll Support on Mobile -->
    <div class="border-b border-gray-200 mt-4 sm:mt-6 bg-white rounded-t-xl sm:rounded-t-2xl px-2 sm:px-3 overflow-hidden">
        <div class="flex gap-1 sm:gap-2 overflow-x-auto no-scrollbar scroll-smooth py-1 -mb-px">
            <button onclick="switchTab('info')" id="tab-btn-info" class="tab-btn shrink-0 whitespace-nowrap py-3 px-3 sm:px-5 text-xs sm:text-sm font-semibold text-emerald-600 border-b-2 border-emerald-600 transition">
                Profil & Fasilitas
            </button>
            <button onclick="switchTab('kegiatan')" id="tab-btn-kegiatan" class="tab-btn shrink-0 whitespace-nowrap py-3 px-3 sm:px-5 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                Agenda Kegiatan (<?= count($events) ?>)
            </button>
            <button onclick="switchTab('keuangan')" id="tab-btn-keuangan" class="tab-btn shrink-0 whitespace-nowrap py-3 px-3 sm:px-5 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                Transparansi Kas
            </button>
            <button onclick="switchTab('donasi')" id="tab-btn-donasi" class="tab-btn shrink-0 whitespace-nowrap py-3 px-3 sm:px-5 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                Infaq & Rekening
            </button>
        </div>
    </div>

    <!-- Tab Contents Container -->
    <div class="bg-white rounded-b-xl sm:rounded-b-2xl p-4 sm:p-6 shadow-sm border border-t-0 border-gray-100 mb-8 sm:mb-10 min-h-[260px] overflow-hidden">
        
        <!-- Tab 1: Info & Fasilitas -->
        <div id="tab-info" class="tab-content space-y-5 sm:space-y-6">
            <!-- Fasilitas -->
            <div>
                <h3 class="font-heading font-bold text-gray-900 text-sm sm:text-base mb-2.5">Fasilitas Jamaah</h3>
                <div class="flex flex-wrap gap-1.5 sm:gap-2">
                    <?php if (!empty($fasilitas)): ?>
                        <?php foreach ($fasilitas as $f): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-800 text-xs font-semibold rounded-xl border border-emerald-200/50">
                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                <span><?= htmlspecialchars($f) ?></span>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-xs text-gray-400">Fasilitas umum masjid tersedia lengkap.</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sejarah -->
            <div>
                <h3 class="font-heading font-bold text-gray-900 text-sm sm:text-base mb-2">Sejarah Masjid</h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                    <?= !empty($masjid['sejarah']) ? nl2br(htmlspecialchars($masjid['sejarah'])) : 'Informasi sejarah belum ditambahkan oleh pengurus masjid.' ?>
                </p>
            </div>

            <!-- Visi & Misi -->
            <?php if (!empty($masjid['visi_misi'])): ?>
            <div class="pt-4 border-t border-gray-100">
                <h3 class="font-heading font-bold text-gray-900 text-sm sm:text-base mb-2">Visi & Misi</h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                    <?= nl2br(htmlspecialchars($masjid['visi_misi'])) ?>
                </p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Tab 2: Agenda Kegiatan -->
        <div id="tab-kegiatan" class="tab-content hidden space-y-4">
            <h3 class="font-heading font-bold text-gray-900 text-sm sm:text-base mb-2">Agenda & Kajian Masjid</h3>
            <?php if (empty($events)): ?>
                <div class="text-center py-10 text-gray-400">
                    <p class="text-xs sm:text-sm">Belum ada jadwal kegiatan mendatang untuk masjid ini.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                    <?php foreach ($events as $keg): ?>
                        <div class="p-3.5 sm:p-4 bg-gray-50 rounded-2xl border border-gray-100 flex gap-3 sm:gap-4 items-start">
                            <img src="<?= htmlspecialchars($keg['poster'] ?? BASE_URL.'/public/img/placeholder.svg') ?>" class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-heading font-bold text-xs sm:text-sm text-gray-900 line-clamp-1"><?= htmlspecialchars($keg['judul']) ?></h4>
                                <p class="text-[11px] sm:text-xs text-gray-500 mt-1"><?= date('d M Y', strtotime($keg['tanggal_mulai'])) ?> • <?= substr($keg['jam_mulai'], 0, 5) ?> WIB</p>
                                <a href="<?= BASE_URL ?>/kegiatan/<?= $keg['id'] ?>" class="inline-block text-xs font-semibold text-emerald-600 hover:text-emerald-700 mt-1.5 sm:mt-2">Lihat Detail →</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tab 3: Transparansi Keuangan -->
        <div id="tab-keuangan" class="tab-content hidden space-y-5 sm:space-y-6">
            <div>
                <h3 class="font-heading font-bold text-gray-900 text-sm sm:text-base">Transparansi Laporan Kas</h3>
                <p class="text-xs text-gray-500 mt-0.5">Laporan pemasukan infaq dan pengeluaran operasional masjid</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                <div class="bg-emerald-50 rounded-xl sm:rounded-2xl p-4 border border-emerald-100">
                    <span class="text-xs text-emerald-700 font-semibold block">Total Pemasukan</span>
                    <span class="font-heading font-bold text-emerald-800 text-base sm:text-xl mt-1 block font-mono">
                        Rp <?= number_format($keuangan['total_masuk'] ?? 0, 0, ',', '.') ?>
                    </span>
                </div>
                <div class="bg-red-50 rounded-xl sm:rounded-2xl p-4 border border-red-100">
                    <span class="text-xs text-red-700 font-semibold block">Total Pengeluaran</span>
                    <span class="font-heading font-bold text-red-800 text-base sm:text-xl mt-1 block font-mono">
                        Rp <?= number_format($keuangan['total_keluar'] ?? 0, 0, ',', '.') ?>
                    </span>
                </div>
                <div class="bg-blue-50 rounded-xl sm:rounded-2xl p-4 border border-blue-100">
                    <span class="text-xs text-blue-700 font-semibold block">Saldo Kas Terkini</span>
                    <span class="font-heading font-bold text-blue-800 text-base sm:text-xl mt-1 block font-mono">
                        Rp <?= number_format($keuangan['saldo'] ?? 0, 0, ',', '.') ?>
                    </span>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-3.5 text-center text-xs text-gray-500">
                Laporan ini diperbarui secara berkala oleh Bendahara Takmir Masjid untuk menjaga amanah jamaah.
            </div>
        </div>

        <!-- Tab 4: Infaq & Rekening -->
        <div id="tab-donasi" class="tab-content hidden space-y-5 sm:space-y-6">
            <div>
                <h3 class="font-heading font-bold text-gray-900 text-sm sm:text-base mb-1">Rekening Infaq & Sedekah</h3>
                <p class="text-xs text-gray-500 mb-4">Salurkan donasi Anda langsung ke rekening resmi pengurus masjid.</p>

                <?php if (empty($rekeningList)): ?>
                    <div class="p-6 bg-gray-50 rounded-xl text-center">
                        <p class="text-xs sm:text-sm text-gray-400">Nomor rekening belum didaftarkan oleh pengurus masjid ini.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <?php foreach ($rekeningList as $rek): ?>
                            <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-4 sm:p-5 border border-gray-200/80 relative">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-heading font-bold text-emerald-800 text-xs sm:text-sm"><?= htmlspecialchars($rek['nama_bank'] ?? 'Bank') ?></span>
                                    <button onclick="copyToClipboard('<?= htmlspecialchars($rek['no_rekening']) ?>', this)" class="text-xs font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 px-2.5 py-1 rounded-lg transition">
                                        Salin
                                    </button>
                                </div>
                                <div class="font-mono font-bold text-gray-900 text-base sm:text-lg tracking-wider break-all mb-1"><?= htmlspecialchars($rek['no_rekening']) ?></div>
                                <div class="text-xs text-gray-500 truncate">a.n <?= htmlspecialchars($rek['atas_nama']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- QRIS -->
            <?php if (!empty($qris)): ?>
                <div class="pt-5 border-t border-gray-100 text-center">
                    <h4 class="font-heading font-bold text-gray-900 text-xs sm:text-sm mb-2">Pembayaran Melalui QRIS</h4>
                    <div class="inline-block p-3 sm:p-4 bg-white border border-gray-200 rounded-2xl shadow-sm max-w-[220px]">
                        <img src="<?= htmlspecialchars($qris) ?>" alt="QRIS" class="w-40 h-40 sm:w-48 sm:h-48 object-contain mx-auto">
                    </div>
                    <p class="text-[11px] text-gray-400 mt-2">Dapat dipindai melalui BCA, Mandiri, BSI, GoPay, OVO, ShopeePay, dll.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('text-emerald-600', 'border-b-2', 'border-emerald-600', 'font-semibold');
        el.classList.add('text-gray-500', 'font-medium');
    });

    const activeContent = document.getElementById('tab-' + tabId);
    const activeBtn = document.getElementById('tab-btn-' + tabId);

    if (activeContent) activeContent.classList.remove('hidden');
    if (activeBtn) {
        activeBtn.classList.remove('text-gray-500', 'font-medium');
        activeBtn.classList.add('text-emerald-600', 'border-b-2', 'border-emerald-600', 'font-semibold');
    }
}

function copyToClipboard(text, btn) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = btn.textContent;
            btn.textContent = 'Tersalin! ✓';
            btn.classList.add('bg-emerald-600', 'text-white');
            setTimeout(() => {
                btn.textContent = orig;
                btn.classList.remove('bg-emerald-600', 'text-white');
            }, 2000);
        });
    }
}
</script>
