<?php

class JamaahMgmtController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        $this->masjidId = Auth::isSuperAdmin() ? ($_GET['masjid_id'] ?? null) : Auth::getMasjidId();
    }

    public function index() {
        $jamaahModel = $this->model('JamaahModel');
        $data = [
            'title' => 'Manajemen Data Jamaah',
            'jamaah_list' => $jamaahModel->getAllByMasjid($this->masjidId)
        ];
        $this->view('admin/jamaah/index', $data);
    }
}
