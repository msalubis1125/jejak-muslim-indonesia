<?php

class KegiatanMgmtController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        $this->masjidId = Auth::isSuperAdmin() ? ($_GET['masjid_id'] ?? null) : Auth::getMasjidId();
    }

    public function index() {
        $kegiatanModel = $this->model('KegiatanModel');
        $data = [
            'title' => 'Manajemen Kegiatan',
            'kegiatan_list' => $kegiatanModel->getAllByMasjid($this->masjidId)
        ];
        $this->view('admin/kegiatan/index', $data);
    }

    public function create() {
        $data = ['title' => 'Tambah Kegiatan'];
        $this->view('admin/kegiatan/form', $data);
    }

    public function store() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/kegiatanmgmt');
        }

        $kegiatanModel = $this->model('KegiatanModel');
        
        $data = [
            'masjid_id' => $this->masjidId,
            'judul' => $_POST['judul'],
            'deskripsi' => $_POST['deskripsi'] ?? '',
            'tanggal_mulai' => $_POST['tanggal_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'],
            'waktu' => $_POST['waktu'] ?? '',
            'perlu_daftar' => isset($_POST['perlu_daftar']) ? 1 : 0,
            'kuota' => $_POST['kuota'] ?? 0
        ];

        // Handle poster upload
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
            $upload = FileUploader::uploadImage($_FILES['poster'], 'kegiatan', 'poster_');
            if ($upload['success']) {
                $data['poster'] = $upload['fileName'];
            } else {
                Session::flash('error', $upload['error'] ?? 'Gagal mengunggah poster kegiatan.');
                $this->redirect('admin/kegiatanmgmt');
                return;
            }
        }

        try {
            $kegiatanModel->create($data);
            Session::flash('success', 'Kegiatan berhasil ditambahkan.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menambahkan kegiatan.');
        }

        $this->redirect('admin/kegiatanmgmt');
    }

    public function edit($id) {
        $kegiatanModel = $this->model('KegiatanModel');
        $kegiatan = $kegiatanModel->findByIdAndMasjid($id, $this->masjidId);
        
        if (!$kegiatan) {
            $this->redirect('admin/kegiatanmgmt');
        }

        $data = [
            'title' => 'Edit Kegiatan',
            'kegiatan' => $kegiatan
        ];
        $this->view('admin/kegiatan/form', $data);
    }

    public function update($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/kegiatanmgmt');
        }

        $kegiatanModel = $this->model('KegiatanModel');
        
        $data = [
            'judul' => $_POST['judul'],
            'deskripsi' => $_POST['deskripsi'] ?? '',
            'tanggal_mulai' => $_POST['tanggal_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'],
            'waktu' => $_POST['waktu'] ?? '',
            'perlu_daftar' => isset($_POST['perlu_daftar']) ? 1 : 0,
            'kuota' => $_POST['kuota'] ?? 0
        ];

        if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
            $upload = FileUploader::uploadImage($_FILES['poster'], 'kegiatan', 'poster_');
            if ($upload['success']) {
                $data['poster'] = $upload['fileName'];
            } else {
                Session::flash('error', $upload['error'] ?? 'Gagal memperbarui poster kegiatan.');
                $this->redirect('admin/kegiatanmgmt');
                return;
            }
        }

        try {
            $kegiatanModel->updateAndCheckMasjid($id, $this->masjidId, $data);
            Session::flash('success', 'Kegiatan berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui kegiatan.');
        }

        $this->redirect('admin/kegiatanmgmt');
    }

    public function delete($id) {
        if ($this->isPost()) {
            $kegiatanModel = $this->model('KegiatanModel');
            $kegiatanModel->softDelete($id, $this->masjidId);
            Session::flash('success', 'Kegiatan berhasil dihapus.');
        }
        $this->redirect('admin/kegiatanmgmt');
    }

    public function peserta($id) {
        $pendaftaranModel = $this->model('PendaftaranModel');
        $kegiatanModel = $this->model('KegiatanModel');
        
        $kegiatan = $kegiatanModel->findByIdAndMasjid($id, $this->masjidId);
        if (!$kegiatan) {
            $this->redirect('admin/kegiatanmgmt');
        }

        $data = [
            'title' => 'Daftar Peserta Kegiatan',
            'kegiatan' => $kegiatan,
            'peserta_list' => $pendaftaranModel->getAllByKegiatan($id)
        ];

        $this->view('admin/kegiatan/peserta', $data);
    }
}
