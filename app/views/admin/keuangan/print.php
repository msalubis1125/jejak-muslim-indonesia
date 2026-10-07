<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Laporan Keuangan Masjid') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 11pt;
            color: #1f2937;
            background-color: #f3f4f6;
            line-height: 1.45;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 18mm;
            margin: 15px auto;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: relative;
        }
        .no-print-bar {
            width: 210mm;
            margin: 15px auto 0;
            padding: 12px 18px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background-color: #059669;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #047857;
        }
        .btn-outline {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #4b5563;
        }
        .btn-outline:hover {
            background-color: #f9fafb;
        }

        /* Kop Laporan */
        .kop {
            text-align: center;
            padding-bottom: 12px;
            border-bottom: 2px solid #111827;
            margin-bottom: 15px;
        }
        .kop-logo {
            max-height: 48px;
            margin-bottom: 4px;
        }
        .kop h1 {
            font-size: 16pt;
            font-weight: 800;
            text-transform: uppercase;
            color: #111827;
            letter-spacing: 0.5px;
        }
        .kop p.alamat {
            font-size: 9pt;
            color: #4b5563;
            margin-top: 2px;
        }
        .doc-title {
            text-align: center;
            margin: 14px 0 16px;
        }
        .doc-title h2 {
            font-size: 13pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #065f46;
        }
        .doc-title .meta {
            font-size: 10pt;
            color: #4b5563;
            margin-top: 3px;
            font-weight: 500;
        }

        /* Summary Cards / Table */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }
        .summary-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
            background: #fafafa;
        }
        .summary-card.highlight {
            background: #ecfdf5;
            border-color: #a7f3d0;
        }
        .summary-card .label {
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: 600;
            color: #6b7280;
            letter-spacing: 0.5px;
        }
        .summary-card .value {
            font-size: 11pt;
            font-weight: 700;
            color: #111827;
            margin-top: 3px;
        }
        .text-emerald { color: #059669 !important; }
        .text-rose { color: #dc2626 !important; }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
            margin-bottom: 16px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f3f4f6;
            font-weight: 700;
            color: #1f2937;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
        }
        tr.even {
            background-color: #f9fafb;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Breakdown 2 Kolom Ringkasan */
        .breakdown-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }
        .section-heading {
            font-size: 10pt;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 6px;
            color: #374151;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1.5px solid #e5e7eb;
            padding-bottom: 3px;
        }

        /* Kolom Tanda Tangan */
        .signature-block {
            margin-top: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            text-align: center;
            page-break-inside: avoid;
        }
        .signature-box {
            padding: 0 20px;
        }
        .signature-box .role {
            font-size: 9.5pt;
            font-weight: 600;
            color: #374151;
        }
        .signature-space {
            height: 65px;
        }
        .signature-name {
            font-size: 10pt;
            font-weight: 700;
            text-decoration: underline;
            color: #111827;
        }
        .signature-note {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 2px;
        }

        .footer-note {
            margin-top: 25px;
            padding-top: 8px;
            border-top: 1px dashed #d1d5db;
            font-size: 7.5pt;
            color: #9ca3af;
            display: flex;
            justify-content: space-between;
        }

        /* Print Settings */
        @media print {
            body {
                background: #ffffff;
            }
            .no-print-bar {
                display: none !important;
            }
            .page {
                width: 100%;
                min-height: auto;
                padding: 0;
                margin: 0;
                box-shadow: none;
            }
            @page {
                size: A4;
                margin: 12mm 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- Bar Aksi Non-Print -->
    <div class="no-print-bar">
        <div style="font-size: 13px; color: #4b5563;">
            Format: <strong><?= $format === 'ringkasan' ? 'Ringkasan 1 Halaman (Mading / Pengumuman Jumat)' : 'Buku Kas Rinci (Seluruh Transaksi)' ?></strong>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="<?= BASE_URL ?>/admin/keuangan" class="btn btn-outline">← Kembali ke Sistem</a>
            <button onclick="window.print()" class="btn btn-primary">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                Cetak Dokumen
            </button>
        </div>
    </div>

    <!-- Lembar Cetak A4 -->
    <div class="page">
        <!-- Kop Surat -->
        <div class="kop">
            <h1><?= htmlspecialchars($masjid['nama'] ?? 'Masjid') ?></h1>
            <p class="alamat">
                <?= htmlspecialchars($masjid['alamat'] ?? 'Alamat Masjid') ?><?= !empty($masjid['kota']) ? ', ' . htmlspecialchars($masjid['kota']) : '' ?><?= !empty($masjid['provinsi']) ? ', ' . htmlspecialchars($masjid['provinsi']) : '' ?>
                <?= !empty($masjid['telepon']) ? ' • Telp: ' . htmlspecialchars($masjid['telepon']) : '' ?>
            </p>
        </div>

        <!-- Judul Laporan -->
        <div class="doc-title">
            <h2>LAPORAN PERTANGGUNGJAWABAN KEUANGAN</h2>
            <div class="meta">
                Periode: <strong><?= htmlspecialchars($periode_label) ?></strong> &bull; Kantong Kas: <strong><?= htmlspecialchars($nama_kas) ?></strong>
                <?php if (!empty($kategori_id) && !empty($nama_kategori)): ?>
                    &bull; Pos Kategori: <strong style="color: #059669;"><?= htmlspecialchars($nama_kategori) ?></strong>
                <?php endif; ?>
                <?php if (!empty($tipe_filter)): ?>
                    &bull; Tipe: <strong><?= ($tipe_filter === 'masuk') ? 'Pemasukan (+)' : 'Pengeluaran (-)' ?></strong>
                <?php endif; ?>
            </div>
        </div>

        <!-- 4 Kotak Saldo Utama -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Saldo Awal Periode</div>
                <div class="value mono">Rp <?= number_format($report['saldo_awal'], 0, ',', '.') ?></div>
            </div>
            <div class="summary-card">
                <div class="label">Total Pemasukan (+)</div>
                <div class="value mono text-emerald">Rp <?= number_format($report['total_masuk'], 0, ',', '.') ?></div>
            </div>
            <div class="summary-card">
                <div class="label">Total Pengeluaran (-)</div>
                <div class="value mono text-rose">Rp <?= number_format($report['total_keluar'], 0, ',', '.') ?></div>
            </div>
            <div class="summary-card highlight">
                <div class="label">Saldo Akhir Periode</div>
                <div class="value mono" style="color: #065f46;">Rp <?= number_format($report['saldo_akhir'], 0, ',', '.') ?></div>
            </div>
        </div>

        <?php if ($format === 'ringkasan'): ?>
            <!-- FORMAT RINGKASAN: REKAP PER KATEGORI (Cocok untuk Mading & Mimbar Shalat Jumat) -->
            <div class="breakdown-grid">
                <!-- Rincian Pemasukan -->
                <div>
                    <div class="section-heading">
                        <span>Pemasukan Menurut Pos</span>
                        <span class="mono text-emerald font-bold">Rp <?= number_format($report['total_masuk'], 0, ',', '.') ?></span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Pos Pemasukan</th>
                                <th class="text-right" style="width: 40%;">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($report['kategori_masuk'])): ?>
                                <tr>
                                    <td colspan="2" class="text-center" style="color: #9ca3af; font-style: italic;">Tidak ada pemasukan pada periode ini</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($report['kategori_masuk'] as $kat => $val): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($kat) ?></td>
                                        <td class="text-right mono font-semibold">Rp <?= number_format($val, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Rincian Pengeluaran -->
                <div>
                    <div class="section-heading">
                        <span>Pengeluaran Menurut Pos</span>
                        <span class="mono text-rose font-bold">Rp <?= number_format($report['total_keluar'], 0, ',', '.') ?></span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Pos Pengeluaran</th>
                                <th class="text-right" style="width: 40%;">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($report['kategori_keluar'])): ?>
                                <tr>
                                    <td colspan="2" class="text-center" style="color: #9ca3af; font-style: italic;">Tidak ada pengeluaran pada periode ini</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($report['kategori_keluar'] as $kat => $val): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($kat) ?></td>
                                        <td class="text-right mono font-semibold">Rp <?= number_format($val, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Arus Bersih / Surplus-Defisit Ringkasan -->
            <div style="background-color: #f9fafb; border: 1px dashed #d1d5db; border-radius: 8px; padding: 10px 14px; margin-bottom: 20px; font-size: 9pt; display: flex; justify-content: space-between; align-items: center;">
                <span>Surplus / (Defisit) Arus Kas Periode Ini:</span>
                <strong class="mono" style="font-size: 11pt; color: <?= $report['surplus_defisit'] >= 0 ? '#059669' : '#dc2626' ?>;">
                    <?= $report['surplus_defisit'] >= 0 ? '+' : '' ?>Rp <?= number_format($report['surplus_defisit'], 0, ',', '.') ?>
                </strong>
            </div>

        <?php else: ?>
            <!-- REKAPITULASI POS KATEGORI DALAM BUKU KAS -->
            <div class="breakdown-grid" style="margin-bottom: 16px;">
                <!-- Rincian Pemasukan -->
                <div>
                    <div class="section-heading">
                        <span>Penerimaan Menurut Kategori</span>
                        <span class="mono text-emerald font-bold">Rp <?= number_format($report['total_masuk'], 0, ',', '.') ?></span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Kategori Pemasukan</th>
                                <th class="text-right" style="width: 40%;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($report['kategori_masuk'])): ?>
                                <tr>
                                    <td colspan="2" class="text-center" style="color: #9ca3af; font-style: italic;">Tidak ada pemasukan</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($report['kategori_masuk'] as $kat => $val): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($kat) ?></td>
                                        <td class="text-right mono font-semibold text-emerald">Rp <?= number_format($val, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Rincian Pengeluaran -->
                <div>
                    <div class="section-heading">
                        <span>Pengeluaran Menurut Kategori</span>
                        <span class="mono text-rose font-bold">Rp <?= number_format($report['total_keluar'], 0, ',', '.') ?></span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Kategori Pengeluaran</th>
                                <th class="text-right" style="width: 40%;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($report['kategori_keluar'])): ?>
                                <tr>
                                    <td colspan="2" class="text-center" style="color: #9ca3af; font-style: italic;">Tidak ada pengeluaran</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($report['kategori_keluar'] as $kat => $val): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($kat) ?></td>
                                        <td class="text-right mono font-semibold text-rose">Rp <?= number_format($val, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FORMAT DETAIL: BUKU KAS LENGKAP -->
            <div class="section-heading">
                <span>Daftar Transaksi Arus Kas</span>
                <span style="font-size: 8.5pt; color: #6b7280; font-weight: normal;"><?= count($report['transaksi']) ?> Transaksi</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 18%;">Kategori & Pos</th>
                        <th>Uraian / Keterangan</th>
                        <th style="width: 16%;" class="text-right">Masuk (Rp)</th>
                        <th style="width: 16%;" class="text-right">Keluar (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($report['transaksi'])): ?>
                        <tr>
                            <td colspan="6" class="text-center" style="color: #9ca3af; font-style: italic; padding: 16px;">Tidak ada transaksi keuangan pada periode ini</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($report['transaksi'] as $tx): ?>
                            <tr class="<?= $no % 2 === 0 ? 'even' : '' ?>">
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="mono"><?= date('d/m/Y', strtotime($tx['tanggal'])) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($tx['nama_kategori'] ?? 'Lain-lain') ?></strong>
                                    <div style="font-size: 7.5pt; color: #6b7280;"><?= htmlspecialchars($tx['nama_kas'] ?? 'Kas') ?> &bull; <?= ($tx['tipe'] === 'masuk') ? '<span style="color:#059669;">[Pemasukan]</span>' : '<span style="color:#dc2626;">[Pengeluaran]</span>' ?></div>
                                </td>
                                <td><?= htmlspecialchars($tx['keterangan'] ?? '-') ?></td>
                                <td class="text-right mono text-emerald font-semibold">
                                    <?= ($tx['tipe'] === 'masuk') ? number_format($tx['nominal'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-right mono text-rose font-semibold">
                                    <?= ($tx['tipe'] === 'keluar') ? number_format($tx['nominal'], 0, ',', '.') : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight: 700; background-color: #f3f4f6;">
                        <td colspan="4" class="text-right">TOTAL MUTASI PERIODE INI:</td>
                        <td class="text-right mono text-emerald">Rp <?= number_format($report['total_masuk'], 0, ',', '.') ?></td>
                        <td class="text-right mono text-rose">Rp <?= number_format($report['total_keluar'], 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>

        <!-- Kolom Tanda Tangan Resmi Pengurus -->
        <?php if ($show_ttd): ?>
            <div class="signature-block">
                <div class="signature-box">
                    <p class="signature-note">Mengetahui,</p>
                    <p class="role">Ketua DKM / Takmir</p>
                    <div class="signature-space"></div>
                    <p class="signature-name">( ........................................ )</p>
                </div>
                <div class="signature-box">
                    <p class="signature-note"><?= htmlspecialchars($masjid['kota'] ?? 'Indonesia') ?>, <?= date('d F Y') ?></p>
                    <p class="role">Bendahara Masjid</p>
                    <div class="signature-space"></div>
                    <p class="signature-name">( ........................................ )</p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Footer Audit Note -->
        <div class="footer-note">
            <span>Dicetak melalui Sistem Jejak Muslim Indonesia pada <?= date('d/m/Y H:i:s') ?> WIB</span>
            <span>Halaman 1 dari 1 &bull; Dokumen Transparansi Publik</span>
        </div>
    </div>

</body>
</html>
