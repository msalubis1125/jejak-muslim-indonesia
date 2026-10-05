<?php

class PetaController extends Controller {
    public function index() {
        $data = [
            'title' => 'Peta Persebaran Masjid',
            'currentPage' => 'peta',
            'extraCss' => '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />',
            'extraJs' => '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>' .
                         '<script>window.BASE_URL = "' . BASE_URL . '";</script>' .
                         '<script src="' . BASE_URL . '/public/js/peta.js?v=' . time() . '"></script>'
        ];
        $this->view('public/peta', $data);
    }

    public function markers() {
        $masjidModel = $this->model('MasjidModel');
        $verifiedMasjid = $masjidModel->findAllVerifiedWithFasilitas();
        
        $markers = array_map(function($m) {
            return [
                'id' => $m['id'],
                'nama' => $m['nama'],
                'slug' => $m['slug'],
                'lat' => $m['latitude'],
                'lng' => $m['longitude'],
                'foto_utama' => $m['foto_utama'],
                'buka_24jam' => $m['buka_24jam'],
                'fasilitas' => $m['fasilitas'] ?? []
            ];
        }, $verifiedMasjid);

        return $this->json($markers);
    }
}
