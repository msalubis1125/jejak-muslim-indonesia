<?php

class KegiatanController extends Controller {
    public function index() {
        $kegiatanModel = $this->model('KegiatanModel');
        $masjidId = $_GET['masjid_id'] ?? null;
        $page = (int)($_GET['page'] ?? 1);
        
        $data = [
            'title' => 'Daftar Kegiatan Masjid',
            'kegiatan_list' => $kegiatanModel->getUpcomingPaginated($masjidId, $page, 10),
            'masjid_id' => $masjidId,
            'page' => $page
        ];
        
        $this->view('public/kegiatan-list', $data);
    }

    public function detail($id) {
        $kegiatanModel = $this->model('KegiatanModel');
        $kegiatan = $kegiatanModel->findById($id);
        
        if (!$kegiatan) {
            $this->redirect('kegiatan');
        }

        $data = [
            'title' => 'Detail Kegiatan - ' . htmlspecialchars($kegiatan['judul']),
            'kegiatan' => $kegiatan
        ];
        
        $this->view('public/kegiatan-detail', $data);
    }

    public function daftar($id = null) {
        $id = $id ?? ($_POST['kegiatan_id'] ?? null);
        if (!$id) {
            $this->redirect('kegiatan');
        }

        if (!$this->isPost()) {
            $this->redirect("kegiatan/$id");
        }
        
        if (!CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Token keamanan tidak valid.');
            $this->redirect("kegiatan/$id");
        }

        $kegiatanModel = $this->model('KegiatanModel');
        $pendaftaranModel = $this->model('PendaftaranModel');
        
        $kegiatan = $kegiatanModel->findById($id);
        if (!$kegiatan || empty($kegiatan['perlu_daftar'])) {
            Session::flash('error', 'Kegiatan ini tidak memerlukan pendaftaran.');
            $this->redirect("kegiatan/$id");
        }

        // Check quota
        $terdaftar = $pendaftaranModel->countByKegiatan($id);
        if ($kegiatan['kuota'] > 0 && $terdaftar >= $kegiatan['kuota']) {
            Session::flash('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
            $this->redirect("kegiatan/$id");
        }

        $v = new Validator();
        $result = $v->validate($_POST, [
            'nama' => 'required',
            'no_hp' => 'required'
        ]);

        if (!$result['valid']) {
            Session::flash('error', 'Harap isi semua kolom wajib.');
            $this->redirect("kegiatan/$id");
        }

        try {
            $user = Auth::user();
            $userId = $user ? (is_array($user) ? ($user['id'] ?? null) : ($user->id ?? null)) : null;
            $pendaftaranModel->create([
                'kegiatan_id' => $id,
                'user_id' => $userId,
                'nama_peserta' => $_POST['nama'],
                'no_hp' => $_POST['no_hp'],
                'status' => 'registered'
            ]);
            
            Session::flash('success', 'Alhamdulillah, Anda berhasil mendaftar kegiatan ini!');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
        
        $this->redirect("kegiatan/$id");
    }
}
