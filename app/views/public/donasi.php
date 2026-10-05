<?php
$rekeningList = $data['rekening_list'] ?? ($data['rekening'] ?? []);
$selectedMasjid = $data['masjid'] ?? null;
$qrisImage = $data['qris'] ?? null;
?>

<div class="max-w-4xl mx-auto py-2">
    <div class="mb-8">
        <h1 class="font-heading font-bold text-2xl sm:text-3xl text-gray-900">Infaq & Donasi Masjid</h1>
        <p class="text-sm text-gray-500 mt-1">Salurkan infaq, sedekah jariyah, dan zakat Anda langsung ke rekening resmi pengurus masjid.</p>
    </div>

    <!-- Motivational Callout Card -->
    <div class="bg-gradient-to-r from-emerald-700 to-emerald-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg mb-8 relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-emerald-500/20 rounded-full blur-2xl"></div>
        <div class="relative z-10 max-w-xl">
            <span class="text-xs font-semibold bg-white/15 px-3 py-1 rounded-full text-emerald-200">Sedekah Jariyah</span>
            <p class="font-heading font-medium text-base sm:text-lg text-emerald-50 mt-3 leading-relaxed">
                "Perumpamaan orang yang menafkahkan hartanya di jalan Allah adalah serupa dengan sebutir benih yang menumbuhkan tujuh bulir, pada tiap-tiap bulir seratus biji."
            </p>
            <p class="text-xs text-emerald-300 mt-2 font-semibold">— QS. Al-Baqarah: 261</p>
        </div>
    </div>

    <!-- Rekening List by Mosque -->
    <h2 class="font-heading font-bold text-xl text-gray-900 mb-4">Daftar Rekening Resmi Pengurus</h2>
    
    <?php if (empty($rekeningList)): ?>
        <div class="bg-white rounded-2xl p-10 text-center border border-gray-100 shadow-sm text-gray-400">
            Belum ada rekening aktif yang terdaftar.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
            <?php foreach ($rekeningList as $rek): ?>
                <div class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-100">
                                <?= htmlspecialchars($rek['nama_bank']) ?>
                            </span>
                            <?php if (!empty($rek['masjid_nama'])): ?>
                                <span class="text-xs font-medium text-gray-400 truncate max-w-[150px]">
                                    <?= htmlspecialchars($rek['masjid_nama']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="font-mono text-2xl font-bold text-gray-900 tracking-wider mb-1 select-all">
                            <?= htmlspecialchars($rek['no_rekening']) ?>
                        </div>
                        <div class="text-xs text-gray-500">
                            Atas Nama: <strong class="text-gray-700"><?= htmlspecialchars($rek['atas_nama']) ?></strong>
                        </div>
                    </div>

                    <div class="pt-5 mt-5 border-t border-gray-100 flex items-center justify-between">
                        <button onclick="copyRekening('<?= htmlspecialchars($rek['no_rekening']) ?>', this)" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold py-2 px-4 rounded-xl transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg>
                            <span>Salin Nomor</span>
                        </button>

                        <?php if (!empty($rek['masjid_slug'])): ?>
                            <a href="<?= BASE_URL ?>/masjid/<?= $rek['masjid_slug'] ?>" class="text-xs font-medium text-emerald-600 hover:underline">
                                Profil Masjid →
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- QRIS Donasi Operasional & Pengembangan Website (Dikelola oleh Super Admin) -->
    <?php
    $qrisWeb = $data['qris_website'] ?? ($qris_website ?? null);
    if ($qrisWeb && !empty($qrisWeb['is_active'])):
    ?>
    <div class="bg-gradient-to-b from-white to-emerald-50/40 rounded-3xl p-6 sm:p-8 border border-emerald-200/80 shadow-md text-center max-w-lg mx-auto relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-emerald-100/50 rounded-full blur-2xl pointer-events-none"></div>

        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold mb-3 shadow-sm border border-emerald-200/60">
            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>Donasi & Infaq Pengembangan Website</span>
        </div>

        <h3 class="font-heading font-bold text-lg sm:text-xl text-gray-900 mb-2 leading-snug">
            <?= htmlspecialchars($qrisWeb['title'] ?? 'Infaq & Donasi Pengembangan Website') ?>
        </h3>

        <p class="text-xs sm:text-sm text-gray-600 mb-5 leading-relaxed max-w-md mx-auto">
            <?= htmlspecialchars($qrisWeb['desc'] ?? 'Dukung pemeliharaan server, integrasi peta GIS, dan digitalisasi masjid di seluruh Indonesia.') ?>
        </p>

        <div class="inline-block p-4 bg-white border-2 border-emerald-100 rounded-2xl shadow-sm mb-3 group relative hover:border-emerald-300 transition">
            <img src="<?= htmlspecialchars($qrisWeb['image']) ?>" alt="QRIS Donasi Website" class="w-48 h-48 sm:w-52 sm:h-52 object-contain mx-auto">
        </div>

        <div class="text-xs sm:text-sm font-bold text-gray-800 mb-1">
            a.n <span class="text-emerald-700"><?= htmlspecialchars($qrisWeb['atas_nama'] ?? 'Jejak Muslim Indonesia') ?></span>
        </div>

        <p class="text-[11px] text-gray-400 mt-2 max-w-sm mx-auto leading-relaxed border-t border-emerald-100/60 pt-3">
            <?= htmlspecialchars($qrisWeb['footer'] ?? 'Setiap rupiah donasi Anda menjadi amal jariyah untuk kemajuan dakwah dan kemakmuran masjid digital.') ?>
        </p>
    </div>
    <?php endif; ?>
</div>

<script>
function copyRekening(text, btn) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span>Tersalin! ✓</span>';
            btn.classList.remove('bg-emerald-600');
            btn.classList.add('bg-emerald-800');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-emerald-800');
                btn.classList.add('bg-emerald-600');
            }, 2000);
        });
    }
}
</script>
