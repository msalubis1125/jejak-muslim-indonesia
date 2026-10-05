<?php

class HomeController extends Controller {
    public function index() {
        $artikelModel = $this->model('ArtikelModel');
        $kegiatanModel = $this->model('KegiatanModel');
        $masjidModel = $this->model('MasjidModel');

        $data = [
            'title' => 'Beranda - Jejak Muslim Indonesia',
            'currentPage' => 'home',
            'recent_articles' => $artikelModel->getRecent(5),
            'upcoming_events' => $kegiatanModel->getUpcomingAcrossVerified(5),
            'kegiatan' => $kegiatanModel->getUpcomingAcrossVerified(5),
            'masjid_terdekat' => $masjidModel->findVerified()
        ];

        $this->view('public/home', $data);
    }
}
