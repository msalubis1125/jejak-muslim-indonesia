<?php

class MasjidVerifController extends Controller {
    public function __construct() {
        Auth::requireLogin();
        Auth::requireRole('super_admin');
    }

    public function index() {
        $masjidModel = $this->model('MasjidModel');
        $data = [
            'title' => 'Verifikasi Masjid',
            'pending_list' => $masjidModel->getByStatus('pending')
        ];
        $this->view('admin/superadmin/masjid-verifikasi', $data);
    }

    public function allMasjid() {
        $masjidModel = $this->model('MasjidModel');
        $data = [
            'title' => 'Semua Data Masjid',
            'masjid_list' => $masjidModel->getAll()
        ];
        $this->view('admin/superadmin/masjid-all', $data);
    }

    public function verify($id) {
        if ($this->isPost()) {
            $masjidModel = $this->model('MasjidModel');
            $masjidModel->updateStatus($id, 'verified');
            Session::flash('success', 'Masjid berhasil diverifikasi.');
        }
        $this->redirect('admin/superadmin/masjidverif');
    }

    public function reject($id) {
        if ($this->isPost()) {
            $masjidModel = $this->model('MasjidModel');
            $masjidModel->updateStatus($id, 'suspended');
            Session::flash('success', 'Pengajuan masjid ditolak (ditangguhkan).');
        }
        $this->redirect('admin/superadmin/masjidverif');
    }

    public function suspend($id) {
        if ($this->isPost()) {
            $masjidModel = $this->model('MasjidModel');
            $masjidModel->updateStatus($id, 'suspended');
            Session::flash('success', 'Masjid telah ditangguhkan.');
        }
        $this->redirect('admin/superadmin/masjidverif/allMasjid');
    }
}
