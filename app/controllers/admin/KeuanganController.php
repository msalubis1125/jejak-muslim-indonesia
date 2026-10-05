<?php

class KeuanganController extends Controller {
    protected $masjidId;

    public function __construct() {
        Auth::requireLogin();
        Auth::requireRoles(['super_admin', 'takmir']);
        $this->masjidId = Auth::isSuperAdmin() ? ($_GET['masjid_id'] ?? null) : Auth::getMasjidId();
        if (!$this->masjidId) {
            $this->masjidId = 1; // Default fallback to primary mosque
        }
    }

    public function save() {
        if (!empty($_POST['id'])) {
            return $this->update($_POST['id']);
        }
        return $this->store();
    }

    public function index() {
        $keuanganModel = $this->model('KeuanganModel');
        $kasId = $_GET['kas'] ?? null;
        $kategoriId = $_GET['kategori'] ?? null;
        $tipe = $_GET['tipe'] ?? null;
        $page = (int)($_GET['page'] ?? 1);

        $data = [
            'title' => 'Manajemen Keuangan',
            'transaksi' => $keuanganModel->getPaginated($this->masjidId, $kasId, $kategoriId, $tipe, $page, 15),
            'kas_list' => $keuanganModel->getKasList($this->masjidId),
            'kategori_list' => $keuanganModel->getKategoriList()
        ];

        $this->view('admin/keuangan/index', $data);
    }

    public function create() {
        $keuanganModel = $this->model('KeuanganModel');
        $data = [
            'title' => 'Tambah Transaksi',
            'kas_list' => $keuanganModel->getKasList($this->masjidId),
            'kategori_list' => $keuanganModel->getKategoriList()
        ];
        $this->view('admin/keuangan/form', $data);
    }

    public function store() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/keuangan');
        }

        $v = new Validator();
        $result = $v->validate($_POST, [
            'kas_id' => 'required',
            'kategori_id' => 'required',
            'tipe' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required'
        ]);

        if ($result['valid']) {
            try {
                $keuanganModel = $this->model('KeuanganModel');
                $data = [
                    'masjid_id' => $this->masjidId,
                    'kas_id' => $_POST['kas_id'],
                    'kategori_id' => $_POST['kategori_id'],
                    'tipe' => $_POST['tipe'],
                    'nominal' => str_replace('.', '', $_POST['nominal']), // handle formatting
                    'keterangan' => $_POST['keterangan'] ?? '',
                    'tanggal' => $_POST['tanggal']
                ];
                $keuanganModel->createWithSaldo($data);
                Session::flash('success', 'Transaksi berhasil ditambahkan.');
            } catch (Exception $e) {
                Session::flash('error', 'Gagal menyimpan transaksi.');
            }
        } else {
            Session::flash('error', 'Semua kolom wajib harus diisi.');
        }
        $this->redirect('admin/keuangan');
    }

    public function edit($id) {
        $keuanganModel = $this->model('KeuanganModel');
        $data = [
            'title' => 'Edit Transaksi',
            'transaksi' => $keuanganModel->findByIdAndMasjid($id, $this->masjidId),
            'kas_list' => $keuanganModel->getKasList($this->masjidId),
            'kategori_list' => $keuanganModel->getKategoriList()
        ];
        if (!$data['transaksi']) {
            $this->redirect('admin/keuangan');
        }
        $this->view('admin/keuangan/form', $data);
    }

    public function update($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/keuangan');
        }

        try {
            $keuanganModel = $this->model('KeuanganModel');
            $data = [
                'kas_id' => $_POST['kas_id'],
                'kategori_id' => $_POST['kategori_id'],
                'tipe' => $_POST['tipe'],
                'nominal' => str_replace('.', '', $_POST['nominal']),
                'keterangan' => $_POST['keterangan'] ?? '',
                'tanggal' => $_POST['tanggal']
            ];
            $keuanganModel->updateWithSaldo($id, $this->masjidId, $data);
            Session::flash('success', 'Transaksi berhasil diperbarui.');
        } catch (Exception $e) {
            Session::flash('error', 'Gagal memperbarui transaksi.');
        }
        $this->redirect('admin/keuangan');
    }

    public function delete($id) {
        if ($this->isPost()) {
            try {
                $keuanganModel = $this->model('KeuanganModel');
                $keuanganModel->softDeleteWithSaldo($id, $this->masjidId);
                Session::flash('success', 'Transaksi berhasil dihapus.');
            } catch (Exception $e) {
                Session::flash('error', 'Gagal menghapus transaksi.');
            }
        }
        $this->redirect('admin/keuangan');
    }

    public function laporan() {
        $keuanganModel = $this->model('KeuanganModel');
        $bulan = $_GET['bulan'] ?? date('m');
        $tahun = $_GET['tahun'] ?? date('Y');

        $data = [
            'title' => 'Laporan Keuangan',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'summary' => $keuanganModel->getMonthlySummary($this->masjidId, $bulan, $tahun),
            'transaksi' => $keuanganModel->getMonthlyTransactions($this->masjidId, $bulan, $tahun)
        ];

        $this->view('admin/keuangan/laporan', $data);
    }

    public function exportPdf() {
        // Placeholder for PDF export
        $this->redirect('admin/keuangan/print?' . http_build_query($_GET));
    }

    public function print() {
        $keuanganModel = $this->model('KeuanganModel');
        $bulan = $_GET['bulan'] ?? date('m');
        $tahun = $_GET['tahun'] ?? date('Y');

        $data = [
            'title' => 'Cetak Laporan Keuangan',
            'summary' => $keuanganModel->getMonthlySummary($this->masjidId, $bulan, $tahun),
            'transaksi' => $keuanganModel->getMonthlyTransactions($this->masjidId, $bulan, $tahun)
        ];

        $this->view('admin/keuangan/print', $data);
    }
}
