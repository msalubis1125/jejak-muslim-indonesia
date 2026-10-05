<?php

class QrisSettingsController extends Controller {
    public function __construct() {
        Auth::requireLogin();
        Auth::requireRole('super_admin');
    }

    public function index() {
        $pengaturanModel = $this->model('PengaturanModel');
        $qrisSettings = $pengaturanModel->getQrisWebsiteSettings();

        $data = [
            'title' => 'Pengaturan QRIS Donasi Website',
            'currentMenu' => 'qris_settings',
            'qris' => $qrisSettings
        ];

        $this->view('admin/superadmin/qris-settings', $data);
    }

    public function update() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Permintaan tidak valid atau token kadaluarsa.');
            $this->redirect('admin/superadmin/qris');
            return;
        }

        $pengaturanModel = $this->model('PengaturanModel');

        $data = [
            'title' => $_POST['title'] ?? 'Infaq & Donasi Pengembangan Website',
            'desc' => $_POST['desc'] ?? '',
            'atas_nama' => $_POST['atas_nama'] ?? 'Jejak Muslim Indonesia',
            'footer' => $_POST['footer'] ?? '',
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];

        // Handle Image URL input if provided
        if (!empty($_POST['image_url'])) {
            $data['image'] = trim($_POST['image_url']);
        }

        // Handle File Upload
        if (isset($_FILES['qris_file']) && $_FILES['qris_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['qris_file'];
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowedExtensions)) {
                $targetDir = ROOT_PATH . '/uploads/qris/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $fileName = 'qris_website_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $targetPath = $targetDir . $fileName;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $data['image'] = 'uploads/qris/' . $fileName;
                } else {
                    Session::flash('error', 'Gagal mengunggah file gambar QRIS.');
                    $this->redirect('admin/superadmin/qris');
                    return;
                }
            } else {
                Session::flash('error', 'Format gambar tidak didukung. Harap gunakan JPG, PNG, WEBP, atau SVG.');
                $this->redirect('admin/superadmin/qris');
                return;
            }
        }

        $pengaturanModel->updateQrisWebsiteSettings($data);
        Session::flash('success', 'Pengaturan QRIS Donasi Website berhasil diperbarui.');
        $this->redirect('admin/superadmin/qris');
    }
}
