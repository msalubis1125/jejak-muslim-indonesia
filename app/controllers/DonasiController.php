<?php

class DonasiController extends Controller {
    public function index() {
        $masjidModel = $this->model('MasjidModel');
        $donasiModel = $this->model('DonasiModel');

        $rekeningList = $donasiModel->query("
            SELECT r.*, m.nama as masjid_nama, m.slug as masjid_slug, m.foto_utama, m.kota 
            FROM rekening r 
            JOIN masjid m ON r.masjid_id = m.id 
            WHERE r.is_active = 1 AND m.status = 'verified' AND m.is_deleted = 0
            ORDER BY m.nama ASC
        ")->fetchAll();

        $pengaturanModel = $this->model('PengaturanModel');
        $qrisWebsite = $pengaturanModel->getQrisWebsiteSettings();

        $data = [
            'title' => 'Salurkan Infaq & Donasi Masjid',
            'currentPage' => 'donasi',
            'masjid_list' => $masjidModel->getVerifiedWithDonasiInfo(),
            'rekening_list' => $rekeningList,
            'qris_website' => $qrisWebsite
        ];
        $this->view('public/donasi', $data);
    }

    public function show($slug) {
        $masjidModel = $this->model('MasjidModel');
        $masjid = $masjidModel->findBySlug($slug);
        
        if (!$masjid || $masjid['status'] !== 'verified') {
            $this->redirect('donasi');
        }

        $donasiModel = $this->model('DonasiModel');
        
        $data = [
            'title' => 'Donasi - ' . htmlspecialchars($masjid['nama']),
            'currentPage' => 'donasi',
            'masjid' => $masjid,
            'rekening' => $donasiModel->getRekeningByMasjid($masjid['id']),
            'qris' => $donasiModel->getQrisByMasjid($masjid['id'])
        ];

        $this->view('public/donasi', $data);
    }
}
