<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="font-['Poppins'] font-bold text-xl text-gray-800">Semua Data Masjid Terdaftar</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar lengkap seluruh masjid di ekosistem Jejak Muslim Indonesia.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 rounded-xl text-sm font-medium hover:bg-amber-100 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Lihat Antrean Verifikasi
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" id="searchInput" onkeyup="filterMasjidTable()" placeholder="Cari nama masjid atau kota..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none">
        </div>
        <div class="text-xs text-gray-500">
            Total: <span class="font-semibold text-gray-800"><?= count($masjid_list ?? []) ?></span> Masjid
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm" id="masjidTable">
            <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                <tr>
                    <th class="py-4 px-6 font-semibold">Nama Masjid</th>
                    <th class="py-4 px-6 font-semibold">Kota / Wilayah</th>
                    <th class="py-4 px-6 font-semibold">Kapasitas</th>
                    <th class="py-4 px-6 font-semibold text-center">Status</th>
                    <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                <?php if (empty($masjid_list)): ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400">Belum ada data masjid yang terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($masjid_list as $m): ?>
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800"><?= htmlspecialchars($m['nama']) ?></div>
                                <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($m['alamat'] ?? '-') ?></div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 text-gray-600">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <?= htmlspecialchars($m['kota'] ?? 'Indonesia') ?>
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <?= !empty($m['kapasitas']) ? number_format($m['kapasitas']) . ' jamaah' : '-' ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <?php if ($m['status'] === 'verified'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Verified
                                    </span>
                                <?php elseif ($m['status'] === 'pending'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        Menunggu
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                        Ditangguhkan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= BASE_URL ?>/masjid/<?= htmlspecialchars($m['slug']) ?>" target="_blank" class="p-1.5 text-gray-500 hover:text-primary-600 hover:bg-gray-100 rounded-lg transition" title="Lihat Halaman Publik">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <?php if ($m['status'] !== 'suspended'): ?>
                                        <form action="<?= BASE_URL ?>/admin/superadmin/masjidverif/suspend/<?= $m['id'] ?>" method="POST" onsubmit="return confirm('Tangguhkan akses masjid ini?');" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition" title="Tangguhkan Masjid">
                                                Tangguhkan
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?= BASE_URL ?>/admin/superadmin/masjidverif/verify/<?= $m['id'] ?>" method="POST" onsubmit="return confirm('Aktifkan kembali masjid ini?');" class="inline">
                                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                                            <button type="submit" class="px-2.5 py-1 text-xs font-medium text-emerald-600 hover:bg-emerald-50 rounded-lg border border-emerald-200 transition" title="Aktifkan Masjid">
                                                Aktifkan
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterMasjidTable() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("masjidTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var tdNama = tr[i].getElementsByTagName("td")[0];
        var tdKota = tr[i].getElementsByTagName("td")[1];
        if (tdNama || tdKota) {
            var txtValue = (tdNama ? tdNama.textContent : '') + ' ' + (tdKota ? tdKota.textContent : '');
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
