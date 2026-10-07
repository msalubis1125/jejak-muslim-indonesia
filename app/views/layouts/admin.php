<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    $brandLogo = !empty($platformProfile['app_logo']) ? BASE_URL . '/' . ltrim($platformProfile['app_logo'], '/') : BASE_URL . '/public/img/logo-transparent.png';
    $brandFavicon = !empty($platformProfile['app_favicon']) ? BASE_URL . '/' . ltrim($platformProfile['app_favicon'], '/') : BASE_URL . '/public/img/favicon.png';
    $brandName = $platformProfile['app_name'] ?? 'Jejak Muslim Indonesia';
    ?>
    <title><?= isset($title) ? $title . ' - ' : '' ?>Dashboard | <?= htmlspecialchars($brandName) ?></title>
    <link rel="icon" type="image/png" href="<?= $brandFavicon ?>">
    <link rel="apple-touch-icon" href="<?= $brandFavicon ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Production Compiled CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">

    <!-- Tailwind Play CDN (Development Only) -->
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
        
        /* Ensure sidebar stays strictly locked to viewport */
        @media (min-width: 1024px) {
            #sidebar {
                position: sticky !important;
                top: 0 !important;
                height: 100vh !important;
                max-height: 100vh !important;
                align-self: flex-start !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-body text-gray-800 antialiased">
    <div class="flex min-h-screen w-full relative">

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar (Fixed/Sticky full height, independent internal scroll) -->
        <!-- Sidebar (Sticky full viewport height with internal smooth scroll) -->
        <?php
        $isSuperAdmin = Auth::isSuperAdmin();
        $sidebarBg = $isSuperAdmin ? 'bg-[#0b1329] border-r border-[#1e293b]' : 'bg-[#064e3b] border-r border-emerald-900';
        $sidebarSubtext = $isSuperAdmin ? 'text-blue-400' : 'text-emerald-300';
        $activeClass = $isSuperAdmin ? 'bg-blue-600 text-white shadow-md font-semibold' : 'bg-emerald-600 text-white shadow-sm font-semibold';
        $hoverClass = $isSuperAdmin ? 'text-slate-300 hover:bg-slate-800/90 hover:text-white' : 'text-emerald-100 hover:bg-emerald-800/70 hover:text-white';
        $sectionHeaderClass = $isSuperAdmin ? 'text-slate-500 font-semibold tracking-wider text-[10px] uppercase px-3 pt-3 pb-1' : 'text-emerald-300/60 font-semibold tracking-wider text-[10px] uppercase px-3 pt-3 pb-1';
        $currentUri = $_SERVER['REQUEST_URI'] ?? '';
        ?>
        <aside id="sidebar" class="fixed lg:sticky top-0 inset-y-0 left-0 z-50 w-64 h-screen <?= $sidebarBg ?> text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col shrink-0 overflow-hidden shadow-xl lg:shadow-none">
            <!-- Brand / Logo Header -->
            <div class="h-16 flex items-center gap-3 px-5 border-b <?= $isSuperAdmin ? 'border-slate-800/80' : 'border-emerald-800/60' ?> shrink-0">
                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center p-1.5 shadow-sm shrink-0">
                    <img src="<?= $brandLogo ?>" alt="Logo <?= htmlspecialchars($brandName) ?>" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-heading font-bold text-sm tracking-tight truncate text-white">Jejak Muslim</span>
                    <span class="text-[10px] <?= $sidebarSubtext ?> font-semibold tracking-wider uppercase leading-tight truncate">
                        <?= $isSuperAdmin ? 'Pusat Kendali Ekosistem' : 'Portal Manajemen Masjid' ?>
                    </span>
                </div>
            </div>

            <!-- Navigation Menu (Categorized with Section Headers) -->
            <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-3 custom-scrollbar">
                <?php
                if ($isSuperAdmin) {
                    $navSections = [
                        'Utama & Identitas' => [
                            ['url' => '/admin/dashboard', 'match' => ['/admin/dashboard'], 'label' => 'Dashboard Pusat', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />'],
                            ['url' => '/admin/superadmin/profil', 'match' => ['/admin/superadmin/profil', 'profilplatform'], 'label' => 'Profil Platform', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-.778.099-1.533.284-2.253" />']
                        ],
                        'Tata Kelola Ekosistem' => [
                            ['url' => '/admin/superadmin/verifikasi', 'match' => ['/admin/superadmin/verifikasi', '/admin/superadmin/masjidverif'], 'label' => 'Verifikasi Masjid', 'badge' => $pending_verifikasi ?? null, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.745 3.745 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />'],
                            ['url' => '/admin/superadmin/masjidverif/allMasjid', 'match' => ['/allMasjid', '/superadmin/masjidverif/allMasjid'], 'label' => 'Semua Data Masjid', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />'],
                            ['url' => '/admin/superadmin/masterdata', 'match' => ['/admin/superadmin/masterdata', 'masterdata'], 'label' => 'Master Kategori Kas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />']
                        ],
                        'Pengguna & Keuangan' => [
                            ['url' => '/admin/superadmin/users', 'match' => ['/admin/superadmin/users', 'user-management'], 'label' => 'Kelola Pengguna', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />'],
                            ['url' => '/admin/superadmin/qris', 'match' => ['/admin/superadmin/qris'], 'label' => 'QRIS Donasi Website', 'icon' => '<path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" /><path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h3.75m0 0v3.75m0-3.75h3.75m-3.75 3.75v3.75m0-3.75h-3.75" />']
                        ],
                        'Konten & Dakwah' => [
                            ['url' => '/admin/artikelmgmt', 'match' => ['/admin/artikelmgmt', 'artikel'], 'label' => 'Artikel & Buletin', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />']
                        ]
                    ];
                } else {
                    $navSections = [
                        'Utama' => [
                            ['url' => '/admin/dashboard', 'match' => ['/admin/dashboard'], 'label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />'],
                            ['url' => '/admin/masjid', 'match' => ['/admin/masjid'], 'label' => 'Profil Masjid & GIS', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />']
                        ],
                        'Operasional & Kas' => [
                            ['url' => '/admin/keuangan', 'match' => ['/admin/keuangan'], 'label' => 'Keuangan & Kas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />'],
                            ['url' => '/admin/kegiatan', 'match' => ['/admin/kegiatan'], 'label' => 'Kegiatan & Acara', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />'],
                            ['url' => '/admin/jadwalpetugas', 'match' => ['/admin/jadwalpetugas'], 'label' => 'Jadwal Petugas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />'],
                            ['url' => '/admin/aset', 'match' => ['/admin/aset'], 'label' => 'Aset & Inventaris', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />']
                        ],
                        'Jamaah & Dakwah' => [
                            ['url' => '/admin/jamaah', 'match' => ['/admin/jamaah'], 'label' => 'Direktori Jamaah', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />'],
                            ['url' => '/admin/donasi', 'match' => ['/admin/donasi'], 'label' => 'Donasi & Rekening', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />'],
                            ['url' => '/admin/artikelmgmt', 'match' => ['/admin/artikelmgmt'], 'label' => 'Artikel & Buletin', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />']
                        ]
                    ];
                }

                foreach ($navSections as $sectionTitle => $items):
                ?>
                    <div>
                        <div class="<?= $sectionHeaderClass ?>"><?= $sectionTitle ?></div>
                        <div class="space-y-1 mt-1">
                            <?php foreach ($items as $item): 
                                $isActive = false;
                                if (!empty($item['match'])) {
                                    foreach ($item['match'] as $pattern) {
                                        if (strpos($currentUri, $pattern) !== false) {
                                            $isActive = true;
                                            break;
                                        }
                                    }
                                }
                                if (!$isActive && !empty($currentMenu)) {
                                    $isActive = (isset($item['key']) && $item['key'] === $currentMenu);
                                }
                            ?>
                                <a href="<?= BASE_URL . $item['url'] ?>" 
                                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm transition-all <?= $isActive ? $activeClass : $hoverClass ?>">
                                    <div class="flex items-center gap-3 truncate">
                                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <?= $item['icon'] ?>
                                        </svg>
                                        <span class="truncate"><?= $item['label'] ?></span>
                                    </div>
                                    <?php if (!empty($item['badge']) && $item['badge'] > 0): ?>
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-500 text-white shrink-0 animate-pulse">
                                            <?= $item['badge'] ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </nav>

            <!-- Bottom: Quick Portal Link & User Info Card -->
            <div class="p-3 border-t <?= $isSuperAdmin ? 'border-slate-800/80 bg-[#070d1e]/80' : 'border-emerald-800/80 bg-emerald-950/30' ?> shrink-0 space-y-2">
                <a href="<?= BASE_URL ?>/" target="_blank" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl text-xs font-semibold <?= $isSuperAdmin ? 'bg-slate-800/80 hover:bg-slate-700/80 text-slate-200 border border-slate-700/50' : 'bg-emerald-800/80 hover:bg-emerald-700 text-emerald-100' ?> transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    <span>Kunjungi Portal Publik</span>
                </a>

                <div class="flex items-center gap-2.5 px-2 py-1.5">
                    <div class="w-8 h-8 <?= $isSuperAdmin ? 'bg-blue-600 ring-2 ring-blue-400' : 'bg-emerald-600 ring-2 ring-emerald-400' ?> rounded-full flex items-center justify-center text-xs font-bold shadow shrink-0 text-white">
                        <?= strtoupper(substr(Auth::name(), 0, 1)) ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold truncate text-white leading-tight"><?= htmlspecialchars(Auth::name()) ?></p>
                        <p class="text-[10px] <?= $sidebarSubtext ?> truncate mt-0.5 font-medium">
                            <?= $isSuperAdmin ? 'Super Administrator' : 'Takmir Pengurus' ?>
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area: Locked to viewport width, zero bleed -->
        <div class="flex-1 flex flex-col min-h-screen min-w-0 w-full max-w-full overflow-x-hidden">
            <!-- Top Bar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-3 sm:px-4 lg:px-6 sticky top-0 z-30 w-full">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <!-- Hamburger (Mobile) -->
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-1 rounded-xl hover:bg-gray-100 transition shrink-0" aria-label="Buka Menu">
                        <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <h1 class="font-heading font-semibold text-sm sm:text-base lg:text-lg text-gray-800 truncate"><?= $title ?? 'Dashboard' ?></h1>

                    <?php if (Auth::isSuperAdmin()): ?>
                        <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                            Super Admin
                        </span>
                    <?php else: ?>
                        <span class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            Takmir
                        </span>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <!-- Super Admin Mode Badge -->
                    <?php if (Auth::isSuperAdmin()): ?>
                        <div class="hidden md:flex items-center gap-1.5 text-xs text-blue-700 bg-blue-50/80 border border-blue-200/80 px-3 py-1.5 rounded-lg font-medium">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Akses Seluruh Masjid</span>
                        </div>
                    <?php endif; ?>

                    <!-- Login As Banner -->
                    <?php if (Session::get('original_super_admin') || Session::get('original_admin_id')): ?>
                        <form action="<?= BASE_URL ?>/admin/superadmin/users/returnFromLoginAs" method="POST" class="flex items-center gap-1.5">
                            <input type="hidden" name="csrf_token" value="<?= CSRF::generate() ?>">
                            <button type="submit" class="text-[11px] sm:text-xs bg-amber-500 hover:bg-amber-600 text-white px-2.5 sm:px-3 py-1 rounded-full font-medium transition shadow-sm">Kembali SuperAdmin</button>
                        </form>
                    <?php endif; ?>

                    <!-- Profile Settings -->
                    <a href="<?= BASE_URL ?>/profile" class="p-2 rounded-xl hover:bg-gray-100 transition text-gray-600 hover:text-emerald-600 flex items-center gap-1.5 text-xs font-medium" title="Pengaturan Profil & Password">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span class="hidden md:inline"><?= htmlspecialchars(Auth::user()['nama'] ?? 'Profil') ?></span>
                    </a>

                    <!-- Back to Portal -->
                    <a href="<?= BASE_URL ?>/" class="text-xs sm:text-sm text-gray-500 hover:text-primary-600 transition hidden sm:block">← Portal</a>

                    <!-- Logout -->
                    <a href="<?= BASE_URL ?>/auth/logout" class="p-2 rounded-xl hover:bg-gray-100 transition text-gray-500 hover:text-red-600" title="Keluar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Flash Messages -->
            <?php if (Session::flash('success') || Session::flash('error')): ?>
                <div class="px-3 sm:px-4 lg:px-6 pt-3 sm:pt-4">
                    <?php include ROOT_PATH . '/app/views/components/alert.php'; ?>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <main class="flex-1 p-3 sm:p-4 lg:p-6 min-w-0 w-full max-w-full overflow-x-hidden">
                <?= $content ?>
            </main>

            <!-- Footer -->
            <footer class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-center text-xs text-gray-400 border-t border-gray-100">
                &copy; <?= date('Y') ?> Jejak Muslim Indonesia. Panel Administrasi.
            </footer>
        </div>
    </div>


    <!-- Scripts -->
    <script src="<?= BASE_URL ?>/public/js/app.js"></script>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    <?php if (isset($extraJs)): ?>
        <?= $extraJs ?>
    <?php endif; ?>
</body>
</html>
