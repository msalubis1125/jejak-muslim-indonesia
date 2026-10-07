<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    $brandLogo = !empty($platformProfile['app_logo']) ? BASE_URL . '/' . ltrim($platformProfile['app_logo'], '/') : BASE_URL . '/public/img/logo-transparent.png';
    $brandFavicon = !empty($platformProfile['app_favicon']) ? BASE_URL . '/' . ltrim($platformProfile['app_favicon'], '/') : BASE_URL . '/public/img/favicon.png';
    $brandName = $platformProfile['app_name'] ?? 'Jejak Muslim Indonesia';
    $brandTagline = $platformProfile['app_tagline'] ?? 'Sistem Tata Kelola & Portofolio Masjid';
    ?>
    <title><?= isset($title) ? $title . ' - ' : '' ?><?= htmlspecialchars($brandName) ?></title>
    <link rel="icon" type="image/png" href="<?= $brandFavicon ?>">
    <link rel="apple-touch-icon" href="<?= $brandFavicon ?>">

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

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 via-white to-primary-50 font-body text-gray-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white border border-gray-100 rounded-3xl shadow-md p-3 mb-4">
                <img src="<?= $brandLogo ?>" alt="Logo <?= htmlspecialchars($brandName) ?>" class="w-full h-full object-contain">
            </div>
            <h1 class="font-heading font-bold text-2xl text-gray-900">Jejak Muslim <span class="text-red-600">Indonesia</span></h1>
            <p class="text-gray-500 text-sm mt-1"><?= htmlspecialchars($brandTagline) ?></p>
        </div>

        <!-- Flash Messages -->
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php $successMsg = Session::flash('success'); if (!empty($successMsg)): ?>
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                <?= htmlspecialchars($successMsg) ?>
            </div>
        <?php endif; ?>

        <?php $errorMsg = Session::flash('error'); if (!empty($errorMsg)): ?>
            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm">
                <?= htmlspecialchars($errorMsg) ?>
            </div>
        <?php endif; ?>

        <!-- Card Content -->
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 p-6 sm:p-8">
            <?= $content ?>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="<?= BASE_URL ?>/" class="text-sm text-gray-400 hover:text-primary-600 transition">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/public/js/app.js"></script>
</body>
</html>
