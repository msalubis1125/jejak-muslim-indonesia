<?php

class ProfileController extends Controller {
    public function __construct() {
        Auth::requireLogin();
    }

    public function index() {
        $user = Auth::user();
        $userModel = $this->model('UserModel');
        $userData = $userModel->findById($user['id']);

        $data = [
            'title' => 'Pengaturan Profil & Keamanan Akun',
            'currentMenu' => 'profile',
            'user' => $userData
        ];

        $this->view('admin/profile', $data);
    }

    public function update() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Token keamanan tidak valid.');
            $this->redirect('profile');
            return;
        }

        $v = new Validator();
        $result = $v->validate($_POST, [
            'nama' => 'required',
            'email' => 'required|email'
        ]);

        if (!$result['valid']) {
            Session::flash('error', 'Nama dan Email wajib diisi dengan format yang benar.');
            $this->redirect('profile');
            return;
        }

        $userModel = $this->model('UserModel');
        $userId = Auth::user()['id'];
        $email = trim($_POST['email']);

        // Check unique email if changed
        $existing = $userModel->findByEmail($email);
        if ($existing && (int)$existing['id'] !== (int)$userId) {
            Session::flash('error', 'Alamat email sudah digunakan oleh akun lain.');
            $this->redirect('profile');
            return;
        }

        $updateData = [
            'nama' => trim($_POST['nama']),
            'email' => $email,
            'no_hp' => trim($_POST['no_hp'] ?? '')
        ];

        try {
            $userModel->update($userId, $updateData);
            $_SESSION['user']['nama'] = $updateData['nama'];
            $_SESSION['user']['email'] = $updateData['email'];
            $_SESSION['user']['no_hp'] = $updateData['no_hp'];

            Session::flash('success', 'Profil akun berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }

        $this->redirect('profile');
    }

    public function updatePassword() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Token keamanan tidak valid.');
            $this->redirect('profile');
            return;
        }

        $oldPassword = $_POST['password_lama'] ?? '';
        $newPassword = $_POST['password_baru'] ?? '';
        $confirmPassword = $_POST['konfirmasi_password'] ?? '';

        if (empty($oldPassword) || empty($newPassword)) {
            Session::flash('error', 'Password lama dan password baru wajib diisi.');
            $this->redirect('profile');
            return;
        }

        if (strlen($newPassword) < 6) {
            Session::flash('error', 'Password baru minimal harus 6 karakter.');
            $this->redirect('profile');
            return;
        }

        if ($newPassword !== $confirmPassword) {
            Session::flash('error', 'Konfirmasi password baru tidak cocok.');
            $this->redirect('profile');
            return;
        }

        $userModel = $this->model('UserModel');
        $userId = Auth::user()['id'];
        $user = $userModel->findById($userId);

        $currentHash = $user['password_hash'] ?? ($user['password'] ?? '');

        if (!password_verify($oldPassword, $currentHash)) {
            Session::flash('error', 'Password lama yang Anda masukkan salah.');
            $this->redirect('profile');
            return;
        }

        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $userModel->updatePassword($userId, $hashed);

        Session::flash('success', 'Password akun Anda berhasil diganti.');
        $this->redirect('profile');
    }
}
