<h2 class="text-xl font-['Poppins'] font-semibold text-center mb-6">Masuk ke Akun Anda</h2>
<form action="<?= BASE_URL ?>/auth/login" method="POST" class="space-y-4">
    <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?? '' ?>">
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" placeholder="Masukkan email">
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" id="password" name="password" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" placeholder="Masukkan password">
    </div>
    <div class="flex items-center justify-between">
        <label class="flex items-center">
            <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
        </label>
        <a href="<?= BASE_URL ?>/auth/forgot-password" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">Lupa Password?</a>
    </div>
    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl min-h-[44px] transition">Masuk</button>
</form>
<p class="mt-6 text-center text-sm text-gray-600">
    Belum punya akun? <a href="<?= BASE_URL ?>/auth/register" class="font-medium text-emerald-600 hover:text-emerald-500">Daftar sebagai Takmir</a>
</p>
