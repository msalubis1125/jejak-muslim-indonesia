<?php

class ArtikelController extends Controller {
    public function index() {
        $artikelModel = $this->model('ArtikelModel');
        $kategori = $_GET['kategori'] ?? '';
        $page = (int)($_GET['page'] ?? 1);
        
        $data = [
            'title' => 'Artikel Islami',
            'artikel_list' => $artikelModel->getPublishedPaginated($kategori, $page, 10),
            'kategori' => $kategori,
            'page' => $page
        ];
        
        $this->view('public/artikel-list', $data);
    }

    public function detail($slug) {
        $artikelModel = $this->model('ArtikelModel');
        $artikel = $artikelModel->findBySlug($slug);
        
        if (!$artikel || empty($artikel['is_published'])) {
            $this->redirect('artikel');
        }

        $data = [
            'title' => htmlspecialchars($artikel['judul']),
            'artikel' => $artikel
        ];
        
        $this->view('public/artikel-detail', $data);
    }
}
