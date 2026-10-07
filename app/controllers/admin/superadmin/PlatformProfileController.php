<?php

class PlatformProfileController extends Controller {
    public function __construct() {
        Auth::requireLogin();
        Auth::requireRole('super_admin');
    }

    public function index() {
        $pengaturanModel = $this->model('PengaturanModel');
        $profile = $pengaturanModel->getPlatformProfile();

        $data = [
            'title' => 'Kelola Profil Platform Jejak Muslim Indonesia',
            'currentMenu' => 'platform_profile',
            'profile' => $profile
        ];

        $this->view('admin/superadmin/platform-profile', $data);
    }

    public function update() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Token keamanan tidak valid.');
            $this->redirect('admin/superadmin/profil');
            return;
        }

        $pengaturanModel = $this->model('PengaturanModel');
        
        $data = [
            'app_name' => $_POST['app_name'] ?? 'Jejak Muslim Indonesia',
            'app_tagline' => $_POST['app_tagline'] ?? '',
            'app_about' => $_POST['app_about'] ?? '',
            'app_email' => $_POST['app_email'] ?? '',
            'app_phone' => $_POST['app_phone'] ?? '',
            'app_address' => $_POST['app_address'] ?? '',
            'app_facebook' => $_POST['app_facebook'] ?? '',
            'app_instagram' => $_POST['app_instagram'] ?? '',
            'app_youtube' => $_POST['app_youtube'] ?? '',
            'app_whatsapp' => $_POST['app_whatsapp'] ?? ''
        ];

        $pengaturanModel->updatePlatformProfile($data);
        Session::flash('success', 'Profil platform Jejak Muslim Indonesia berhasil diperbarui.');
        $this->redirect('admin/superadmin/profil');
    }
}
