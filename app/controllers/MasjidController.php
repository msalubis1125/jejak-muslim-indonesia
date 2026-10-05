<?php

class MasjidController extends Controller {
    public function index() {
        $masjidModel = $this->model('MasjidModel');
        
        $search = $_GET['search'] ?? '';
        $kota = $_GET['kota'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        
        $data = [
            'title' => 'Daftar Masjid Terverifikasi',
            'masjid_list' => $masjidModel->getVerifiedPaginated($search, $kota, $page, $limit),
            'search' => $search,
            'kota' => $kota,
            'page' => $page
        ];

        $this->view('public/masjid-list', $data);
    }

    public function detail($slug = null) {
        if (empty($slug)) {
            $this->redirect('masjid');
        }

        $masjidModel = $this->model('MasjidModel');
        $kegiatanModel = $this->model('KegiatanModel');
        $keuanganModel = $this->model('KeuanganModel');
        
        $masjid = $masjidModel->findBySlugOrId($slug);
        if (!$masjid || ($masjid['status'] ?? '') !== 'verified') {
            Session::flash('error', 'Halaman masjid tidak ditemukan atau belum terverifikasi.');
            $this->redirect('masjid');
        }

        $data = [
            'title' => 'Detail Masjid - ' . htmlspecialchars($masjid['nama']),
            'masjid' => $masjid,
            'fasilitas' => $masjidModel->getFasilitas($masjid['id']),
            'galeri' => $masjidModel->getGaleri($masjid['id']),
            'upcoming_events' => $kegiatanModel->getUpcomingByMasjid($masjid['id'], 5),
            'keuangan_summary' => $keuanganModel->getSummary($masjid['id']),
            'rekening' => $this->model('DonasiModel')->getRekeningByMasjid($masjid['id']),
            'qris' => $this->model('DonasiModel')->getQrisByMasjid($masjid['id'])
        ];

        $this->view('public/masjid-detail', $data);
    }

    public function nearby() {
        if (!$this->isAjax()) {
            return $this->json(['error' => 'Invalid request'], 400);
        }

        $lat = $_GET['lat'] ?? 0;
        $lng = $_GET['lng'] ?? 0;
        
        $masjidModel = $this->model('MasjidModel');
        $nearby = $masjidModel->getNearby($lat, $lng, 5); // 5km radius

        return $this->json([
            'status' => 'success',
            'data' => $nearby
        ]);
    }
}
