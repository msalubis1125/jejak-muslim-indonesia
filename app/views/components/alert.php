<?php if (isset($_SESSION['flash'])): ?>
    <div id="flash-message" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-sm px-4">
        <?php
        $type = $_SESSION['flash']['type'] ?? 'info';
        $message = $_SESSION['flash']['message'] ?? '';
        $colors = [
            'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'error'   => 'bg-red-50 text-red-800 border-red-200',
            'warning' => 'bg-amber-50 text-amber-800 border-amber-200',
            'info'    => 'bg-blue-50 text-blue-800 border-blue-200'
        ];
        $colorClass = $colors[$type] ?? $colors['info'];
        ?>
        <div class="<?= $colorClass ?> border px-4 py-3 rounded-xl shadow-lg flex items-start justify-between">
            <p class="text-sm font-medium"><?= htmlspecialchars($message) ?></p>
            <button onclick="document.getElementById('flash-message').remove()" class="text-current opacity-70 hover:opacity-100 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const el = document.getElementById('flash-message');
            if (el) el.remove();
        }, 5000);
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
