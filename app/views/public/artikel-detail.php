<?php $artikel = $data['artikel'] ?? ($artikel ?? []); ?>
<div class="max-w-3xl mx-auto py-4">
    <!-- Back Button -->
    <a href="<?= BASE_URL ?>/artikel" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3.5 py-2 rounded-xl transition mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Kembali ke Buletin</span>
    </a>

    <!-- Header & Category -->
    <div class="mb-4">
        <span class="text-xs uppercase font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-md tracking-wider">
            <?= htmlspecialchars($artikel['kategori'] ?? 'Buletin') ?>
        </span>
        <h1 class="font-heading font-extrabold text-2xl sm:text-4xl text-gray-900 mt-3 mb-2 leading-tight">
            <?= htmlspecialchars($artikel['judul'] ?? 'Judul Artikel') ?>
        </h1>
        <p class="text-xs text-gray-400">
            Dipublikasikan pada <?= date('l, d F Y', strtotime($artikel['published_at'] ?? ($artikel['created_at'] ?? 'now'))) ?>
        </p>
    </div>

    <!-- Featured Image -->
    <div class="w-full h-72 sm:h-96 rounded-3xl overflow-hidden shadow-md my-6 bg-gray-100">
        <img src="<?= htmlspecialchars($artikel['gambar'] ?? BASE_URL.'/public/img/placeholder.svg') ?>" class="w-full h-full object-cover">
    </div>

    <!-- Content -->
    <article class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 text-gray-700 leading-relaxed text-sm sm:text-base space-y-4">
        <?= nl2br(htmlspecialchars($artikel['konten'] ?? '')) ?>
    </article>

    <!-- Share Footer -->
    <div class="mt-8 p-6 bg-emerald-50 rounded-2xl flex items-center justify-between">
        <div>
            <h4 class="font-heading font-bold text-emerald-900 text-sm">Bagikan Kebaikan</h4>
            <p class="text-xs text-emerald-700">Sebarkan artikel dan ilmu bermanfaat ini kepada keluarga dan kerabat.</p>
        </div>
        <button onclick="if(navigator.share){navigator.share({title:'<?= htmlspecialchars(addslashes($artikel['judul'] ?? '')) ?>',url:window.location.href})}else{navigator.clipboard.writeText(window.location.href);alert('Tautan disalin ke clipboard!')}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold py-2.5 px-4 rounded-xl shadow-sm transition">
            Bagikan
        </button>
    </div>
</div>
