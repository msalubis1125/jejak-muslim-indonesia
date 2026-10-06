<?php

class ArtikelMgmtController extends Controller {
    private $masjidId = null;

    public function __construct() {
        Auth::requireLogin();
        
        $user = Auth::user();
        if ($user['role'] === 'takmir') {
            $this->masjidId = $user['masjid_id'];
            if (!$this->masjidId) {
                Session::flash('error', 'Akun Takmir Anda belum terhubung dengan data masjid.');
                $this->redirect('admin/dashboard');
                exit;
            }
        }
    }

    public function index() {
        $artikelModel = $this->model('ArtikelModel');
        $artikels = $artikelModel->getAllByMasjid($this->masjidId);

        $data = [
            'title' => 'Manajemen Artikel & Buletin',
            'currentMenu' => 'artikel',
            'artikels' => $artikels
        ];
        $this->view('admin/artikel/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tulis Artikel / Buletin Baru',
            'currentMenu' => 'artikel',
            'artikel' => null
        ];
        $this->view('admin/artikel/form', $data);
    }

    public function store() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Token keamanan tidak valid.');
            $this->redirect('admin/artikelmgmt');
            return;
        }

        $v = new Validator();
        $validation = $v->validate($_POST, [
            'judul' => 'required',
            'konten' => 'required',
            'kategori' => 'required'
        ]);

        if (!$validation['valid']) {
            Session::flash('error', 'Judul, kategori, dan isi konten wajib diisi.');
            $this->redirect('admin/artikelmgmt/create');
            return;
        }

        $artikelModel = $this->model('ArtikelModel');
        $slug = $artikelModel->generateSlug($_POST['judul']);

        $data = [
            'masjid_id' => $this->masjidId, // Null for super_admin global article, or Takmir's masjid_id
            'judul' => trim($_POST['judul']),
            'slug' => $slug,
            'kategori' => trim($_POST['kategori']),
            'konten' => trim($_POST['konten']),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
            'published_at' => isset($_POST['is_published']) ? date('Y-m-d H:i:s') : null,
            'is_deleted' => 0
        ];

        // Handle gambar upload
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $upload = FileUploader::uploadImage($_FILES['gambar'], 'artikel', 'artikel_');
            if ($upload['success']) {
                $data['gambar'] = 'public/uploads/artikel/' . $upload['fileName'];
            } else {
                Session::flash('error', $upload['error'] ?? 'Gagal mengunggah gambar artikel.');
                $this->redirect('admin/artikelmgmt/create');
                return;
            }
        } elseif (!empty($_POST['gambar_url'])) {
            $data['gambar'] = trim($_POST['gambar_url']);
        }

        try {
            $artikelModel->create($data);
            Session::flash('success', 'Artikel berhasil disimpan.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menyimpan artikel: ' . $e->getMessage());
        }

        $this->redirect('admin/artikelmgmt');
    }

    public function edit($id) {
        $artikelModel = $this->model('ArtikelModel');
        $artikel = $artikelModel->findByIdAndMasjid((int)$id, $this->masjidId);

        if (!$artikel) {
            Session::flash('error', 'Artikel tidak ditemukan atau Anda tidak memiliki akses.');
            $this->redirect('admin/artikelmgmt');
            return;
        }

        $data = [
            'title' => 'Edit Artikel',
            'currentMenu' => 'artikel',
            'artikel' => $artikel
        ];
        $this->view('admin/artikel/form', $data);
    }

    public function update($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Token keamanan tidak valid.');
            $this->redirect('admin/artikelmgmt');
            return;
        }

        $artikelModel = $this->model('ArtikelModel');
        $artikel = $artikelModel->findByIdAndMasjid((int)$id, $this->masjidId);

        if (!$artikel) {
            Session::flash('error', 'Akses ditolak atau artikel tidak ditemukan.');
            $this->redirect('admin/artikelmgmt');
            return;
        }

        $slug = $artikelModel->generateSlug($_POST['judul'], (int)$id);

        $data = [
            'judul' => trim($_POST['judul']),
            'slug' => $slug,
            'kategori' => trim($_POST['kategori']),
            'konten' => trim($_POST['konten']),
            'is_published' => isset($_POST['is_published']) ? 1 : 0
        ];

        if (isset($_POST['is_published']) && empty($artikel['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        // Handle Image Upload
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $upload = FileUploader::uploadImage($_FILES['gambar'], 'artikel', 'artikel_');
            if ($upload['success']) {
                $data['gambar'] = 'public/uploads/artikel/' . $upload['fileName'];
            } else {
                Session::flash('error', $upload['error'] ?? 'Gagal mengunggah gambar artikel.');
                $this->redirect('admin/artikelmgmt/edit/' . (int)$id);
                return;
            }
        } elseif (!empty($_POST['gambar_url'])) {
            $data['gambar'] = trim($_POST['gambar_url']);
        }

        try {
            $artikelModel->update((int)$id, $data);
            Session::flash('success', 'Artikel berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui artikel.');
        }

        $this->redirect('admin/artikelmgmt');
    }

    public function togglePublish($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/artikelmgmt');
            return;
        }

        $artikelModel = $this->model('ArtikelModel');
        $artikel = $artikelModel->findByIdAndMasjid((int)$id, $this->masjidId);

        if ($artikel) {
            if ($artikel['is_published']) {
                $artikelModel->unpublish((int)$id);
                Session::flash('success', 'Status artikel diubah menjadi Draft.');
            } else {
                $artikelModel->publish((int)$id);
                Session::flash('success', 'Artikel berhasil dipublikasikan.');
            }
        }
        $this->redirect('admin/artikelmgmt');
    }

    public function delete($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Permintaan tidak valid.');
            $this->redirect('admin/artikelmgmt');
            return;
        }

        $artikelModel = $this->model('ArtikelModel');
        $artikel = $artikelModel->findByIdAndMasjid((int)$id, $this->masjidId);

        if (!$artikel) {
            Session::flash('error', 'Akses ditolak atau artikel tidak ditemukan.');
            $this->redirect('admin/artikelmgmt');
            return;
        }

        $artikelModel->softDelete((int)$id, $this->masjidId);
        Session::flash('success', 'Artikel berhasil dihapus.');
        $this->redirect('admin/artikelmgmt');
    }
}
