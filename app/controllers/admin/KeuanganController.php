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

        $kasList = $keuanganModel->getKasList($this->masjidId);
        $totalSaldo = $keuanganModel->getTotalSaldo($this->masjidId);

        $data = [
            'title' => 'Manajemen Keuangan',
            'transaksi' => $keuanganModel->getPaginated($this->masjidId, $kasId, $kategoriId, $tipe, $page, 15),
            'kas_list' => $kasList,
            'kategori_list' => $keuanganModel->getKategoriList($this->masjidId),
            'total_saldo' => $totalSaldo
        ];

        $this->view('admin/keuangan/index', $data);
    }

    public function create() {
        $keuanganModel = $this->model('KeuanganModel');
        $data = [
            'title' => 'Tambah Transaksi',
            'kas_list' => $keuanganModel->getKasList($this->masjidId),
            'kategori_list' => $keuanganModel->getKategoriList($this->masjidId)
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
            'kategori_list' => $keuanganModel->getKategoriList($this->masjidId)
        ];
        if (!$data['transaksi']) {
            $this->redirect('admin/keuangan');
        }
        $this->view('admin/keuangan/form', $data);
    }

    public function addKategori() {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/keuangan');
        }

        $nama = trim($_POST['nama'] ?? '');
        $tipe = $_POST['tipe'] ?? 'pemasukan';

        if (empty($nama)) {
            Session::flash('error', 'Nama kategori tidak boleh kosong.');
            $this->redirect('admin/keuangan');
        }

        if (!in_array($tipe, ['pemasukan', 'pengeluaran'])) {
            $tipe = ($tipe === 'keluar') ? 'pengeluaran' : 'pemasukan';
        }

        try {
            $keuanganModel = $this->model('KeuanganModel');
            $keuanganModel->createKategori([
                'nama' => $nama,
                'tipe' => $tipe,
                'is_default' => 0,
                'masjid_id' => $this->masjidId
            ]);
            Session::flash('success', "Kategori '{$nama}' berhasil ditambahkan ke masjid Anda.");
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menambahkan kategori.');
        }

        $this->redirect('admin/keuangan');
    }

    public function deleteKategori($id) {
        if (!$this->isPost() || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('admin/keuangan');
        }

        try {
            $keuanganModel = $this->model('KeuanganModel');
            // Pastikan kategori milik masjid yang sedang login (bukan default milik sistem)
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM kategori_keuangan WHERE id = :id AND masjid_id = :masjid_id");
            $stmt->execute(['id' => $id, 'masjid_id' => $this->masjidId]);
            $kat = $stmt->fetch();

            if ($kat) {
                $keuanganModel->deleteKategori($id);
                Session::flash('success', "Kategori '{$kat['nama']}' berhasil dihapus.");
            } else {
                Session::flash('error', 'Kategori bawaan sistem tidak dapat dihapus.');
            }
        } catch (Exception $e) {
            Session::flash('error', 'Gagal menghapus kategori.');
        }

        $this->redirect('admin/keuangan');
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
        $this->print();
    }

    public function print() {
        $keuanganModel = $this->model('KeuanganModel');
        $masjidModel = $this->model('MasjidModel');
        $kasModel = $this->model('KasModel');

        $periode = $_GET['periode'] ?? 'bulan';
        $kasId = !empty($_GET['kas_id']) ? (int)$_GET['kas_id'] : null;
        $format = $_GET['format'] ?? 'ringkasan'; // 'ringkasan' (1 lembar mading/jumat) atau 'detail' (buku kas lengkap)
        $showTtd = isset($_GET['ttd']) ? (int)$_GET['ttd'] : 1;

        $startDate = null;
        $endDate = null;
        $periodeLabel = '';

        if ($periode === 'jumat') {
            // Periode Pengumuman Shalat Jumat (1 pekan terakhir dari Jumat lalu s/d Kamis/Jumat ini)
            $today = new DateTime();
            $dayOfWeek = (int)$today->format('w'); // 0 = Minggu, 5 = Jumat
            // Jika hari ini Jumat, rentang dari Jumat pekan lalu sampai Kamis kemarin (atau hari ini)
            // Standar laporan Jumat: 7 hari terakhir
            $end = clone $today;
            $start = (clone $today)->modify('-6 days');
            $startDate = $start->format('Y-m-d');
            $endDate = $end->format('Y-m-d');
            $periodeLabel = 'Pengumuman Shalat Jumat (' . $start->format('d M Y') . ' s/d ' . $end->format('d M Y') . ')';
        } elseif ($periode === 'bulan') {
            $bulan = (int)($_GET['bulan'] ?? date('m'));
            $tahun = (int)($_GET['tahun'] ?? date('Y'));
            $startDate = sprintf('%04d-%02d-01', $tahun, $bulan);
            $endDate = date('Y-m-t', strtotime($startDate));
            $namaBulan = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $periodeLabel = 'Bulan ' . ($namaBulan[$bulan] ?? $bulan) . ' ' . $tahun;
        } elseif ($periode === 'tahun') {
            $tahun = (int)($_GET['tahun'] ?? date('Y'));
            $startDate = sprintf('%04d-01-01', $tahun);
            $endDate = sprintf('%04d-12-31', $tahun);
            $periodeLabel = 'Tahun Buku ' . $tahun;
        } elseif ($periode === 'custom') {
            $startDate = !empty($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
            $endDate = !empty($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
            $periodeLabel = date('d M Y', strtotime($startDate)) . ' s/d ' . date('d M Y', strtotime($endDate));
        } else {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-d');
            $periodeLabel = 'Bulan Berjalan (' . date('d M Y', strtotime($startDate)) . ' s/d ' . date('d M Y') . ')';
        }

        $kategoriId = !empty($_GET['kategori_id']) ? (int)$_GET['kategori_id'] : (!empty($_GET['kategori']) ? (int)$_GET['kategori'] : null);
        $tipe = !empty($_GET['tipe']) ? $_GET['tipe'] : null;

        // Ambil Data Laporan Berdasarkan Filter
        $reportData = $keuanganModel->getDetailedReport($this->masjidId, [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'kas_id' => $kasId,
            'kategori_id' => $kategoriId,
            'tipe' => $tipe
        ]);

        // Informasi Masjid
        $masjid = $masjidModel->findById($this->masjidId);

        // Informasi Kantong Kas Terpilih
        $namaKas = 'Semua Kantong Kas';
        if ($kasId) {
            $kasObj = $kasModel->findById($kasId);
            if ($kasObj) {
                $namaKas = is_array($kasObj) ? $kasObj['nama_kas'] : $kasObj->nama_kas;
            }
        }

        // Informasi Kategori Terpilih (jika difilter per kategori)
        $namaKategori = 'Semua Kategori';
        if ($kategoriId) {
            $katList = $keuanganModel->getKategoriList($this->masjidId);
            foreach ($katList as $katItem) {
                if ($katItem['id'] == $kategoriId) {
                    $namaKategori = $katItem['nama'];
                    break;
                }
            }
        }

        $data = [
            'title' => 'Cetak Laporan Keuangan - ' . ($masjid['nama'] ?? 'Masjid'),
            'masjid' => $masjid,
            'nama_kas' => $namaKas,
            'nama_kategori' => $namaKategori,
            'kategori_id' => $kategoriId,
            'tipe_filter' => $tipe,
            'periode_label' => $periodeLabel,
            'periode' => $periode,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'format' => $format,
            'show_ttd' => $showTtd,
            'report' => $reportData
        ];

        $this->view('admin/keuangan/print', $data);
    }

    public function exportCsv() {
        $keuanganModel = $this->model('KeuanganModel');
        $masjidModel = $this->model('MasjidModel');

        $periode = $_GET['periode'] ?? 'bulan';
        $kasId = !empty($_GET['kas_id']) ? (int)$_GET['kas_id'] : null;

        if ($periode === 'jumat') {
            $today = new DateTime();
            $end = clone $today;
            $start = (clone $today)->modify('-6 days');
            $startDate = $start->format('Y-m-d');
            $endDate = $end->format('Y-m-d');
        } elseif ($periode === 'bulan') {
            $bulan = (int)($_GET['bulan'] ?? date('m'));
            $tahun = (int)($_GET['tahun'] ?? date('Y'));
            $startDate = sprintf('%04d-%02d-01', $tahun, $bulan);
            $endDate = date('Y-m-t', strtotime($startDate));
        } elseif ($periode === 'tahun') {
            $tahun = (int)($_GET['tahun'] ?? date('Y'));
            $startDate = sprintf('%04d-01-01', $tahun);
            $endDate = sprintf('%04d-12-31', $tahun);
        } elseif ($periode === 'custom') {
            $startDate = !empty($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
            $endDate = !empty($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
        } else {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-d');
        }

        $reportData = $keuanganModel->getDetailedReport($this->masjidId, [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'kas_id' => $kasId
        ]);

        $masjid = $masjidModel->findById($this->masjidId);
        $masjidSlug = $masjid ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $masjid['nama']) : 'masjid';
        $filename = "laporan_keuangan_{$masjidSlug}_{$startDate}_sd_{$endDate}.csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM agar rapi di Microsoft Excel
        fputs($output, "\xEF\xBB\xBF");

        // Metadata Header
        fputcsv($output, ['LAPORAN KEUANGAN MASJID', $masjid['nama'] ?? 'Masjid']);
        fputcsv($output, ['PERIODE', $startDate . ' s/d ' . $endDate]);
        fputcsv($output, ['SALDO AWAL', (float)$reportData['saldo_awal']]);
        fputcsv($output, ['TOTAL PEMASUKAN', (float)$reportData['total_masuk']]);
        fputcsv($output, ['TOTAL PENGELUARAN', (float)$reportData['total_keluar']]);
        fputcsv($output, ['SALDO AKHIR', (float)$reportData['saldo_akhir']]);
        fputcsv($output, []); // Baris kosong pemisah

        // Kolom Transaksi
        fputcsv($output, ['No', 'Tanggal', 'Kantong Kas', 'Kategori', 'Tipe', 'Nominal (Rp)', 'Keterangan']);

        $no = 1;
        foreach ($reportData['transaksi'] as $tx) {
            fputcsv($output, [
                $no++,
                date('d/m/Y', strtotime($tx['tanggal'])),
                $tx['nama_kas'] ?? 'Kas Umum',
                $tx['nama_kategori'] ?? 'Lain-lain',
                strtoupper($tx['tipe']),
                (float)$tx['nominal'],
                $tx['keterangan'] ?? ''
            ]);
        }

        fclose($output);
        exit;
    }
}
