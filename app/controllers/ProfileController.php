<?php

class ProfileController extends Controller {
    public function __construct() {
        Auth::requireLogin();
    }

    public function index() {
        $user = Auth::user();
        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        if ($user['role'] === 'jamaah') {
            $masjidModel = $this->model('MasjidModel');
            $pendaftaranModel = $this->model('PendaftaranModel');
            
            $data['favorites'] = $masjidModel->getFavorites($user['id']);
            $data['registered_events'] = $pendaftaranModel->getByUser($user['id']);
        }

        $this->view('public/profile', $data);
    }

    public function update() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('profile');
        }

        $v = new Validator();
        $result = $v->validate($_POST, [
            'nama' => 'required',
            'no_hp' => 'required'
        ]);

        if ($result['valid']) {
            $userModel = $this->model('UserModel');
            $userId = Auth::user()['id'];
            
            $userModel->update($userId, [
                'nama' => $_POST['nama'],
                'no_hp' => $_POST['no_hp']
            ]);
            
            $_SESSION['user']['nama'] = $_POST['nama'];
            $_SESSION['user']['no_hp'] = $_POST['no_hp'];
            
            Session::flash('success', 'Profil berhasil diperbarui.');
        } else {
            Session::flash('error', 'Gagal memperbarui profil.');
        }

        $this->redirect('profile');
    }

    public function favorites() {
        if (!$this->isAjax() || !$this->isPost()) {
            return $this->json(['error' => 'Invalid request'], 400);
        }

        $masjidId = $_POST['masjid_id'] ?? null;
        $userId = Auth::user()['id'];
        
        $masjidModel = $this->model('MasjidModel');
        $result = $masjidModel->toggleFavorite($userId, $masjidId);
        
        return $this->json(['status' => 'success', 'is_favorite' => $result]);
    }
}
