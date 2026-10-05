<div class="mb-6">
    <h2 class="font-['Poppins'] font-semibold text-xl text-gray-800">Pengaturan Donasi</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Rekening Bank -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Rekening Bank</h3>
        <ul class="space-y-3 mb-6">
            <li class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex justify-between items-center">
                <div>
                    <div class="font-semibold text-blue-800">BSI (Bank Syariah Indonesia)</div>
                    <div class="font-mono text-gray-800 tracking-wider">7123 4567 89</div>
                    <div class="text-xs text-gray-500">a.n Masjid Agung</div>
                </div>
                <button class="text-red-500 hover:text-red-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
            </li>
        </ul>
        <form class="border-t pt-4 space-y-3">
            <h4 class="text-sm font-medium text-gray-700">Tambah Rekening</h4>
            <input type="text" placeholder="Nama Bank (misal: BSI, Muamalat)" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm outline-none">
            <input type="text" placeholder="Nomor Rekening" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm outline-none">
            <input type="text" placeholder="Atas Nama" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm outline-none">
            <button type="submit" class="w-full bg-emerald-600 text-white font-medium py-2 rounded-xl text-sm">Tambah Rekening</button>
        </form>
    </div>

    <!-- QRIS -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-4">QRIS</h3>
        <div class="bg-gray-50 border border-gray-200 border-dashed rounded-xl p-6 text-center mb-4">
            <div class="w-48 h-48 bg-white border border-gray-200 mx-auto mb-3 flex items-center justify-center rounded-xl shadow-sm">
                <span class="text-gray-400 text-sm">Belum ada QRIS</span>
            </div>
            <button class="text-red-500 text-sm font-medium hover:text-red-600">Hapus QRIS</button>
        </div>
        <form class="border-t pt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Upload QRIS Baru</h4>
            <input type="file" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm outline-none mb-3">
            <button type="submit" class="w-full bg-emerald-600 text-white font-medium py-2 rounded-xl text-sm">Simpan QRIS</button>
        </form>
    </div>
</div>
