<?php

class FileUploader {
    // Whitelist allowed MIME types and their trusted extensions
    private static $allowedMimes = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png'  => ['png'],
        'image/webp' => ['webp']
    ];

    /**
     * Securely upload an image file
     *
     * @param array $file $_FILES['input_name']
     * @param string $destinationSubfolder Subfolder inside public/uploads (e.g. 'masjid', 'qris', 'kegiatan')
     * @param string $prefix Prefix for generated file name
     * @param int $maxBytes Maximum allowed file size (default: 3MB)
     * @return array ['success' => bool, 'fileName' => string|null, 'error' => string|null]
     */
    public static function uploadImage($file, $destinationSubfolder, $prefix = 'img_', $maxBytes = 3145728) {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'fileName' => null, 'error' => 'Parameter berkas tidak valid.'];
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return ['success' => false, 'fileName' => null, 'error' => 'Tidak ada berkas yang diunggah.'];
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return ['success' => false, 'fileName' => null, 'error' => 'Ukuran berkas melebihi batas maksimum server.'];
            default:
                return ['success' => false, 'fileName' => null, 'error' => 'Terjadi kesalahan saat mengunggah berkas.'];
        }

        if ($file['size'] > $maxBytes) {
            $mb = round($maxBytes / 1048576, 1);
            return ['success' => false, 'fileName' => null, 'error' => "Ukuran berkas terlalu besar. Maksimum {$mb}MB."];
        }

        // Validate extension
        $rawExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // SVG is explicitly rejected due to Stored XSS / script payload risk in public uploads
        if ($rawExt === 'svg') {
            return ['success' => false, 'fileName' => null, 'error' => 'Format SVG tidak diizinkan demi alasan keamanan. Harap gunakan format JPG, PNG, atau WEBP.'];
        }

        // Inspect Magic Bytes via finfo
        if (!function_exists('finfo_open')) {
            return ['success' => false, 'fileName' => null, 'error' => 'Ekstensi PHP fileinfo tidak aktif pada server.'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!array_key_exists($mime, self::$allowedMimes)) {
            return ['success' => false, 'fileName' => null, 'error' => 'Tipe format berkas tidak diizinkan (Hanya JPG, PNG, WEBP).'];
        }

        // Verify that the extension matches the MIME type magic bytes
        if (!in_array($rawExt, self::$allowedMimes[$mime])) {
            return ['success' => false, 'fileName' => null, 'error' => 'Ekstensi berkas tidak sesuai dengan tipe konten berkas sebenarnya.'];
        }

        // Determine destination folder inside public/uploads
        $cleanSubfolder = trim(str_replace(['..', '/', '\\'], '', $destinationSubfolder));
        $targetDirectory = ROOT_PATH . '/public/uploads/' . $cleanSubfolder;

        if (!is_dir($targetDirectory)) {
            if (!mkdir($targetDirectory, 0755, true)) {
                return ['success' => false, 'fileName' => null, 'error' => 'Direktori unggahan gagal dibuat di server.'];
            }
        }

        // Generate unique cryptographically random filename
        $fileName = $prefix . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $rawExt;
        $destinationPath = $targetDirectory . '/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
            return ['success' => false, 'fileName' => null, 'error' => 'Gagal memindahkan berkas yang diunggah ke direktori tujuan.'];
        }

        return [
            'success' => true,
            'fileName' => $fileName,
            'error' => null
        ];
    }
}
