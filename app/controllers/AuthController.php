<?php

class AuthController extends Controller {
    public function login() {
        if (Auth::check()) {
            $this->redirect('');
        }

        if ($this->isPost()) {
            if (!CSRF::verify($_POST['csrf_token'] ?? '')) {
                Session::flash('error', 'Token keamanan tidak valid.');
                $this->redirect('auth/login');
            }

            $v = new Validator();
            $result = $v->validate($_POST, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (!$result['valid']) {
                Session::flash('error', 'Email dan password harus diisi.');
                $this->redirect('auth/login');
            }

            $userModel = $this->model('UserModel');
            $user = $userModel->findByEmail(trim($_POST['email'] ?? ''));

            $hash = $user['password_hash'] ?? ($user['password'] ?? '');

            if ($user && !empty($hash) && password_verify($_POST['password'], $hash)) {
                $isActive = isset($user['is_active']) ? (int)$user['is_active'] : (($user['status'] ?? '') === 'active' ? 1 : 0);
                if (!$isActive) {
                    Session::flash('error', 'Akun Anda dinonaktifkan. Silakan hubungi pengelola.');
                    $this->redirect('auth/login');
                }

                session_regenerate_id(true);
                Session::setUser($user);
                
                if ($user['role'] === 'super_admin' || $user['role'] === 'takmir') {
                    $this->redirect('admin/dashboard');
                } else {
                    $this->redirect('');
                }
            } else {
                Session::flash('error', 'Email atau password yang Anda masukkan salah.');
                $this->redirect('auth/login');
            }
        }

        $this->view('auth/login', ['title' => 'Login']);
    }

    public function register() {
        if (Auth::check()) {
            $this->redirect('');
        }

        if ($this->isPost()) {
            if (!CSRF::verify($_POST['csrf_token'] ?? '')) {
                Session::flash('error', 'Token keamanan tidak valid.');
                $this->redirect('auth/register');
            }

            $v = new Validator();
            $result = $v->validate($_POST, [
                'nama' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'no_hp' => 'required',
                'nama_masjid' => 'required'
            ]);

            if (!$result['valid']) {
                Session::flash('error', 'Harap lengkapi semua kolom dengan benar.');
                $this->redirect('auth/register');
            }

            $userModel = $this->model('UserModel');
            if ($userModel->findByEmail($_POST['email'])) {
                Session::flash('error', 'Email sudah terdaftar.');
                $this->redirect('auth/register');
            }

            try {
                $masjidModel = $this->model('MasjidModel');
                $namaMasjid = trim($_POST['nama_masjid']);
                $slug = $masjidModel->generateSlug($namaMasjid);

                $masjidId = $masjidModel->create([
                    'nama' => $namaMasjid,
                    'slug' => $slug,
                    'alamat' => $_POST['alamat'] ?? '',
                    'kota' => $_POST['kota'] ?? '',
                    'provinsi' => $_POST['provinsi'] ?? '',
                    'no_hp_takmir' => $_POST['no_hp'] ?? '',
                    'status' => 'pending'
                ]);

                $userModel->create([
                    'nama' => $_POST['nama'],
                    'email' => $_POST['email'],
                    'password_hash' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                    'no_hp' => $_POST['no_hp'] ?? '',
                    'role' => 'takmir',
                    'masjid_id' => $masjidId,
                    'is_active' => 1
                ]);

                Session::flash('success', 'Pendaftaran takmir dan masjid berhasil! Menunggu peninjauan & verifikasi oleh Super Admin.');
                $this->redirect('auth/login');
            } catch (Exception $e) {
                Session::flash('error', 'Terjadi kesalahan. Silakan coba lagi.');
                $this->redirect('auth/register');
            }
        }

        $this->view('auth/register', ['title' => 'Registrasi']);
    }

    public function logout() {
        session_destroy();
        $this->redirect('');
    }
}
