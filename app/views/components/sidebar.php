<?php
$role = $_SESSION['user']['role'] ?? '';
$currentUrl = $_SERVER['REQUEST_URI'] ?? '';
$navItems = [
    ['url' => '/admin/dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
    ['url' => '/admin/masjid', 'icon' => 'office-building', 'label' => 'Profil Masjid'],
    ['url' => '/admin/keuangan', 'icon' => 'cash', 'label' => 'Keuangan'],
    ['url' => '/admin/kegiatan', 'icon' => 'calendar', 'label' => 'Kegiatan'],
    ['url' => '/admin/jadwal', 'icon' => 'clock', 'label' => 'Jadwal Petugas'],
    ['url' => '/admin/aset', 'icon' => 'archive', 'label' => 'Aset'],
    ['url' => '/admin/jamaah', 'icon' => 'users', 'label' => 'Jamaah'],
    ['url' => '/admin/donasi', 'icon' => 'credit-card', 'label' => 'Donasi/Rekening'],
];

if ($role === 'super_admin') {
    $navItems = array_merge($navItems, [
        ['url' => '/superadmin/verifikasi', 'icon' => 'check-circle', 'label' => 'Verifikasi Masjid'],
        ['url' => '/superadmin/users', 'icon' => 'user-group', 'label' => 'Kelola User'],
        ['url' => '/superadmin/master', 'icon' => 'database', 'label' => 'Master Data'],
    ]);
}
?>
<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

<aside id="sidebar" class="w-64 bg-emerald-800 text-white flex flex-col h-full fixed md:relative z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="h-16 flex items-center justify-center border-b border-emerald-700">
        <span class="font-['Poppins'] font-bold text-xl">Admin Panel</span>
    </div>
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">
            <?php foreach ($navItems as $item): ?>
                <?php $isActive = strpos($currentUrl, $item['url']) !== false; ?>
                <li>
                    <a href="<?= BASE_URL . $item['url'] ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg <?= $isActive ? 'bg-emerald-900 text-white' : 'text-emerald-100 hover:bg-emerald-700' ?>">
                        <span class="text-sm font-medium"><?= htmlspecialchars($item['label']) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</aside>
