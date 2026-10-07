<?php
$isSuperAdmin = !empty($is_super_admin);
?>

<div class="space-y-4 sm:space-y-6">
    <?php if ($isSuperAdmin): ?>
        <!-- SUPER ADMIN DASHBOARD HEADER (Precision Bento Banner) -->
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-6 sm:p-7 rounded-2xl shadow-sm border border-slate-800 text-white">
            <!-- Subtle geometric glow -->
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-32 -bottom-16 w-48 h-48 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                            Pusat Kendali Nasional
                        </span>
                        <span class="text-xs text-slate-400 font-medium">&bull; Administrator Platform</span>
                    </div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Pusat Kendali Jejak Muslim Indonesia</h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">Pemantauan ekosistem digital masjid nusantara, tata kelola data takmir, dan verifikasi legalitas publik</p>
                </div>
                <div class="flex items-center gap-2.5 sm:gap-3 flex-wrap sm:flex-nowrap">
                    <?php if (($pending_verifikasi ?? 0) > 0): ?>
                        <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-semibold py-2.5 px-4 sm:px-5 rounded-xl shadow-sm transition whitespace-nowrap animate-pulse">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            <span>Verifikasi Masjid (<?= $pending_verifikasi ?> Perlu Ditinjau)</span>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="inline-flex items-center gap-2 bg-slate-800/80 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs sm:text-sm font-semibold py-2.5 px-4 sm:px-5 rounded-xl transition whitespace-nowrap">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Semua Terverifikasi (0)</span>
                        </a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/admin/superadmin/users" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold py-2.5 px-4 sm:px-5 rounded-xl shadow-sm transition whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <span>Kelola Pengguna</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Cards: 5 Precision Bento Grid (Stripe Precision) -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3.5 sm:gap-4">
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/80 hover:border-indigo-300 hover:shadow-sm transition-all duration-200 flex items-center justify-between group">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Masjid</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1 font-mono"><?= number_format($total_masjid ?? 0) ?></p>
                    <span class="text-[10px] text-gray-400 mt-0.5 block">Terdaftar di sistem</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 group-hover:bg-indigo-50 group-hover:text-indigo-600 flex items-center justify-center shrink-0 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/80 hover:border-emerald-300 hover:shadow-sm transition-all duration-200 flex items-center justify-between group">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Terverifikasi</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 mt-1 font-mono"><?= number_format($verified_masjid ?? 0) ?></p>
                    <span class="text-[10px] text-emerald-600 font-medium mt-0.5 block">Tayang di peta publik</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.745 3.745 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/80 hover:border-amber-300 hover:shadow-sm transition-all duration-200 flex items-center justify-between group">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Antrean Verif</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-amber-600 mt-1 font-mono"><?= number_format($pending_verifikasi ?? 0) ?></p>
                    <span class="text-[10px] text-amber-600 font-medium mt-0.5 block"><?= ($pending_verifikasi ?? 0) > 0 ? 'Perlu approval' : 'Semua tuntas' ?></span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/80 hover:border-indigo-300 hover:shadow-sm transition-all duration-200 flex items-center justify-between group">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">User & Takmir</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-indigo-600 mt-1 font-mono"><?= number_format($total_users ?? 0) ?></p>
                    <span class="text-[10px] text-gray-400 mt-0.5 block"><?= $total_takmir ?? 0 ?> pengurus masjid</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-200/80 hover:border-teal-300 hover:shadow-sm transition-all duration-200 flex items-center justify-between col-span-2 lg:col-span-1 group">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Sebaran Wilayah</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-teal-700 mt-1 font-mono">
                        <?= number_format($total_provinsi ?? 0) ?> <span class="text-xs font-sans font-medium text-gray-400">Prov</span>
                    </p>
                    <span class="text-[10px] text-teal-600 font-medium mt-0.5 block"><?= number_format($total_kota ?? 0) ?> Kota/Kabupaten</span>
                </div>
                <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15.5 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- QUICK ACCESS HUB (Bento Navigation Hub) -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200/80">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-heading font-bold text-base sm:text-lg text-gray-900">Akses Cepat Tata Kelola Platform</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Navigasi langsung ke modul eksekutif administrasi ekosistem</p>
                </div>
                <span class="hidden sm:inline-flex text-[11px] font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                    7 Modul Aktif
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3">
                <a href="<?= BASE_URL ?>/admin/superadmin/profil" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-400 hover:bg-indigo-50/30 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-indigo-600 group-hover:text-white text-slate-700 flex items-center justify-center mb-2.5 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-indigo-600">Profil Platform</span>
                    <span class="text-[10px] text-gray-400 mt-0.5">Identitas & CS</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="p-4 rounded-xl border border-gray-100 hover:border-emerald-400 hover:bg-emerald-50/30 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-emerald-600 group-hover:text-white text-slate-700 flex items-center justify-center mb-2.5 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.745 3.745 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-emerald-600">Verifikasi</span>
                    <span class="text-[10px] text-gray-400 mt-0.5"><?= $pending_verifikasi ?? 0 ?> tertunda</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/superadmin/masjidverif/allMasjid" class="p-4 rounded-xl border border-gray-100 hover:border-slate-400 hover:bg-slate-50 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-slate-800 group-hover:text-white text-slate-700 flex items-center justify-center mb-2.5 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-slate-900">Semua Masjid</span>
                    <span class="text-[10px] text-gray-400 mt-0.5">Database nasional</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/superadmin/users" class="p-4 rounded-xl border border-gray-100 hover:border-indigo-400 hover:bg-indigo-50/30 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-indigo-600 group-hover:text-white text-slate-700 flex items-center justify-center mb-2.5 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-indigo-600">Kelola User</span>
                    <span class="text-[10px] text-gray-400 mt-0.5">Role & takmir</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/superadmin/masterdata" class="p-4 rounded-xl border border-gray-100 hover:border-amber-400 hover:bg-amber-50/30 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-amber-600 group-hover:text-white text-slate-700 flex items-center justify-center mb-2.5 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-amber-600">Master Data</span>
                    <span class="text-[10px] text-gray-400 mt-0.5">Kategori kas global</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/superadmin/qris" class="p-4 rounded-xl border border-gray-100 hover:border-rose-400 hover:bg-rose-50/30 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-rose-600 group-hover:text-white text-slate-700 flex items-center justify-center mb-2.5 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-rose-600">QRIS Website</span>
                    <span class="text-[10px] text-gray-400 mt-0.5">Donasi platform</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/artikelmgmt" class="p-4 rounded-xl border border-gray-100 hover:border-teal-400 hover:bg-teal-50/30 transition-all duration-200 group flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-teal-600 group-hover:text-white text-slate-700 flex items-center justify-center mb-2.5 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-800 group-hover:text-teal-600">Artikel & Buletin</span>
                    <span class="text-[10px] text-gray-400 mt-0.5">Konten dakwah</span>
                </a>
            </div>
        </div>

        <!-- URGENT VERIFICATION QUEUE WIDGET (Jika ada antrean) -->
        <?php if (!empty($pending_list)): ?>
            <div class="bg-amber-50/70 rounded-2xl border border-amber-200 p-5 sm:p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <h2 class="font-heading font-bold text-base sm:text-lg text-amber-900">Antrean Pendaftaran Masjid Baru (<?= count($pending_list) ?>)</h2>
                    </div>
                    <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="text-xs font-semibold text-amber-700 hover:text-amber-800">
                        Buka Semua Antrean &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <?php foreach (array_slice($pending_list, 0, 3) as $p): ?>
                        <div class="bg-white p-4 rounded-xl border border-amber-200/80 shadow-xs flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($p['nama']) ?></h3>
                                <p class="text-xs text-gray-500 mt-0.5"><?= htmlspecialchars($p['kota'] ?? '-') ?>, <?= htmlspecialchars($p['provinsi'] ?? '') ?></p>
                                <p class="text-[11px] text-gray-400 mt-1">Takmir: <?= htmlspecialchars($p['no_hp_takmir'] ?? '-') ?></p>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                                <a href="<?= BASE_URL ?>/admin/superadmin/verifikasi" class="text-xs font-semibold text-indigo-600 hover:underline">
                                    Review & Eksekusi &rarr;
                                </a>
                                <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full font-medium">Pending</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Daftar Masjid Terdaftar (Stripe High-Density Table) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden w-full max-w-full">
            <div class="p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="font-heading font-semibold text-base sm:text-lg text-gray-900">Database Masjid Terdaftar</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pemantauan status legalitas dan tautan langsung ke portal publik</p>
                </div>
                <a href="<?= BASE_URL ?>/admin/superadmin/masjidverif/allMasjid" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50/60 hover:bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 transition whitespace-nowrap">
                    <span>Lihat Semua Data</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm min-w-[550px]">
                    <thead class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider font-semibold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-6">Nama Masjid</th>
                            <th class="py-3 px-4 sm:px-6">Kota / Wilayah</th>
                            <th class="py-3 px-4 sm:px-6">Kapasitas Jamaah</th>
                            <th class="py-3 px-4 sm:px-6">Status Sistem</th>
                            <th class="py-3 px-4 sm:px-6 text-center">Aksi Langsung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach (($masjid_list ?? []) as $m): ?>
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4 sm:px-6 font-semibold text-gray-900">
                                    <?= htmlspecialchars($m['nama']) ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-gray-600">
                                    <?= htmlspecialchars($m['kota'] ?? '-') ?>, <?= htmlspecialchars($m['provinsi'] ?? '') ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-gray-700 font-mono">
                                    <?= !empty($m['kapasitas']) ? number_format((int)$m['kapasitas'], 0, ',', '.') . ' Jamaah' : '-' ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                    <?php if ($m['status'] === 'verified'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Terverifikasi
                                        </span>
                                    <?php elseif ($m['status'] === 'pending'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            Suspended
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 sm:px-6 text-center whitespace-nowrap">
                                    <a href="<?= BASE_URL ?>/masjid/<?= htmlspecialchars($m['slug'] ?? $m['id']) ?>" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50/50 hover:bg-indigo-100/70 px-2.5 py-1 rounded-lg transition">
                                        <span>Buka Portal</span>
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <!-- TAKMIR DASHBOARD -->
        <div class="bg-gradient-to-r from-emerald-800 to-emerald-950 text-white p-4 sm:p-6 lg:p-8 rounded-2xl sm:rounded-3xl shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] sm:text-xs font-semibold bg-white/10 text-emerald-200 mb-2 sm:mb-3 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Portal Takmir Pengurus
                </span>
                <h1 class="font-heading font-bold text-xl sm:text-2xl lg:text-3xl text-white">
                    <?= htmlspecialchars($masjid['nama'] ?? 'Masjid Kita') ?>
                </h1>
                <p class="text-emerald-200 text-xs sm:text-sm mt-1 max-w-xl">
                    <?= htmlspecialchars($masjid['alamat'] ?? 'Wilayah ' . ($masjid['kota'] ?? '')) ?>
                </p>
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-4 sm:mt-5">
                    <a href="<?= BASE_URL ?>/admin/masjid" class="inline-flex items-center gap-1.5 sm:gap-2 bg-white text-emerald-800 hover:bg-emerald-50 text-xs font-semibold py-2 sm:py-2.5 px-3.5 sm:px-4 rounded-xl transition shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <span>Edit Profil & Peta GIS</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/keuangan/create" class="inline-flex items-center gap-1.5 sm:gap-2 bg-emerald-700/80 hover:bg-emerald-700 text-white text-xs font-semibold py-2 sm:py-2.5 px-3.5 sm:px-4 rounded-xl transition border border-emerald-600/50 whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Catat Mutasi Kas</span>
                    </a>
                    <a href="<?= BASE_URL ?>/masjid/<?= htmlspecialchars($masjid['slug'] ?? $masjid['id'] ?? '') ?>" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-200 hover:text-white text-xs font-medium py-2 sm:py-2.5 px-2.5 sm:px-3 transition whitespace-nowrap">
                        <span>Lihat Publik →</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Takmir Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-5">
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Total Saldo Kas</p>
                    <p class="text-lg sm:text-2xl font-bold text-emerald-600 mt-0.5 font-mono truncate">Rp <?= number_format($total_saldo ?? 0, 0, ',', '.') ?></p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Kegiatan Bulan Ini</p>
                    <p class="text-lg sm:text-2xl font-bold text-blue-600 mt-0.5 font-mono truncate"><?= number_format($kegiatan_bulan_ini ?? 0) ?> Agenda</p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Jamaah Terdaftar</p>
                    <p class="text-lg sm:text-2xl font-bold text-purple-600 mt-0.5 font-mono truncate"><?= number_format($jumlah_jamaah ?? 0) ?> Orang</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Left Col (2/3): Transaksi Terbaru -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full max-w-full">
                    <div class="p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="font-heading font-semibold text-base sm:text-lg text-gray-800">Mutasi Kas Terbaru</h2>
                            <p class="text-xs text-gray-500 mt-0.5">5 transaksi terakhir di pembukuan</p>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/keuangan" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 whitespace-nowrap">Semua →</a>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left text-xs sm:text-sm min-w-[500px]">
                            <thead class="bg-gray-50 text-gray-600 text-[11px] sm:text-xs uppercase tracking-wider font-medium">
                                <tr>
                                    <th class="py-3 px-4 sm:px-6">Tanggal</th>
                                    <th class="py-3 px-4 sm:px-6">Kategori</th>
                                    <th class="py-3 px-4 sm:px-6">Keterangan</th>
                                    <th class="py-3 px-4 sm:px-6 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if (empty($transaksi_terakhir)): ?>
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-400 text-xs sm:text-sm">
                                            Belum ada transaksi mutasi kas tercatat.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($transaksi_terakhir as $tx): 
                                        $isMasuk = ($tx['tipe'] === 'masuk');
                                        $nom = (float)$tx['nominal'];
                                    ?>
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 whitespace-nowrap text-gray-700 font-medium">
                                                <?= date('d M Y', strtotime($tx['tanggal'])) ?>
                                            </td>
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] sm:text-xs font-medium <?= $isMasuk ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' ?>">
                                                    <?= htmlspecialchars($tx['nama_kategori'] ?? 'Kas') ?>
                                                </span>
                                            </td>
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 text-gray-600 max-w-[150px] sm:max-w-xs truncate">
                                                <?= htmlspecialchars($tx['keterangan'] ?? '-') ?>
                                            </td>
                                            <td class="py-3 sm:py-3.5 px-4 sm:px-6 text-right font-mono font-semibold whitespace-nowrap <?= $isMasuk ? 'text-emerald-600' : 'text-rose-600' ?>">
                                                <?= $isMasuk ? '+Rp ' : '-Rp ' ?><?= number_format($nom, 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Col (1/3): Agenda Terdekat -->
            <div class="space-y-4 sm:space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-3 sm:mb-4">
                        <h2 class="font-heading font-semibold text-sm sm:text-base text-gray-800">Kegiatan Terdekat</h2>
                        <a href="<?= BASE_URL ?>/admin/kegiatan" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 whitespace-nowrap">Kelola →</a>
                    </div>
                    <?php if (empty($kegiatan_mendatang)): ?>
                        <div class="py-6 sm:py-8 text-center text-gray-400 text-xs">
                            Tidak ada agenda kegiatan terdekat.
                        </div>
                    <?php else: ?>
                        <div class="space-y-2.5 sm:space-y-3">
                            <?php foreach ($kegiatan_mendatang as $keg): ?>
                                <div class="p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition">
                                    <div class="text-xs font-semibold text-emerald-700 flex items-center gap-1.5 mb-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        <span><?= date('d M Y', strtotime($keg['tanggal_mulai'])) ?></span>
                                    </div>
                                    <h3 class="font-medium text-xs sm:text-sm text-gray-900 line-clamp-1"><?= htmlspecialchars($keg['judul']) ?></h3>
                                    <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5 line-clamp-1"><?= htmlspecialchars($keg['lokasi_detail'] ?? 'Area Masjid') ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
