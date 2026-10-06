<?php

class MasjidMgmtController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        if (Auth::isTakmir()) {
            $this->masjidId = Auth::getMasjidId();
        }
    }

    public function index() {
        // If super admin, they might pass an ID. For takmir, strictly their own.
        $id = Auth::isSuperAdmin() ? ($_GET['id'] ?? null) : $this->masjidId;
        
        if (!$id) {
            $this->redirect('admin/dashboard');
        }

        $masjidModel = $this->model('MasjidModel');
        $data = [
            'title' => 'Profil Masjid',
            'masjid' => $masjidModel->findById($id),
            'fasilitas_list' => $masjidModel->getAllFasilitasMaster(),
            'masjid_fasilitas' => $masjidModel->getFasilitasIds($id)
        ];

        $this->view('admin/masjid-form', $data);
    }

    public function save() {
        return $this->update();
    }

    public function update() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/masjid');
        }

        $id = Auth::isSuperAdmin() ? ($_POST['masjid_id'] ?? $this->masjidId) : $this->masjidId;
        $masjidModel = $this->model('MasjidModel');
        
        $dataUpdate = [
            'nama' => trim($_POST['nama'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'kota' => trim($_POST['kota'] ?? ''),
            'provinsi' => trim($_POST['provinsi'] ?? ''),
            'sejarah' => trim($_POST['sejarah'] ?? ''),
            'visi_misi' => trim($_POST['visi_misi'] ?? ''),
            'no_hp_takmir' => trim($_POST['no_hp_takmir'] ?? ''),
            'wa_link' => trim($_POST['wa_link'] ?? ''),
            'buka_24jam' => isset($_POST['buka_24jam']) ? 1 : 0
        ];

        if (!empty($_POST['latitude'])) {
            $dataUpdate['latitude'] = (float)$_POST['latitude'];
        }
        if (!empty($_POST['longitude'])) {
            $dataUpdate['longitude'] = (float)$_POST['longitude'];
        }
        if (!empty($_POST['kapasitas'])) {
            $dataUpdate['kapasitas'] = (int)$_POST['kapasitas'];
        }
        if (!empty($_POST['jeda_iqomah_menit'])) {
            $dataUpdate['jeda_iqomah_menit'] = (int)$_POST['jeda_iqomah_menit'];
        }

        // Handle File Upload for foto_utama
        if (isset($_FILES['foto_utama']) && $_FILES['foto_utama']['error'] == 0) {
            $upload = FileUploader::uploadImage($_FILES['foto_utama'], 'masjid', 'masjid_');
            if ($upload['success']) {
                $dataUpdate['foto_utama'] = $upload['fileName'];
            } else {
                Session::flash('error', $upload['error'] ?? 'Gagal mengunggah foto masjid.');
                $this->redirect('admin/masjid');
                return;
            }
        }

        try {
            $masjidModel->update($id, $dataUpdate);
            $masjidModel->syncFasilitas($id, $_POST['fasilitas'] ?? []);
            Session::flash('success', 'Data profil masjid dan koordinat peta berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui data masjid: ' . $e->getMessage());
        }

        $this->redirect('admin/masjid');
    }

    public function galeri() {
        $id = Auth::isSuperAdmin() ? ($_GET['id'] ?? null) : $this->masjidId;
        $masjidModel = $this->model('MasjidModel');
        
        $data = [
            'title' => 'Galeri Masjid',
            'galeri' => $masjidModel->getGaleri($id),
            'masjid_id' => $id
        ];
        
        $this->view('admin/masjid-galeri', $data);
    }

    public function uploadGaleri() {
        if (!$this->isPost()) {
            $this->redirect('admin/masjidmgmt/galeri');
        }

        $id = Auth::isSuperAdmin() ? $_POST['masjid_id'] : $this->masjidId;
        
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $upload = FileUploader::uploadImage($_FILES['foto'], 'masjid', 'galeri_');
            if ($upload['success']) {
                $masjidModel = $this->model('MasjidModel');
                $masjidModel->addGaleri($id, $upload['fileName'], $_POST['keterangan'] ?? '');
                Session::flash('success', 'Foto berhasil diunggah.');
            } else {
                Session::flash('error', $upload['error'] ?? 'Gagal mengunggah foto galeri.');
            }
        }
        $this->redirect('admin/masjidmgmt/galeri');
    }

    public function deleteGaleri($fotoId) {
        if ($this->isPost()) {
            $masjidModel = $this->model('MasjidModel');
            $id = Auth::isSuperAdmin() ? $_POST['masjid_id'] : $this->masjidId;
            $masjidModel->deleteGaleri($id, $fotoId);
            Session::flash('success', 'Foto berhasil dihapus.');
        }
        $this->redirect('admin/masjidmgmt/galeri');
    }

    public function updateKoordinat() {
        if (!$this->isAjax() || !$this->isPost()) {
            return $this->json(['error' => 'Invalid request'], 400);
        }

        $id = Auth::isSuperAdmin() ? $_POST['masjid_id'] : $this->masjidId;
        $masjidModel = $this->model('MasjidModel');
        
        $masjidModel->update($id, [
            'latitude' => $_POST['latitude'],
            'longitude' => $_POST['longitude']
        ]);

        return $this->json(['status' => 'success']);
    }
}
