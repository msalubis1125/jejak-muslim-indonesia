<?php

class AsetController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        $this->masjidId = Auth::isSuperAdmin() ? ($_GET['masjid_id'] ?? null) : Auth::getMasjidId();
    }

    public function index() {
        $asetModel = $this->model('AsetModel');
        $kategori = $_GET['kategori'] ?? null;
        $kondisi = $_GET['kondisi'] ?? null;

        $data = [
            'title' => 'Manajemen Aset',
            'aset_list' => $asetModel->getAllFiltered($this->masjidId, $kategori, $kondisi)
        ];
        $this->view('admin/aset/index', $data);
    }

    public function create() {
        $data = ['title' => 'Tambah Aset'];
        $this->view('admin/aset/form', $data);
    }

    public function store() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/aset');
        }

        $asetModel = $this->model('AsetModel');
        try {
            $asetModel->create([
                'masjid_id' => $this->masjidId,
                'nama_aset' => $_POST['nama_aset'],
                'kategori' => $_POST['kategori'],
                'jumlah' => $_POST['jumlah'],
                'kondisi' => $_POST['kondisi'],
                'tanggal_diperoleh' => $_POST['tanggal_diperoleh'],
                'keterangan' => $_POST['keterangan'] ?? ''
            ]);
            Session::flash('success', 'Aset berhasil ditambahkan.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menambahkan aset.');
        }
        $this->redirect('admin/aset');
    }

    public function edit($id) {
        $asetModel = $this->model('AsetModel');
        $aset = $asetModel->findByIdAndMasjid($id, $this->masjidId);
        if (!$aset) {
            $this->redirect('admin/aset');
        }

        $data = [
            'title' => 'Edit Aset',
            'aset' => $aset
        ];
        $this->view('admin/aset/form', $data);
    }

    public function update($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/aset');
        }

        $asetModel = $this->model('AsetModel');
        try {
            $asetModel->update($id, $this->masjidId, [
                'nama_aset' => $_POST['nama_aset'],
                'kategori' => $_POST['kategori'],
                'jumlah' => $_POST['jumlah'],
                'kondisi' => $_POST['kondisi'],
                'tanggal_diperoleh' => $_POST['tanggal_diperoleh'],
                'keterangan' => $_POST['keterangan'] ?? ''
            ]);
            Session::flash('success', 'Aset berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui aset.');
        }
        $this->redirect('admin/aset');
    }

    public function delete($id) {
        if ($this->isPost()) {
            $asetModel = $this->model('AsetModel');
            $asetModel->softDelete($id, $this->masjidId);
            Session::flash('success', 'Aset berhasil dihapus.');
        }
        $this->redirect('admin/aset');
    }
}
