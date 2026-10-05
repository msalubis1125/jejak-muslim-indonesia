<?php

class DonasiMgmtController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        $this->masjidId = Auth::isSuperAdmin() ? ($_GET['masjid_id'] ?? null) : Auth::getMasjidId();
    }

    public function index() {
        $donasiModel = $this->model('DonasiModel');
        $data = [
            'title' => 'Pengaturan Donasi',
            'rekening' => $donasiModel->getRekeningByMasjid($this->masjidId),
            'qris' => $donasiModel->getQrisByMasjid($this->masjidId)
        ];
        $this->view('admin/donasi-settings/index', $data);
    }

    public function storeRekening() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/donasimgmt');
        }

        $donasiModel = $this->model('DonasiModel');
        try {
            $donasiModel->createRekening([
                'masjid_id' => $this->masjidId,
                'bank' => $_POST['bank'],
                'nomor_rekening' => $_POST['nomor_rekening'],
                'atas_nama' => $_POST['atas_nama'],
                'is_active' => 1
            ]);
            Session::flash('success', 'Rekening berhasil ditambahkan.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menambahkan rekening.');
        }
        $this->redirect('admin/donasimgmt');
    }

    public function updateRekening($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/donasimgmt');
        }

        $donasiModel = $this->model('DonasiModel');
        try {
            $donasiModel->updateRekening($id, $this->masjidId, [
                'bank' => $_POST['bank'],
                'nomor_rekening' => $_POST['nomor_rekening'],
                'atas_nama' => $_POST['atas_nama'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ]);
            Session::flash('success', 'Rekening berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui rekening.');
        }
        $this->redirect('admin/donasimgmt');
    }

    public function deleteRekening($id) {
        if ($this->isPost()) {
            $donasiModel = $this->model('DonasiModel');
            $donasiModel->deleteRekening($id, $this->masjidId);
            Session::flash('success', 'Rekening dinonaktifkan.');
        }
        $this->redirect('admin/donasimgmt');
    }

    public function uploadQris() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/donasimgmt');
        }

        if (isset($_FILES['qris_image']) && $_FILES['qris_image']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['qris_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png']) && $_FILES['qris_image']['size'] <= 2000000) {
                $newName = uniqid('qris_') . '.' . $ext;
                if (move_uploaded_file($_FILES['qris_image']['tmp_name'], 'uploads/qris/' . $newName)) {
                    $donasiModel = $this->model('DonasiModel');
                    $donasiModel->updateQris($this->masjidId, $newName);
                    Session::flash('success', 'QRIS berhasil diperbarui.');
                }
            } else {
                Session::flash('error', 'File tidak valid atau terlalu besar.');
            }
        }
        $this->redirect('admin/donasimgmt');
    }

    public function deleteQris() {
        if ($this->isPost()) {
            $donasiModel = $this->model('DonasiModel');
            $donasiModel->removeQris($this->masjidId);
            Session::flash('success', 'QRIS berhasil dihapus.');
        }
        $this->redirect('admin/donasimgmt');
    }
}
