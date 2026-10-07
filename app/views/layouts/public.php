<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jejak Muslim Indonesia - Portal Masjid, Informasi & Pemetaan">
    <meta name="theme-color" content="#059669">
    <?php 
    $brandLogo = !empty($platformProfile['app_logo']) ? BASE_URL . '/' . ltrim($platformProfile['app_logo'], '/') : BASE_URL . '/public/img/logo-transparent.png';
    $brandFavicon = !empty($platformProfile['app_favicon']) ? BASE_URL . '/' . ltrim($platformProfile['app_favicon'], '/') : BASE_URL . '/public/img/favicon.png';
    $brandName = $platformProfile['app_name'] ?? 'Jejak Muslim Indonesia';
    ?>
    <link rel="icon" type="image/png" href="<?= $brandFavicon ?>">
    <link rel="apple-touch-icon" href="<?= $brandFavicon ?>">
    <title><?= isset($title) ? $title . ' - ' : '' ?><?= htmlspecialchars($brandName) ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Production Compiled CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">

    <!-- Tailwind CSS CDN (Development Only) -->
    <?php if (defined('APP_ENV') && APP_ENV === 'development'): ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0', 300: '#6ee7b7',
                            400: '#34d399', 500: '#10b981', 600: '#059669', 700: '#047857',
                            800: '#065f46', 900: '#064e3b'
                        }
                    }
                }
            }
        }
    </script>
    <?php endif; ?>

    <?php if (isset($extraCss)): ?>
        <?= $extraCss ?>
    <?php endif; ?>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50/70 font-body text-gray-800 antialiased selection:bg-emerald-100 selection:text-emerald-800 overflow-x-hidden w-full min-h-screen flex flex-col">

    <!-- Responsive Navbar -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="<?= BASE_URL ?>/" class="flex items-center gap-2.5 group">
                <img src="<?= $brandLogo ?>" alt="Logo <?= htmlspecialchars($brandName) ?>" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                <div class="flex flex-col">
                    <span class="font-heading font-extrabold text-gray-900 text-base tracking-tight leading-none group-hover:text-emerald-700 transition">Jejak Muslim</span>
                    <span class="text-[10px] text-red-600 font-bold tracking-wider uppercase leading-tight mt-0.5">Indonesia</span>
                </div>
            </a>

            <!-- Desktop Navigation Links (hidden on mobile, visible md+) -->
            <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-gray-600">
                <a href="<?= BASE_URL ?>/" class="hover:text-emerald-600 transition <?= ($currentPage ?? '') === 'home' ? 'text-emerald-600 font-semibold' : '' ?>">Beranda</a>
                <a href="<?= BASE_URL ?>/peta" class="hover:text-emerald-600 transition <?= ($currentPage ?? '') === 'peta' ? 'text-emerald-600 font-semibold' : '' ?>">Peta Masjid</a>
                <a href="<?= BASE_URL ?>/masjid" class="hover:text-emerald-600 transition <?= ($currentPage ?? '') === 'masjid' ? 'text-emerald-600 font-semibold' : '' ?>">Direktori</a>
                <a href="<?= BASE_URL ?>/kegiatan" class="hover:text-emerald-600 transition <?= ($currentPage ?? '') === 'kegiatan' ? 'text-emerald-600 font-semibold' : '' ?>">Jadwal & Kegiatan</a>
                <a href="<?= BASE_URL ?>/donasi" class="hover:text-emerald-600 transition <?= ($currentPage ?? '') === 'donasi' ? 'text-emerald-600 font-semibold' : '' ?>">Infaq & Donasi</a>
                <a href="<?= BASE_URL ?>/artikel" class="hover:text-emerald-600 transition <?= ($currentPage ?? '') === 'artikel' ? 'text-emerald-600 font-semibold' : '' ?>">Buletin</a>
            </nav>

            <!-- Actions / Auth Button -->
            <div class="flex items-center gap-3">
                <a href="<?= BASE_URL ?>/masjid" class="p-2 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition md:hidden" title="Cari Masjid">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </a>

                <?php if (Auth::check()): ?>
                    <a href="<?= BASE_URL ?>/admin/dashboard" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold py-2 px-4 rounded-xl shadow-sm hover:shadow transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/auth/login" class="inline-flex items-center gap-1.5 border border-emerald-600 text-emerald-700 hover:bg-emerald-50 text-xs sm:text-sm font-semibold py-2 px-3.5 sm:px-4 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        <span>Masuk Takmir</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Flash Messages / Toast -->
    <?php if (Session::flash('success')): ?>
        <div id="flash-toast" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-sm w-full px-4 animate-slide-down">
            <div class="bg-emerald-600 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="text-sm font-medium"><?= Session::flash('success') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (Session::flash('error')): ?>
        <div id="flash-toast-error" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-sm w-full px-4 animate-slide-down">
            <div class="bg-red-500 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <span class="text-sm font-medium"><?= Session::flash('error') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content: Full responsive container -->
    <main class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-6 pb-24 md:pb-12 min-h-screen w-full min-w-0">
        <?= $content ?>
    </main>

    <!-- Footer for Desktop/Tablet -->
    <footer class="hidden md:block bg-white border-t border-gray-100 py-8 text-center text-sm text-gray-500">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <img src="<?= $brandLogo ?>" alt="Logo <?= htmlspecialchars($brandName) ?>" class="h-7 w-auto object-contain">
                <span class="font-heading font-bold text-gray-800">Jejak Muslim <span class="text-red-600">Indonesia</span></span>
            </div>
            <p class="text-xs text-gray-400">&copy; <?= date('Y') ?> Jejak Muslim Indonesia. Pusat Ekosistem Digital Masjid & Jamaah.</p>
            <div class="flex gap-4 text-xs">
                <a href="<?= BASE_URL ?>/peta" class="hover:text-emerald-600">Peta GIS</a>
                <a href="<?= BASE_URL ?>/donasi" class="hover:text-emerald-600">Infaq</a>
                <a href="<?= BASE_URL ?>/auth/login" class="hover:text-emerald-600">Portal Pengurus</a>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation Bar (Mobile only: md:hidden) -->
    <?php
    $currentPage = isset($currentPage) ? $currentPage : '';
    include ROOT_PATH . '/app/views/components/bottom-nav.php';
    ?>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>/public/js/app.js?v=<?= time() ?>"></script>
    <script src="<?= BASE_URL ?>/public/js/countdown.js?v=<?= time() ?>"></script>
    <?php if (isset($extraJs)): ?>
        <?= $extraJs ?>
    <?php endif; ?>

    <script>
        // Auto-dismiss flash toast
        setTimeout(function() {
            var toast = document.getElementById('flash-toast');
            var toastError = document.getElementById('flash-toast-error');
            if (toast) toast.style.opacity = '0';
            if (toastError) toastError.style.opacity = '0';
            setTimeout(function() {
                if (toast) toast.remove();
                if (toastError) toastError.remove();
            }, 300);
        }, 5000);
    </script>
</body>
</html>
