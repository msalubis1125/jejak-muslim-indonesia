<?php

class DashboardController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        
        if (Auth::isTakmir()) {
            $this->masjidId = Auth::getMasjidId() ?? 1;
        } else {
            $this->masjidId = $_GET['masjid_id'] ?? 1;
        }
    }

    public function index() {
        $masjidModel = $this->model('MasjidModel');
        $userModel = $this->model('UserModel');
        $keuanganModel = $this->model('KeuanganModel');
        $kegiatanModel = $this->model('KegiatanModel');
        $jamaahModel = $this->model('JamaahModel');

        if (Auth::isSuperAdmin()) {
            $data = [
                'title' => 'Pusat Kendali Ekosistem - Super Administrator',
                'is_super_admin' => true,
                'total_masjid' => $masjidModel->countAll(['is_deleted' => 0]),
                'verified_masjid' => $masjidModel->count(['status' => 'verified', 'is_deleted' => 0]),
                'pending_verifikasi' => $masjidModel->countByStatus('pending'),
                'total_users' => $userModel->countAll(['is_active' => 1]),
                'total_takmir' => $userModel->count(['role' => 'takmir', 'is_active' => 1]),
                'total_saldo_nasional' => $keuanganModel->getTotalSaldo(null),
                'pending_list' => $masjidModel->findPending(),
                'masjid_list' => $masjidModel->findAll(['is_deleted' => 0], 'created_at DESC', 5)
            ];
        } else {
            $data = [
                'title' => 'Dashboard Takmir Masjid',
                'is_super_admin' => false,
                'masjid' => $masjidModel->findById($this->masjidId),
                'total_saldo' => $keuanganModel->getTotalSaldo($this->masjidId),
                'kegiatan_bulan_ini' => $kegiatanModel->countThisMonth($this->masjidId),
                'jumlah_jamaah' => $jamaahModel->countByMasjid($this->masjidId),
                'transaksi_terakhir' => $keuanganModel->getRecent($this->masjidId, 5),
                'kegiatan_mendatang' => $kegiatanModel->getUpcomingByMasjid($this->masjidId, 5)
            ];
        }

        $this->view('admin/dashboard', $data);
    }
}
