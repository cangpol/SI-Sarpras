<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($reportTitle) ?> - SI-Sarpras Upitra</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }
        .page-container {
            max-width: 1100px;
            margin: 20px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }
        /* Kop Surat Resmi */
        .kop-surat {
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .kop-title {
            font-size: 19px;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .kop-subtitle {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .kop-address {
            font-size: 11px;
            color: #475569;
            line-height: 1.4;
        }
        /* Judul Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .report-meta-box {
            background-color: #f1f5f9;
            border-left: 4px solid #2563eb;
            padding: 10px 14px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 12px;
        }
        /* Tabel Laporan */
        .table-report {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 11.5px;
        }
        .table-report th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: 700;
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10.5px;
        }
        .table-report td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            vertical-align: middle;
        }
        .table-report tr:nth-child(even) {
            background-color: #f8fafc;
        }
        /* Status Badges untuk Cetak */
        .badge-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-approved { background-color: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .badge-pending { background-color: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-other { background-color: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; }

        /* Tanda Tangan */
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 250px;
            text-align: center;
        }
        .signature-line {
            margin-top: 65px;
            border-bottom: 1px solid #0f172a;
            font-weight: 700;
            padding-bottom: 3px;
        }

        /* Top Action Bar */
        .action-bar {
            max-width: 1100px;
            margin: 15px auto 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Print Specific Styling */
        @media print {
            body {
                background: white !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .page-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .table-report th {
                background-color: #f1f5f9 !important;
            }
            @page {
                size: A4 landscape;
                margin: 12mm 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- ACTION BAR (Hanya Tampil di Layar, Disembunyikan Saat Cetak) -->
    <div class="action-bar no-print">
        <a href="/dashboard" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan PDF
            </button>
            <button onclick="window.close()" class="btn btn-light btn-sm rounded-pill px-3 border">
                Tutup
            </button>
        </div>
    </div>

    <!-- CONTAINER DOKUMEN CETAK -->
    <div class="page-container">

        <!-- KOP SURAT RESMI -->
        <div class="kop-surat">
            <div class="row align-items-center">
                <div class="col-auto">
                    <!-- Lambang / Logo Instansi -->
                    <div style="width: 60px; height: 60px; border-radius: 8px; background: #1e3a8a; color: white; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 22px; letter-spacing: 1px;">
                        UPT
                    </div>
                </div>
                <div class="col">
                    <div class="kop-title">UNIVERSITAS PIGNATELLI TRIPUTRA</div>
                    <div class="kop-subtitle">BIRO SARANA DAN PRASARANA (SARPRAS)</div>
                    <div class="kop-address">
                        Kampus UPITRA: Jl. Duwet Raya No.I, Karangasem, Kec. Laweyan, Kota Surakarta, Jawa Tengah 57145<br>
                        Loket Fisik: Gedung 4, Lantai 1 (Samping Auditorium) | Email: sarpras@upitra.ac.id | Website: https://sarpras.upitra.ac.id
                    </div>
                </div>
            </div>
        </div>

        <!-- HEADER LAPORAN -->
        <div class="report-header">
            <div class="report-title"><?= esc($reportTitle) ?></div>
            <div class="text-muted small"><?= esc($reportSubtitle) ?></div>
        </div>

        <!-- METADATA BOX -->
        <div class="report-meta-box">
            <div class="row">
                <div class="col-md-6">
                    <strong>Dicetak Oleh:</strong> <?= esc($printedBy) ?> (<?= esc($printedRole) ?>)<br>
                    <strong>Waktu Cetak:</strong> <?= esc($printDate) ?>
                </div>
                <div class="col-md-6 text-md-end">
                    <strong>Sistem:</strong> SI-Sarpras Universitas Pignatelli Triputra<br>
                    <strong>Status Dokumen:</strong> <span class="text-success fw-bold">RESMI / VERIFIED</span>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- TABEL DATA LAPORAN SESUAI KATEGORI -->
        <!-- ============================================== -->

        <!-- 1. DATA PEMINJAMAN RUANGAN -->
        <?php if (!empty($reportData['rooms'])): ?>
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-primary mb-0"><i class="bi bi-door-open me-1"></i> Data Peminjaman Ruangan (<?= count($reportData['rooms']) ?> Data)</h6>
            </div>
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 35px;" class="text-center">No</th>
                        <th>Peminjam & Unit</th>
                        <th>Ruangan</th>
                        <th>Nama Acara / Event</th>
                        <th>Tanggal & Jam</th>
                        <th>Fasilitas Tambahan</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($reportData['rooms'] as $r): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <strong><?= esc($r['booker_name'] ?? '-') ?></strong><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($r['department'] ?? '-') ?></span>
                        </td>
                        <td>
                            <strong><?= esc($r['room_name'] ?? 'Ruangan ID: ' . $r['room_id']) ?></strong><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($r['location'] ?? '-') ?></span>
                        </td>
                        <td>
                            <?= esc($r['purpose'] ?? '-') ?><br>
                            <span class="text-muted" style="font-size: 10px;">Setup: <?= esc($r['layout_setup'] ?? 'Standard') ?></span>
                        </td>
                        <td>
                            <?= date('d/m/Y', strtotime($r['booking_date'])) ?><br>
                            <span class="text-muted" style="font-size: 10px;"><?= substr($r['start_time'] ?? '', 0, 5) ?> - <?= substr($r['end_time'] ?? '', 0, 5) ?> WIB</span>
                        </td>
                        <td><?= esc($r['additional_materials'] ?: '-') ?></td>
                        <td class="text-center">
                            <?php 
                                $st = strtolower($r['status'] ?? 'pending');
                                $badgeClass = ($st === 'approved') ? 'badge-approved' : (($st === 'rejected') ? 'badge-rejected' : 'badge-pending');
                            ?>
                            <span class="badge-status <?= $badgeClass ?>"><?= esc($r['status']) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- 2. DATA PEMINJAMAN KENDARAAN -->
        <?php if (!empty($reportData['vehicles'])): ?>
            <div class="mb-2 d-flex justify-content-between align-items-center mt-4">
                <h6 class="fw-bold text-success mb-0"><i class="bi bi-car-front me-1"></i> Data Peminjaman Kendaraan (<?= count($reportData['vehicles']) ?> Data)</h6>
            </div>
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 35px;" class="text-center">No</th>
                        <th>Peminjam & Unit</th>
                        <th>Kendaraan</th>
                        <th>Keperluan & Tujuan</th>
                        <th>Tanggal & Jam</th>
                        <th>Pengemudi</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($reportData['vehicles'] as $v): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <strong><?= esc($v['booker_name'] ?? '-') ?></strong><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($v['department'] ?? '-') ?></span>
                        </td>
                        <td>
                            <strong><?= esc($v['vehicle_name'] ?? 'Mobil Dinas ID: ' . $v['vehicle_id']) ?></strong><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($v['plate_number'] ?? '-') ?></span>
                        </td>
                        <td>
                            <?= esc($v['purpose'] ?? '-') ?><br>
                            <span class="text-muted" style="font-size: 10px;">Tujuan: <?= esc($v['destination'] ?? '-') ?></span>
                        </td>
                        <td>
                            <?= date('d/m/Y', strtotime($v['booking_date'])) ?><br>
                            <span class="text-muted" style="font-size: 10px;"><?= substr($v['start_time'] ?? '', 0, 5) ?> - <?= substr($v['end_time'] ?? '', 0, 5) ?> WIB</span>
                        </td>
                        <td><?= !empty($v['driver_needed']) ? 'Butuh Driver' : 'Tanpa Driver' ?></td>
                        <td class="text-center">
                            <?php 
                                $st = strtolower($v['status'] ?? 'pending');
                                $badgeClass = ($st === 'approved') ? 'badge-approved' : (($st === 'rejected') ? 'badge-rejected' : 'badge-pending');
                            ?>
                            <span class="badge-status <?= $badgeClass ?>"><?= esc($v['status']) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- 3. DATA REQUEST MAINTENANCE -->
        <?php if (!empty($reportData['maintenance'])): ?>
            <div class="mb-2 d-flex justify-content-between align-items-center mt-4">
                <h6 class="fw-bold text-warning mb-0" style="color: #b45309 !important;"><i class="bi bi-tools me-1"></i> Data Request Maintenance / Perbaikan (<?= count($reportData['maintenance']) ?> Data)</h6>
            </div>
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 35px;" class="text-center">No</th>
                        <th>Pemohon & Unit</th>
                        <th>Fasilitas</th>
                        <th>Lokasi Kerusakan</th>
                        <th>Keterangan Kerusakan</th>
                        <th>Waktu Laporan</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($reportData['maintenance'] as $m): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <strong><?= esc($m['requester_name'] ?? '-') ?></strong><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($m['department'] ?? '-') ?></span>
                        </td>
                        <td><strong><?= esc($m['facility'] ?? '-') ?></strong></td>
                        <td><?= esc($m['location'] ?? '-') ?></td>
                        <td><?= esc($m['description'] ?? '-') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?> WIB</td>
                        <td class="text-center">
                            <?php 
                                $st = strtolower($m['status'] ?? 'pending');
                                $badgeClass = ($st === 'resolved') ? 'badge-approved' : (($st === 'rejected') ? 'badge-rejected' : 'badge-pending');
                            ?>
                            <span class="badge-status <?= $badgeClass ?>"><?= esc($m['status']) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- 4. DATA REQUEST SUPPLIES (ATK) -->
        <?php if (!empty($reportData['supplies'])): ?>
            <div class="mb-2 d-flex justify-content-between align-items-center mt-4">
                <h6 class="fw-bold text-danger mb-0"><i class="bi bi-box-seam me-1"></i> Data Permohonan Supplies / ATK (<?= count($reportData['supplies']) ?> Data)</h6>
            </div>
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 35px;" class="text-center">No</th>
                        <th>Pemohon & Unit</th>
                        <th>Nama Barang ATK</th>
                        <th class="text-center">Jumlah</th>
                        <th>Tgl Permintaan</th>
                        <th>Tgl Dibutuhkan</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($reportData['supplies'] as $s): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <strong><?= esc($s['requester_name'] ?? '-') ?></strong><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($s['department'] ?? '-') ?></span>
                        </td>
                        <td><strong><?= esc($s['item_name'] ?? 'Item ID: ' . $s['supply_id']) ?></strong></td>
                        <td class="text-center"><strong><?= esc($s['quantity']) ?></strong> <?= esc($s['unit'] ?? 'pcs') ?></td>
                        <td><?= date('d/m/Y', strtotime($s['date_requested'])) ?></td>
                        <td><?= !empty($s['date_needed']) ? date('d/m/Y', strtotime($s['date_needed'])) : '-' ?></td>
                        <td class="text-center">
                            <?php 
                                $st = strtolower($s['status'] ?? 'pending');
                                $badgeClass = ($st === 'approved') ? 'badge-approved' : (($st === 'rejected') ? 'badge-rejected' : 'badge-pending');
                            ?>
                            <span class="badge-status <?= $badgeClass ?>"><?= esc($s['status']) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- 5. DATA LOST & FOUND -->
        <?php if (!empty($reportData['lost_found'])): ?>
            <div class="mb-2 d-flex justify-content-between align-items-center mt-4">
                <h6 class="fw-bold text-primary mb-0"><i class="bi bi-search me-1"></i> Data Barang Hilang & Ditemukan / Lost & Found (<?= count($reportData['lost_found']) ?> Data)</h6>
            </div>
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 35px;" class="text-center">No</th>
                        <th>Jenis Laporan</th>
                        <th>Nama & Deskripsi Barang</th>
                        <th>Lokasi</th>
                        <th>Tanggal Kejadian</th>
                        <th>Kontak Pelapor</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($reportData['lost_found'] as $lf): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><strong><?= strtoupper(esc($lf['type'] ?? 'lost')) ?></strong></td>
                        <td>
                            <strong><?= esc($lf['item_name'] ?? '-') ?></strong><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($lf['description'] ?? '-') ?></span>
                        </td>
                        <td><?= esc($lf['location'] ?? '-') ?></td>
                        <td><?= !empty($lf['date_found_lost']) ? date('d/m/Y', strtotime($lf['date_found_lost'])) : '-' ?></td>
                        <td>
                            <?= esc($lf['reporter_name'] ?? '-') ?><br>
                            <span class="text-muted" style="font-size: 10px;"><?= esc($lf['contact'] ?? '-') ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge-status badge-other"><?= esc($lf['status']) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- 6. DATA VISITOR LOG -->
        <?php if (!empty($reportData['visitors'])): ?>
            <div class="mb-2 d-flex justify-content-between align-items-center mt-4">
                <h6 class="fw-bold text-secondary mb-0"><i class="bi bi-person-lines-fill me-1"></i> Data Buku Tamu Kampus / Visitor Log (<?= count($reportData['visitors']) ?> Data)</h6>
            </div>
            <table class="table-report">
                <thead>
                    <tr>
                        <th style="width: 35px;" class="text-center">No</th>
                        <th>Nama Pengunjung</th>
                        <th>Instansi / Lembaga</th>
                        <th>Keperluan</th>
                        <th>Bertemu Siapa</th>
                        <th>Waktu Kunjungan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($reportData['visitors'] as $v): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><strong><?= esc($v['visitor_name'] ?? '-') ?></strong></td>
                        <td><?= esc($v['institution'] ?? '-') ?></td>
                        <td><?= esc($v['purpose'] ?? '-') ?></td>
                        <td><?= esc($v['person_to_meet'] ?? '-') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($v['visit_time'])) ?> WIB</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (empty($reportData['rooms']) && empty($reportData['vehicles']) && empty($reportData['maintenance']) && empty($reportData['supplies']) && empty($reportData['lost_found']) && empty($reportData['visitors'])): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <p>Tidak ada data riwayat yang ditemukan untuk kategori ini.</p>
            </div>
        <?php endif; ?>

        <!-- TANDA TANGAN PENGESAHAN RESMI -->
        <div class="signature-section">
            <div class="signature-box">
                <div style="font-size: 11px;">Mengetahui,</div>
                <div class="fw-bold" style="font-size: 11.5px;">Kepala Biro Sarana dan Prasarana</div>
                <div class="signature-line">
                    ( Ir. H. Bambang Sujarwo, M.T. )
                </div>
                <div class="text-muted" style="font-size: 10px;">NIP. 19780512 200312 1 002</div>
            </div>

            <div class="signature-box">
                <div style="font-size: 11px;">Yogyakarta, <?= date('d') . ' ' . (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][(int)date('n')-1] ?? date('F')) . ' ' . date('Y') ?></div>
                <div class="fw-bold" style="font-size: 11.5px;">Petugas Administrator Sarpras</div>
                <div class="signature-line">
                    ( <?= esc($printedBy) ?> )
                </div>
                <div class="text-muted" style="font-size: 10px;"><?= esc($printedRole) ?></div>
            </div>
        </div>

    </div>

    <!-- SCRIPT CETAK OTOMATIS -->
    <script>
        // Pemicu otomatis dialog cetak browser saat halaman selesai dimuat
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>
