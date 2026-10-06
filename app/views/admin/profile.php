<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-xl sm:text-2xl font-['Poppins'] font-bold text-gray-800">Pengaturan Profil & Keamanan Akun</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola data identitas pengurus dan perbarui kata sandi login Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card 1: Data Identitas Diri -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-7">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Informasi Akun</h2>
                    <p class="text-xs text-gray-400">Data pribadi pengurus yang terdaftar</p>
                </div>
            </div>

            <form action="<?= BASE_URL ?>/profile/update" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" required value="<?= htmlspecialchars($user['nama'] ?? '') ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" name="email" required value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp / HP</label>
                    <input type="text" name="no_hp" value="<?= htmlspecialchars($user['no_hp'] ?? '') ?>" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Peran Sistem (Role)</label>
                    <div class="px-4 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-xs font-medium text-gray-600">
                        <?= ($user['role'] === 'super_admin') ? 'Super Administrator Pusat' : 'Takmir Pengurus Masjid' ?>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 rounded-xl text-sm shadow-sm transition">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 2: Keamanan & Ganti Password -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-7">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Ganti Password</h2>
                    <p class="text-xs text-gray-400">Pastikan gunakan kata sandi yang kuat dan aman</p>
                </div>
            </div>

            <form action="<?= BASE_URL ?>/profile/updatePassword" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Password Lama</label>
                    <input type="password" name="password_lama" required placeholder="Masukkan password saat ini" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Password Baru</label>
                    <input type="password" name="password_baru" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Ulangi Password Baru</label>
                    <input type="password" name="konfirmasi_password" required placeholder="Ketik ulang password baru" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-medium py-2.5 rounded-xl text-sm shadow-sm transition">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
