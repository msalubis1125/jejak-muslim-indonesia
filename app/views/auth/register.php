<h2 class="text-xl font-['Poppins'] font-semibold text-center mb-2">Pendaftaran Takmir</h2>
<p class="text-sm text-center text-gray-500 mb-6">Akun Anda akan diverifikasi oleh admin sebelum dapat digunakan.</p>
<form action="<?= BASE_URL ?>/auth/register" method="POST" class="space-y-6">
    <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?? '' ?>">
    
    <!-- Section 1: Data Akun -->
    <div class="space-y-4">
        <h3 class="font-medium text-gray-900 border-b pb-2">Data Akun</h3>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No HP / WhatsApp</label>
            <input type="tel" name="no_hp" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="konfirmasi_password" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
    </div>

    <!-- Section 2: Data Masjid -->
    <div class="space-y-4">
        <h3 class="font-medium text-gray-900 border-b pb-2">Data Masjid</h3>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Masjid</label>
            <input type="text" name="nama_masjid" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
            <textarea name="alamat" required rows="2" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                <input type="text" name="kota" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                <input type="text" name="provinsi" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>
    </div>

    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl min-h-[44px] transition">Daftar & Ajukan Verifikasi</button>
</form>
<p class="mt-6 text-center text-sm text-gray-600">
    Sudah punya akun? <a href="<?= BASE_URL ?>/auth/login" class="font-medium text-emerald-600 hover:text-emerald-500">Masuk</a>
</p>
