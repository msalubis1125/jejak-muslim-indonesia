<?php
$cur = $currentPage ?? ($data['current_page'] ?? 'home');
?>
<nav class="md:hidden fixed bottom-0 left-0 right-0 w-full bg-white/95 backdrop-blur-md border-t border-gray-200 shadow-lg pb-safe z-50">
    <div class="max-w-md mx-auto flex justify-around items-center h-16 px-2">
        <a href="<?= BASE_URL ?>/" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition <?= in_array($cur, ['home', 'beranda']) ? 'text-emerald-600 font-semibold' : 'text-gray-400 hover:text-emerald-500' ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px]">Beranda</span>
        </a>
        <a href="<?= BASE_URL ?>/peta" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition <?= $cur === 'peta' ? 'text-emerald-600 font-semibold' : 'text-gray-400 hover:text-emerald-500' ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="text-[10px]">Peta</span>
        </a>
        <a href="<?= BASE_URL ?>/kegiatan" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition <?= $cur === 'kegiatan' ? 'text-emerald-600 font-semibold' : 'text-gray-400 hover:text-emerald-500' ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"></path></svg>
            <span class="text-[10px]">Kegiatan</span>
        </a>
        <a href="<?= BASE_URL ?>/donasi" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition <?= $cur === 'donasi' ? 'text-emerald-600 font-semibold' : 'text-gray-400 hover:text-emerald-500' ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            <span class="text-[10px]">Donasi</span>
        </a>
        <a href="<?= Auth::check() ? BASE_URL . '/admin/dashboard' : BASE_URL . '/auth/login' ?>" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition <?= in_array($cur, ['login', 'profile', 'admin']) ? 'text-emerald-600 font-semibold' : 'text-gray-400 hover:text-emerald-500' ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-[10px]"><?= Auth::check() ? 'Dashboard' : 'Masuk' ?></span>
        </a>
    </div>
</nav>
