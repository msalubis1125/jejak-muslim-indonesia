<?php

class JadwalPetugasController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        $this->masjidId = Auth::isSuperAdmin() ? ($_GET['masjid_id'] ?? 1) : (Auth::getMasjidId() ?? 1);
    }

    public function index() {
        $jadwalModel = $this->model('JadwalPetugasModel');
        $bulan = $_GET['bulan'] ?? date('m');
        $tahun = $_GET['tahun'] ?? date('Y');

        $data = [
            'title' => 'Jadwal Petugas Shalat & Khutbah',
            'jadwal_list' => $jadwalModel->getMonthly($this->masjidId, $bulan, $tahun),
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        $this->view('admin/jadwal-petugas/index', $data);
    }

    public function create() {
        $data = ['title' => 'Tambah Jadwal Petugas'];
        $this->view('admin/jadwal-petugas/form', $data);
    }

    public function store() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/jadwalpetugas');
        }

        $jadwalModel = $this->model('JadwalPetugasModel');
        try {
            $jadwalModel->createFlexible(array_merge($_POST, ['masjid_id' => $this->masjidId]));
            Session::flash('success', 'Jadwal petugas berhasil ditambahkan.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menambahkan jadwal petugas: ' . $e->getMessage());
        }
        $this->redirect('admin/jadwalpetugas');
    }

    public function edit($id) {
        $jadwalModel = $this->model('JadwalPetugasModel');
        $jadwal = $jadwalModel->findByIdAndMasjid($id, $this->masjidId);
        
        if (!$jadwal) {
            $this->redirect('admin/jadwalpetugas');
        }

        $data = [
            'title' => 'Edit Jadwal Petugas',
            'jadwal' => $jadwal
        ];
        $this->view('admin/jadwal-petugas/form', $data);
    }

    public function update($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/jadwalpetugas');
        }

        $jadwalModel = $this->model('JadwalPetugasModel');
        try {
            $jadwalModel->updateFlexible($id, $this->masjidId, $_POST);
            Session::flash('success', 'Jadwal petugas berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui jadwal petugas.');
        }
        $this->redirect('admin/jadwalpetugas');
    }

    public function delete($id) {
        if ($this->isPost()) {
            $jadwalModel = $this->model('JadwalPetugasModel');
            $jadwalModel->delete($id, $this->masjidId); // hard delete or soft delete
            Session::flash('success', 'Jadwal berhasil dihapus.');
        }
        $this->redirect('admin/jadwalpetugas');
    }
}
