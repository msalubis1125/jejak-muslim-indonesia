<?php
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$baseUrl = $baseUrl ?? '';
if ($totalPages <= 1) return;
?>
<div class="flex items-center justify-center mt-8 space-x-2">
    <?php if ($currentPage > 1): ?>
        <a href="<?= $baseUrl ?>?page=<?= $currentPage - 1 ?>" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-gray-50">Prev</a>
    <?php else: ?>
        <button disabled class="px-4 py-2 border border-gray-100 rounded-lg text-sm font-medium text-gray-300 cursor-not-allowed">Prev</button>
    <?php endif; ?>

    <div class="hidden sm:flex space-x-1">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= $baseUrl ?>?page=<?= $i ?>" class="px-3 py-2 rounded-lg text-sm font-medium <?= $i === $currentPage ? 'bg-emerald-600 text-white' : 'text-gray-600 hover:bg-gray-100' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <?php if ($currentPage < $totalPages): ?>
        <a href="<?= $baseUrl ?>?page=<?= $currentPage + 1 ?>" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-gray-50">Next</a>
    <?php else: ?>
        <button disabled class="px-4 py-2 border border-gray-100 rounded-lg text-sm font-medium text-gray-300 cursor-not-allowed">Next</button>
    <?php endif; ?>
</div>
