<?php

class MasterDataController extends Controller {
    public function __construct() {
        Auth::requireLogin();
        Auth::requireRole('super_admin');
    }

    public function index() {
        $keuanganModel = $this->model('KeuanganModel');
        $data = [
            'title' => 'Master Data (Kategori Keuangan)',
            'kategori_list' => $keuanganModel->getKategoriList()
        ];
        $this->view('admin/superadmin/master-data', $data);
    }

    public function storeKategori() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/superadmin/masterdata');
        }
        
        $keuanganModel = $this->model('KeuanganModel');
        try {
            $keuanganModel->createKategori([
                'nama_kategori' => $_POST['nama_kategori'],
                'tipe_default' => $_POST['tipe_default']
            ]);
            Session::flash('success', 'Kategori berhasil ditambahkan.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menambahkan kategori.');
        }
        $this->redirect('admin/superadmin/masterdata');
    }

    public function updateKategori($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/superadmin/masterdata');
        }

        $keuanganModel = $this->model('KeuanganModel');
        try {
            $keuanganModel->updateKategori($id, [
                'nama_kategori' => $_POST['nama_kategori'],
                'tipe_default' => $_POST['tipe_default']
            ]);
            Session::flash('success', 'Kategori berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui kategori.');
        }
        $this->redirect('admin/superadmin/masterdata');
    }

    public function deleteKategori($id) {
        if ($this->isPost()) {
            $keuanganModel = $this->model('KeuanganModel');
            $keuanganModel->deleteKategori($id);
            Session::flash('success', 'Kategori berhasil dihapus.');
        }
        $this->redirect('admin/superadmin/masterdata');
    }
}
