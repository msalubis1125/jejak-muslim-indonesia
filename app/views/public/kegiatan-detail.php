<?php 
$kegiatan = $data['kegiatan'] ?? ($kegiatan ?? []); 
$pendaftarCount = $this->model('PendaftaranModel')->countByKegiatan($kegiatan['id'] ?? 0);
$kuota = (int)($kegiatan['kuota'] ?? 0);
$sisaKuota = $kuota > 0 ? max(0, $kuota - $pendaftarCount) : null;
?>

<div class="max-w-3xl mx-auto py-4">
    <!-- Back Button -->
    <a href="<?= BASE_URL ?>/kegiatan" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3.5 py-2 rounded-xl transition mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali ke Daftar Kegiatan</span>
    </a>

    <!-- Poster Header -->
    <div class="relative w-full h-64 sm:h-80 md:h-96 rounded-3xl overflow-hidden shadow-md bg-gray-900 mb-6">
        <img src="<?= htmlspecialchars($kegiatan['poster'] ?? BASE_URL.'/public/img/placeholder.svg') ?>" class="w-full h-full object-cover opacity-90">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

        <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
            <span class="text-xs font-semibold bg-emerald-600 text-white px-3 py-1 rounded-full shadow">
                Kajian & Kegiatan
            </span>
            <?php if (!empty($kegiatan['perlu_daftar'])): ?>
                <span class="text-xs font-bold bg-amber-500 text-white px-3 py-1 rounded-full shadow">
                    Wajib Registrasi
                </span>
            <?php else: ?>
                <span class="text-xs font-bold bg-white/90 text-gray-800 px-3 py-1 rounded-full shadow">
                    Terbuka untuk Umum
                </span>
            <?php endif; ?>
        </div>

        <div class="absolute bottom-6 left-6 right-6 text-white">
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight leading-tight">
                <?= htmlspecialchars($kegiatan['judul'] ?? 'Judul Kegiatan') ?>
            </h1>
            <p class="text-xs sm:text-sm text-emerald-300 mt-1">
                <?= htmlspecialchars($kegiatan['masjid_nama'] ?? 'Masjid Penyelenggara') ?>
            </p>
        </div>
    </div>

    <!-- Quick Info Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <span class="text-xs text-gray-400 block">Waktu Pelaksanaan</span>
                <span class="font-heading font-semibold text-gray-800 text-sm">
                    <?= date('l, d F Y', strtotime($kegiatan['tanggal_mulai'] ?? 'now')) ?>
                </span>
                <span class="text-xs text-emerald-600 block mt-0.5">
                    <?= substr($kegiatan['jam_mulai'] ?? '00:00', 0, 5) ?> - <?= substr($kegiatan['jam_selesai'] ?? '00:00', 0, 5) ?> WIB
                </span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs text-gray-400 block">Lokasi Detail</span>
                <span class="font-heading font-semibold text-gray-800 text-sm">
                    <?= htmlspecialchars($kegiatan['lokasi_detail'] ?? ($kegiatan['masjid_nama'] ?? 'Area Masjid')) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 mb-8">
        <h3 class="font-heading font-bold text-gray-900 text-lg mb-3">Tentang Kegiatan Ini</h3>
        <div class="text-gray-600 text-sm leading-relaxed space-y-3">
            <?= nl2br(htmlspecialchars($kegiatan['deskripsi'] ?? 'Deskripsi belum ditambahkan.')) ?>
        </div>
    </div>

    <!-- Registration Section -->
    <?php if (!empty($kegiatan['perlu_daftar'])): ?>
        <div class="bg-gradient-to-br from-emerald-50 to-white rounded-3xl p-6 sm:p-8 border border-emerald-200/80 shadow-sm mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6 pb-4 border-b border-emerald-100">
                <div>
                    <h3 class="font-heading font-bold text-gray-900 text-lg">Formulir Pendaftaran Peserta</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Daftarkan diri Anda untuk kepastian tempat duduk dan konsumsi majelis.</p>
                </div>
                <?php if ($kuota > 0): ?>
                    <div class="inline-flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-full border border-emerald-200 text-xs font-semibold text-emerald-800 self-start">
                        <span>Sisa Kuota:</span>
                        <span class="font-bold text-emerald-600"><?= $sisaKuota ?> dari <?= $kuota ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($kuota > 0 && $sisaKuota <= 0): ?>
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-center text-amber-800 text-sm font-semibold">
                    Mohon maaf, kuota pendaftaran untuk kegiatan ini sudah penuh.
                </div>
            <?php else: ?>
                <form action="<?= BASE_URL ?>/kegiatan/daftar/<?= $kegiatan['id'] ?>" method="POST" class="space-y-4 max-w-lg">
                    <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                    <input type="hidden" name="kegiatan_id" value="<?= $kegiatan['id'] ?>">

                    <div>
                        <label for="nama" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap Jamaah</label>
                        <input type="text" id="nama" name="nama" required placeholder="Contoh: Abdullah" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm text-gray-800">
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-semibold text-gray-700 mb-1.5">Nomor WhatsApp Aktif</label>
                        <input type="tel" id="no_hp" name="no_hp" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm text-gray-800">
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl text-sm shadow-sm transition">
                        Konfirmasi Pendaftaran
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Share Button -->
    <div class="text-center">
        <button onclick="if(navigator.share){navigator.share({title:'<?= htmlspecialchars(addslashes($kegiatan['judul'] ?? '')) ?>',url:window.location.href})}else{navigator.clipboard.writeText(window.location.href);alert('Tautan disalin!')}" class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-semibold py-2.5 px-6 rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-5.368m0 5.368l5.667 3.111a3 3 0 100-5.368m-5.667-3.111l5.667-3.111a3 3 0 110 5.368"></path></svg>
            Bagikan Jadwal Kajian Ini
        </button>
    </div>
</div>
