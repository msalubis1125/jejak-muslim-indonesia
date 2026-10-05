<?php

class UserMgmtController extends Controller {
    public function __construct() {
        Auth::requireLogin();
        Auth::requireRole('super_admin');
    }

    public function index() {
        $userModel = $this->model('UserModel');
        $role = $_GET['role'] ?? '';
        
        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $userModel->getAllFiltered($role),
            'role_filter' => $role
        ];
        $this->view('admin/superadmin/user-management', $data);
    }

    public function toggleActive($id) {
        if ($this->isPost()) {
            $userModel = $this->model('UserModel');
            $user = $userModel->findById($id);
            if ($user && $user['id'] !== Auth::user()['id']) {
                $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
                $userModel->updateStatus($id, $newStatus);
                Session::flash('success', 'Status pengguna berhasil diubah.');
            }
        }
        $this->redirect('admin/superadmin/usermgmt');
    }

    public function resetPassword($id) {
        if ($this->isPost()) {
            $userModel = $this->model('UserModel');
            $tempPassword = bin2hex(random_bytes(4)); // 8 chars
            $hashed = password_hash($tempPassword, PASSWORD_BCRYPT);
            
            $userModel->updatePassword($id, $hashed);
            Session::flash('success', "Password direset. Password sementara: $tempPassword");
        }
        $this->redirect('admin/superadmin/usermgmt');
    }

    public function loginAs($id) {
        if ($this->isPost()) {
            $userModel = $this->model('UserModel');
            $targetUser = $userModel->findById($id);
            
            if ($targetUser && $targetUser['role'] === 'takmir') {
                $_SESSION['original_super_admin'] = $_SESSION['user'];
                $_SESSION['user'] = $targetUser;
                $this->redirect('admin/dashboard');
            }
        }
        $this->redirect('admin/superadmin/usermgmt');
    }

    public function returnFromLoginAs() {
        if (isset($_SESSION['original_super_admin'])) {
            $_SESSION['user'] = $_SESSION['original_super_admin'];
            unset($_SESSION['original_super_admin']);
            $this->redirect('admin/superadmin/usermgmt');
        }
        $this->redirect('admin/dashboard');
    }
}
