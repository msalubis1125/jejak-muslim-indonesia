<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                Pusat Kendali Platform
            </span>
            <span class="text-xs text-gray-400 font-medium">&bull; Identitas Global</span>
        </div>
        <h2 class="font-['Poppins'] font-bold text-xl sm:text-2xl text-gray-900 tracking-tight">Profil Platform Jejak Muslim Indonesia</h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola nama resmi, tagline, visi tentang kami, kontak sekretariat, dan media sosial portal.</p>
    </div>
    <div>
        <a href="<?= BASE_URL ?>/" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-xs sm:text-sm font-semibold transition shadow-sm">
            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            <span>Lihat Website Publik</span>
        </a>
    </div>
</div>

<form action="<?= BASE_URL ?>/admin/superadmin/profil/update" method="POST" class="space-y-6">
    <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">

    <!-- 1. Identitas Utama & Tagline -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            1. Identitas Utama Platform
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Platform Digital <span class="text-rose-500">*</span></label>
                <input type="text" name="app_name" value="<?= htmlspecialchars($profile['app_name'] ?? 'Jejak Muslim Indonesia') ?>" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <span class="text-[11px] text-gray-400 mt-1 block">Tampil pada title bar browser, kop laporan, dan header portal.</span>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tagline Resmi Platform</label>
                <input type="text" name="app_tagline" value="<?= htmlspecialchars($profile['app_tagline'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                <span class="text-[11px] text-gray-400 mt-1 block">Contoh: Pusat Ekosistem Digital Masjid Nusantara</span>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Deskripsi Visi & "Tentang Kami"</label>
                <textarea name="app_about" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none"><?= htmlspecialchars($profile['app_about'] ?? '') ?></textarea>
                <span class="text-[11px] text-gray-400 mt-1 block">Penjelasan resmi fungsi dan misi Jejak Muslim Indonesia bagi umat dan takmir.</span>
            </div>
        </div>
    </div>

    <!-- 2. Kontak & Sekretariat Nasional -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            2. Kontak Pusat & Layanan Bantuan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Resmi</label>
                <input type="email" name="app_email" value="<?= htmlspecialchars($profile['app_email'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Telepon CS / Helpdesk</label>
                <input type="text" name="app_phone" value="<?= htmlspecialchars($profile['app_phone'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Link WhatsApp Center</label>
                <input type="text" name="app_whatsapp" value="<?= htmlspecialchars($profile['app_whatsapp'] ?? '') ?>" placeholder="https://wa.me/62..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alamat Kantor / Sekretariat Nasional</label>
                <input type="text" name="app_address" value="<?= htmlspecialchars($profile['app_address'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>
    </div>

    <!-- 3. Tautan Media Sosial Platform -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100">
        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            3. Media Sosial Resmi Platform
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Instagram</label>
                <input type="text" name="app_instagram" value="<?= htmlspecialchars($profile['app_instagram'] ?? '') ?>" placeholder="https://instagram.com/..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">YouTube</label>
                <input type="text" name="app_youtube" value="<?= htmlspecialchars($profile['app_youtube'] ?? '') ?>" placeholder="https://youtube.com/@..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Facebook</label>
                <input type="text" name="app_facebook" value="<?= htmlspecialchars($profile['app_facebook'] ?? '') ?>" placeholder="https://facebook.com/..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
        </div>
    </div>

    <!-- Simpan Button -->
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="<?= BASE_URL ?>/admin/dashboard" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-semibold transition">
            Batal
        </a>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold shadow-sm hover:shadow transition">
            Simpan Perubahan Profil Platform
        </button>
    </div>
</form>
