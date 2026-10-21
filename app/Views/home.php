<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- ============================================== -->
<!-- 1. HERO SECTION INSTITUSIONAL (BIRU & PUTIH)   -->
<!-- ============================================== -->
<section class="hero-section text-white position-relative overflow-hidden">
    <div class="hero-bg-overlay"></div>
    <div class="container position-relative py-5">
        <div class="row align-items-center py-4 py-lg-5 g-4 g-lg-5">
            <!-- Sisi Kiri: Value Proposition & Akses Cepat -->
            <div class="col-lg-7 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill border border-white border-opacity-25 mb-3 shadow-sm hero-institution-badge">
                    <span class="badge bg-white text-primary rounded-pill px-2.5 py-1 fw-bold">RESMI</span>
                    <span class="small fw-semibold text-white pe-1">Biro Sarana dan Prasarana &bull; Universitas Pignatelli Triputra</span>
                </div>
                
                <h1 class="display-4 fw-extrabold mb-3 tracking-tight lh-sm hero-title">
                    Layanan Sarana &amp; Prasarana Terpadu
                </h1>
                
                <p class="lead mb-4 text-white-50 fs-5 pe-lg-4 fw-light hero-description">
                    Portal digital untuk reservasi ruangan, peminjaman kendaraan dinas, perbaikan fasilitas, dan pengajuan persediaan ATK kampus secara cepat, transparan, dan terdata.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-4">
                    <a href="#layanan-utama" class="btn btn-light text-primary fw-bold px-4 py-3 rounded-pill shadow-lg d-inline-flex align-items-center gap-2 btn-hero-cta">
                        <i class="bi bi-grid-fill"></i>
                        <span>Katalog Layanan</span>
                        <i class="bi bi-arrow-down-short fs-5"></i>
                    </a>

                    <a href="#jadwal-kalender" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill d-inline-flex align-items-center gap-2 btn-hero-secondary">
                        <i class="bi bi-calendar3"></i>
                        <span>Cek Kalender</span>
                        <i class="bi bi-arrow-right-short fs-5"></i>
                    </a>

                    <a href="/tracking" class="btn btn-outline-light px-4 py-3 rounded-pill fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-search"></i>
                        <span>Lacak Tiket</span>
                    </a>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <a href="/dashboard" class="btn btn-info text-dark fw-bold px-4 py-3 rounded-pill d-inline-flex align-items-center gap-2 shadow-sm">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard Saya</span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Indikator Layanan Resmi -->
                <div class="d-flex flex-wrap align-items-center gap-3 pt-2 text-white-50 small justify-content-center justify-content-lg-start">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check text-info fs-5"></i>
                        <span class="text-white">Anti Double-Booking Real-Time</span>
                    </div>
                    <div class="d-none d-sm-inline opacity-50">&bull;</div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-info fs-5"></i>
                        <span class="text-white">Respon Cepat SLA &lt; 24 Jam</span>
                    </div>
                </div>
            </div>

            <!-- Sisi Kanan: Panel Status Kesiapan Fasilitas (Ramping & Proporsional) -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white text-dark hero-status-card">
                    <div class="card-body p-4">
                        <!-- Header Status Card -->
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <img src="/logo.png" alt="Logo UPT" style="height: 38px; width: auto;" class="rounded-2 p-1 border bg-white shadow-sm">
                                <div>
                                    <h6 class="fw-bold mb-0 text-primary">Kesiapan Fasilitas Kampus</h6>
                                    <small class="text-muted">Biro Sarpras UPT &bull; Status Hari Ini</small>
                                </div>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold d-inline-flex align-items-center gap-1.5">
                                <span class="status-pulse-dot"></span>
                                <span>Operasional Aktif</span>
                            </span>
                        </div>

                        <!-- 3 Aspek Kesiapan Sarpras (Ringkas & Padat) -->
                        <div class="d-flex flex-column gap-2.5 mb-3">
                            <!-- Status Ruangan -->
                            <div class="p-3 rounded-3 bg-light border border-light-subtle d-flex align-items-center gap-3 readiness-item">
                                <div class="readiness-icon bg-primary bg-opacity-10 text-primary rounded-3">
                                    <i class="bi bi-door-open-fill fs-5"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark small">Ruang Rapat &amp; Aula</strong>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">Tersedia</span>
                                    </div>
                                    <p class="text-muted mb-0 small text-truncate-2">
                                        Auditorium dan ruang rapat siap digunakan lengkap dengan multimedia.
                                    </p>
                                </div>
                            </div>

                            <!-- Status Kendaraan -->
                            <div class="p-3 rounded-3 bg-light border border-light-subtle d-flex align-items-center gap-3 readiness-item">
                                <div class="readiness-icon bg-primary bg-opacity-10 text-primary rounded-3">
                                    <i class="bi bi-car-front-fill fs-5"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark small">Armada Mobil Dinas</strong>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill small">Siap Jalan</span>
                                    </div>
                                    <p class="text-muted mb-0 small text-truncate-2">
                                        Kendaraan operasional siap melayani perjalanan dinas dan kegiatan kampus.
                                    </p>
                                </div>
                            </div>

                            <!-- Status Pemeliharaan -->
                            <div class="p-3 rounded-3 bg-light border border-light-subtle d-flex align-items-center gap-3 readiness-item">
                                <div class="readiness-icon bg-primary bg-opacity-10 text-primary rounded-3">
                                    <i class="bi bi-tools fs-5"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark small">Layanan Perbaikan</strong>
                                        <span class="badge bg-warning bg-opacity-10 text-dark rounded-pill small">Tim Siaga</span>
                                    </div>
                                    <p class="text-muted mb-0 small text-truncate-2">
                                        Teknisi siaga penanganan fasilitas listrik, AC, sanitasi, dan IT kelas.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Info Loket Fisik -->
                        <div class="pt-2.5 border-top d-flex align-items-center justify-content-between text-muted small">
                            <span><i class="bi bi-geo-alt-fill text-danger me-1"></i>Gedung 4, Lantai 1 (Samping Auditorium)</span>
                            <span class="fw-semibold text-primary">08:00 &ndash; 16:30 WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================== -->
<!-- 2. METRIK PELAYANAN & KEUNGGULAN (RAPI & SIMETRIS) -->
<!-- ============================================== -->
<div class="container position-relative stats-overlap">
    <div class="row g-3">
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start bg-white">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-door-open fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary"><?= esc($stats['rooms_count'] ?? 5) ?>+ Ruang &amp; Aula</h4>
                        <small class="text-muted d-block">Fasilitas Representatif</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start bg-white">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-car-front fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary"><?= esc($stats['vehicles_count'] ?? 4) ?> Armada Mobil</h4>
                        <small class="text-muted d-block">Siap Penugasan Kampus</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start bg-white">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-tools fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary"><?= esc($stats['resolved_requests'] ?? 28) ?>+ Tiket Selesai</h4>
                        <small class="text-muted d-block">Standar Respon Cepat</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start bg-white">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary">100% Terlindungi</h4>
                        <small class="text-muted d-block">Privasi UU PDP &bull; Lacak Tiket</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- 3. KATALOG 6 LAYANAN DIGITAL TERPADU           -->
<!-- ============================================== -->
<section class="py-5" id="layanan-utama">
    <div class="container py-4">
        <!-- Section Header -->
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                KATALOG LAYANAN DIGITAL
            </span>
            <h2 class="fw-bold display-6 mb-2 text-dark">
                Portal Pelayanan Fasilitas Kampus
            </h2>
            <p class="text-muted fs-6">
                Pilih layanan yang Anda butuhkan sesuai dengan kategori akses civitas akademika atau publik.
            </p>
        </div>

        <!-- SUB-HEADING 1: LAYANAN KHUSUS CIVITAS AKADEMIKA -->
        <div class="category-header-box mb-4 pb-2 border-bottom">
            <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-semibold small mb-2 d-inline-block">
                <i class="bi bi-shield-lock-fill me-1"></i> CIVITAS AKADEMIKA
            </span>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-1">
                <h4 class="fw-bold text-dark mb-0">Layanan Akademik &amp; Kedinasan</h4>
                <small class="text-muted">Khusus Dosen, Tenaga Kependidikan, dan Mahasiswa (Wajib Login SSO)</small>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <!-- LAYANAN 1: PINJAM RUANGAN -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm service-card border bg-white">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-door-open-fill fs-4"></i>
                            </div>
                            <span class="badge bg-light text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold">
                                Ruangan
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-2">Peminjaman Ruangan</h5>
                        <p class="text-muted small mb-4 flex-grow-1 service-card-desc">
                            Reservasi ruang rapat, auditorium, dan aula kampus untuk perkuliahan, rapat kerja, dan seminar akademik.
                        </p>
                        <a href="/peminjaman/ruangan" class="btn btn-primary w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2 rounded-pill mt-auto">
                            <span>Ajukan Ruangan</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 2: PINJAM KENDARAAN -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm service-card border bg-white">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-car-front-fill fs-4"></i>
                            </div>
                            <span class="badge bg-light text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold">
                                Kendaraan
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-2">Peminjaman Kendaraan</h5>
                        <p class="text-muted small mb-4 flex-grow-1 service-card-desc">
                            Permohonan armada mobil dinas kampus untuk perjalanan dinas resmi, kompetisi, dan penugasan universitas.
                        </p>
                        <a href="/peminjaman/kendaraan" class="btn btn-primary w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2 rounded-pill mt-auto">
                            <span>Ajukan Kendaraan</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 3: REQUEST MAINTENANCE -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm service-card border bg-white">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-tools fs-4"></i>
                            </div>
                            <span class="badge bg-light text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold">
                                Perbaikan
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-2">Request Maintenance</h5>
                        <p class="text-muted small mb-4 flex-grow-1 service-card-desc">
                            Laporan perbaikan sarana kampus meliputi AC, kelistrikan, sanitasi air, proyektor, dan fasilitas belajar.
                        </p>
                        <a href="/request/maintenance" class="btn btn-primary w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2 rounded-pill mt-auto">
                            <span>Lapor Perbaikan</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 4: REQUEST SUPPLIES (ATK) -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm service-card border bg-white">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-box-seam-fill fs-4"></i>
                            </div>
                            <span class="badge bg-light text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold">
                                Persediaan
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-2">Permohonan ATK</h5>
                        <p class="text-muted small mb-4 flex-grow-1 service-card-desc">
                            Pengajuan alat tulis kantor dan perlengkapan administrasi kerja unit dosen dan staf secara terstruktur.
                        </p>
                        <a href="/request/supplies" class="btn btn-primary w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2 rounded-pill mt-auto">
                            <span>Ajukan ATK</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUB-HEADING 2: LAYANAN PUBLIK & TAMU KAMPUS -->
        <div class="category-header-box mb-4 pb-2 border-bottom">
            <span class="badge bg-success text-white rounded-pill px-3 py-1.5 fw-semibold small mb-2 d-inline-block">
                <i class="bi bi-globe me-1"></i> UMUM &amp; PUBLIK
            </span>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-1">
                <h4 class="fw-bold text-dark mb-0">Layanan Publik &amp; Tamu Kampus</h4>
                <small class="text-muted">Terbuka untuk Tamu Dinas, Rekanan, Mahasiswa, dan Masyarakat Umum (Tanpa Login)</small>
            </div>
        </div>

        <div class="row g-4">
            <!-- LAYANAN 5: LOST & FOUND -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm service-card border bg-white border-top-accent-blue">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-info bg-opacity-10 text-primary">
                                <i class="bi bi-search-heart-fill fs-4 text-primary"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 small fw-bold">
                                Terbuka untuk Umum
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Lost &amp; Found (Barang Hilang / Ditemukan)</h4>
                        <p class="text-muted small mb-4 flex-grow-1 service-card-desc">
                            Pusat inventarisasi barang hilang dan temuan di seluruh gedung serta kawasan kampus UPT. Pemilik barang dapat melacak dan mengonfirmasi klaim pengambilan secara aman.
                        </p>
                        <a href="/pelaporan/lost-found" class="btn btn-outline-primary py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-pill mt-auto">
                            <span>Formulir Lost &amp; Found</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 6: VISITOR ID PASS -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm service-card border bg-white border-top-accent-blue">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-info bg-opacity-10 text-primary">
                                <i class="bi bi-person-vcard-fill fs-4 text-primary"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 small fw-bold">
                                Terbuka untuk Umum
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Visitor Pass (Buku Tamu Digital)</h4>
                        <p class="text-muted small mb-4 flex-grow-1 service-card-desc">
                            Registrasi buku tamu digital kampus bagi tamu dinas universitas, rekanan instansi, narasumber, dan wali mahasiswa demi ketertiban serta keamanan lingkungan kampus.
                        </p>
                        <a href="/pelaporan/visitor" class="btn btn-outline-primary py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-pill mt-auto">
                            <span>Registrasi Buku Tamu</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 4. KALENDER JADWAL FASILITAS KAMPUS (DIPERCANTIK & ANTI BENTROK) -->
<!-- ============================================================== -->
<section class="py-5" id="jadwal-kalender" style="background-color: var(--light-bg);">
    <div class="container py-3">
        <!-- Header Section Kalender -->
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4 gap-3">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                    <i class="bi bi-calendar-week-fill me-1"></i> JADWAL FASILITAS REAL-TIME
                </span>
                <h2 class="fw-bold display-6 mb-2 text-dark">
                    Kalender Ketersediaan Fasilitas
                </h2>
                <p class="text-muted fs-6 mb-0">
                    Cek jadwal pemakaian ruangan dan kendaraan kampus secara real-time sebelum mengajukan permohonan.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="/peminjaman/ruangan" class="btn btn-success rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-door-open-fill"></i>
                    <span>Pinjam Ruangan</span>
                </a>
                <a href="/peminjaman/kendaraan" class="btn btn-primary rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Pinjam Kendaraan</span>
                </a>
            </div>
        </div>

        <!-- Filter Pills & Legenda Warna Kalender (Tata Letak Rapi) -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 p-3 bg-white calendar-control-card">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-bold text-dark text-nowrap"><i class="bi bi-funnel-fill text-primary"></i> Filter Kategori:</span>
                        <div class="btn-group w-100" role="group" id="calendarFilterButtons">
                            <button type="button" class="btn btn-sm btn-primary active fw-semibold rounded-start-pill px-3" data-filter="all">Semua Jadwal</button>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-3" data-filter="room">🏢 Ruangan</button>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold rounded-end-pill px-3" data-filter="vehicle">🚗 Kendaraan</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-3 small">
                        <span class="text-muted fw-semibold">Indikator Warna:</span>
                        <span class="d-inline-flex align-items-center gap-1.5 legend-item">
                            <span class="legend-color-dot" style="background-color: #059669;"></span>
                            <span class="text-secondary fw-semibold">Ruangan Disetujui</span>
                        </span>
                        <span class="d-inline-flex align-items-center gap-1.5 legend-item">
                            <span class="legend-color-dot" style="background-color: #0284c7;"></span>
                            <span class="text-secondary fw-semibold">Kendaraan Disetujui</span>
                        </span>
                        <span class="d-inline-flex align-items-center gap-1.5 legend-item">
                            <span class="legend-color-dot" style="background-color: #ea580c;"></span>
                            <span class="text-secondary fw-semibold">Menunggu Verifikasi</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wadah Utama FullCalendar yang Dipercantik -->
        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white calendar-main-wrapper">
            <div id="facilityCalendar" style="min-height: 600px;"></div>
        </div>
    </div>
</section>

<!-- Modal Detail Event Kalender (Format Slip Resmi Reservasi) -->
<div class="modal fade" id="modalCalendarEventDetail" tabindex="-1" aria-labelledby="modalCalendarEventDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-bottom py-3 px-4" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%); color: white;">
                <div class="d-flex align-items-center gap-2">
                    <span id="calModalBadge" class="badge rounded-pill px-3 py-1.5 fw-semibold shadow-sm"></span>
                    <h5 class="modal-title fw-bold text-white mb-0" id="modalCalendarEventDetailLabel" style="font-size: 1.1rem;">Rincian Jadwal Peminjaman</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-dark bg-white">
                <div class="mb-3 pb-2 border-bottom">
                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">Agenda / Keperluan Kegiatan</small>
                    <h5 class="fw-bold text-primary mb-0 mt-1" id="calModalEventTitle">-</h5>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 bg-light border">
                            <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.78rem;"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Fasilitas / Armada:</small>
                            <span class="fw-bold text-dark d-block fs-6" id="calModalResourceName">-</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 bg-light border">
                            <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.78rem;"><i class="bi bi-clock-fill text-warning me-1"></i>Tanggal &amp; Waktu:</small>
                            <span class="fw-bold text-dark d-block fs-6" id="calModalDateTime">-</span>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light border mb-3">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-semibold" style="font-size: 0.78rem;">Nama Pemohon:</small>
                            <span class="fw-bold text-dark" id="calModalBooker">-</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-semibold" style="font-size: 0.78rem;">Unit Kerja / Program Studi:</small>
                            <span class="fw-bold text-dark" id="calModalDepartment">-</span>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light border mb-3" id="calModalExtraBox">
                    <small class="text-muted d-block fw-semibold mb-1" id="calModalExtraLabel" style="font-size: 0.78rem;">Keterangan &amp; Setup:</small>
                    <span class="text-dark small" id="calModalExtraValue">-</span>
                </div>

                <div class="alert alert-info border-0 rounded-3 mb-0 d-none" id="calModalAdminNoteBox">
                    <div class="d-flex gap-2">
                        <i class="bi bi-info-circle-fill fs-5 text-info flex-shrink-0"></i>
                        <div>
                            <strong class="d-block text-dark small">Catatan Verifikasi Biro Sarpras:</strong>
                            <span class="small text-dark" id="calModalAdminNote">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light px-4 py-3 justify-content-between">
                <span class="small" id="calModalStatusText">Status: -</span>
                <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- 5. STANDAR OPERASIONAL PROSEDUR (SLA & ALUR)   -->
<!-- ============================================== -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                STANDAR PROSEDUR LAYANAN (SOP)
            </span>
            <h2 class="fw-bold display-6 mb-2 text-dark">
                Alur Pengajuan Layanan
            </h2>
            <p class="text-muted fs-6">
                Empat langkah ringkas dan transparan untuk mengakses fasilitas kampus.
            </p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 h-100 d-flex flex-column align-items-center">
                    <div class="step-circle bg-primary text-white mb-3 shadow">
                        1
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Pilih Layanan</h5>
                    <p class="text-muted small mb-0">
                        Tentukan fasilitas atau permohonan yang Anda butuhkan di portal resmi Sarpras.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 h-100 d-flex flex-column align-items-center">
                    <div class="step-circle bg-primary text-white mb-3 shadow">
                        2
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Isi Formulir</h5>
                    <p class="text-muted small mb-0">
                        Lengkapi jadwal penggunaan, kebutuhan teknis, dan identitas penanggung jawab.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 h-100 d-flex flex-column align-items-center">
                    <div class="step-circle bg-primary text-white mb-3 shadow">
                        3
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Verifikasi Sarpras</h5>
                    <p class="text-muted small mb-0">
                        Tim biro memvalidasi ketersediaan aset secara real-time maksimal 1x24 jam kerja.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 h-100 d-flex flex-column align-items-center">
                    <div class="step-circle bg-success text-white mb-3 shadow">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Fasilitas Siap Pakai</h5>
                    <p class="text-muted small mb-0">
                        Persetujuan terbit di dashboard pemohon dan fasilitas siap digunakan sesuai jadwal.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 6. PUSAT INFORMASI & LOKET BIRO SARPRAS (SESUAI CATATAN USER)   -->
<!-- ============================================================== -->
<section class="py-5" style="background-color: var(--light-bg);">
    <div class="container py-3">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="row g-0">
                <!-- Info Kontak & Lokasi Fisik -->
                <div class="col-lg-7 p-4 p-lg-5 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-primary bg-opacity-10 text-primary fw-bold small mb-3">
                            <i class="bi bi-building-fill"></i>
                            <span>PUSAT PELAYANAN &amp; LOKET SARPRAS</span>
                        </div>
                        <h3 class="fw-bold text-dark mb-2">
                            Pusat Informasi &amp; Loket Pelayanan
                        </h3>
                        <p class="text-muted mb-4 small">
                            Untuk konsultasi langsung, serah terima persediaan ATK, serta pengambilan kunci ruangan dan kendaraan dinas, silakan kunjungi loket pelayanan fisik kami.
                        </p>

                        <div class="row g-3 mb-4">
                            <!-- Lokasi Loket Fisik Sesuai Request User -->
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                                        <i class="bi bi-geo-alt-fill fs-5"></i>
                                        <strong class="text-dark small">Lokasi Loket Pelayanan Fisik</strong>
                                    </div>
                                    <p class="mb-0 fw-bold text-dark fs-6">
                                        Gedung 4, Lantai 1
                                    </p>
                                    <small class="text-muted">(Samping Auditorium)</small>
                                </div>
                            </div>

                            <!-- Jam Kerja Pelayanan -->
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2 text-primary">
                                        <i class="bi bi-clock-history fs-5"></i>
                                        <strong class="text-dark small">Jam Operasional Layanan</strong>
                                    </div>
                                    <p class="mb-0 fw-bold text-dark fs-6">
                                        Senin &ndash; Jumat
                                    </p>
                                    <small class="text-muted">08:00 &ndash; 16:30 WIB</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Cepat Sesuai Request User -->
                    <div class="pt-3 border-top d-flex flex-wrap align-items-center gap-3">
                        <span class="small fw-bold text-dark">Kontak Cepat:</span>
                        <a href="mailto:sarpras@upitra.ac.id" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                            <i class="bi bi-envelope-at me-1"></i> sarpras@upitra.ac.id
                        </a>
                        <a href="https://sarpras.upitra.ac.id" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold">
                            <i class="bi bi-globe me-1"></i> sarpras.upitra.ac.id
                        </a>
                    </div>
                </div>

                <!-- Banner Panel Sisi Kanan (Deep Blue Gradient) -->
                <div class="col-lg-5 p-4 p-lg-5 text-white d-flex flex-column justify-content-between position-relative overflow-hidden" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%);">
                    <div class="position-relative z-1">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-3 text-white">
                                <i class="bi bi-mortarboard-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-white">Universitas Pignatelli Triputra</h5>
                                <small class="text-white-50">Excellence, Compassion, &amp; Integrity</small>
                            </div>
                        </div>

                        <h4 class="fw-bold text-white mb-2">
                            Tata Kelola Sarpras Berintegritas
                        </h4>

                        <p class="text-white-50 small mb-4">
                            Mendukung seluruh kegiatan perkuliahan, riset, dan operasional kampus dengan penyediaan sarana yang prima, tertib, dan transparan.
                        </p>
                    </div>

                    <div class="position-relative z-1 pt-3 border-top border-white border-opacity-20 d-flex flex-wrap gap-2">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <a href="/dashboard" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                                <i class="bi bi-speedometer2 me-1"></i> Buka Dashboard
                            </a>
                        <?php else: ?>
                            <a href="/login" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Akun Civitas
                            </a>
                        <?php endif; ?>
                        <a href="#layanan-utama" class="btn btn-outline-light rounded-pill px-3">
                            Jelajahi Layanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================== -->
<!-- CSS KHUSUS HALAMAN DEPAN (HOME PAGE PREMIUM)   -->
<!-- ============================================== -->
<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #051F38 0%, #0A3A66 45%, #0D62AC 100%);
    border-bottom-left-radius: 40px;
    border-bottom-right-radius: 40px;
    box-shadow: 0 15px 35px rgba(10, 58, 102, 0.18);
    position: relative;
}
.hero-bg-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle at 85% 20%, rgba(255, 255, 255, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 10% 80%, rgba(42, 133, 208, 0.22) 0%, transparent 60%);
    pointer-events: none;
}
.hero-institution-badge {
    background-color: rgba(255, 255, 255, 0.16);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}
.fw-extrabold {
    font-weight: 800;
}
.tracking-tight {
    letter-spacing: -0.5px;
}
.max-w-700 {
    max-width: 700px;
}

/* Hero CTA Buttons */
.btn-hero-cta {
    transition: all 0.25s ease;
}
.btn-hero-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(255, 255, 255, 0.25) !important;
}
.btn-hero-secondary {
    border-width: 1.5px;
    transition: all 0.25s ease;
}
.btn-hero-secondary:hover {
    background: rgba(255, 255, 255, 0.18);
    color: #ffffff;
    transform: translateY(-2px);
}

/* Hero Status Card (Sisi Kanan) */
.hero-status-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hero-status-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
}
.status-pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #10B981;
    display: inline-block;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.35);
    animation: statusPulse 2s infinite ease-in-out;
}
@keyframes statusPulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
.readiness-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.readiness-item {
    transition: all 0.2s ease;
}
.readiness-item:hover {
    background-color: #ffffff !important;
    border-color: #cbd5e1 !important;
    box-shadow: 0 4px 12px rgba(10, 58, 102, 0.06);
    transform: translateX(3px);
}
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Service Cards */
.service-card {
    border-radius: 20px;
    border: 1px solid var(--card-border) !important;
    transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease, border-color 0.3s ease;
}
.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(10, 58, 102, 0.1) !important;
    border-color: rgba(13, 98, 172, 0.35) !important;
}
.service-badge-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.service-card-desc {
    line-height: 1.55;
    font-size: 0.875rem !important;
}
.border-top-accent-blue {
    border-top: 4px solid var(--accent-blue) !important;
}
.category-header-box {
    margin-top: 1rem;
}

/* Stats Overlap */
.stats-overlap {
    margin-top: -35px;
    z-index: 10;
}
.stat-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border: 1px solid rgba(226, 232, 240, 0.8) !important;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(10, 58, 102, 0.08) !important;
}
.stat-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Step Circles */
.step-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
}

/* Kalender Controls & Theme */
.calendar-control-card {
    border: 1px solid #e2e8f0 !important;
}
.legend-color-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}
.calendar-main-wrapper {
    border: 1px solid #e2e8f0 !important;
    border-radius: 24px !important;
    box-shadow: 0 10px 30px rgba(10, 58, 102, 0.05) !important;
}
#facilityCalendar {
    font-family: inherit;
    --fc-border-color: #e2e8f0;
    --fc-today-bg-color: #f0f7ff;
}
.fc-theme-standard td, .fc-theme-standard th {
    border-color: #e2e8f0 !important;
}
.fc-toolbar-title {
    font-size: 1.25rem !important;
    font-weight: 700 !important;
    color: var(--primary-blue) !important;
}
.fc-button-primary {
    background-color: var(--secondary-blue) !important;
    border-color: var(--secondary-blue) !important;
    border-radius: 8px !important;
    font-size: 0.85rem !important;
    font-weight: 600 !important;
    padding: 6px 14px !important;
    transition: all 0.2s ease !important;
}
.fc-button-primary:hover, .fc-button-primary:focus {
    background-color: var(--primary-blue) !important;
    border-color: var(--primary-blue) !important;
}
.fc-button-active {
    background-color: var(--primary-blue) !important;
    border-color: var(--primary-blue) !important;
    box-shadow: inset 0 3px 5px rgba(0,0,0,0.125) !important;
}
.fc-event {
    cursor: pointer;
    border-radius: 6px !important;
    padding: 3px 6px !important;
    font-size: 0.82rem !important;
    font-weight: 500 !important;
    border: none !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    transition: transform 0.15s ease;
}
.fc-event:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.12);
}
.fc-col-header-cell-cushion {
    font-weight: 600 !important;
    color: var(--primary-blue) !important;
    padding: 8px 4px !important;
    text-decoration: none !important;
}
.fc-daygrid-day-number {
    font-weight: 500;
    color: #475569;
    padding: 6px 8px !important;
    text-decoration: none !important;
}
.fc-day-today {
    background-color: #f0f7ff !important;
}
.fc-day-today .fc-daygrid-day-number {
    font-weight: 700 !important;
    color: var(--secondary-blue) !important;
}
</style>

<!-- FullCalendar v6 CDN -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('facilityCalendar');
    if (!calendarEl) return;

    let currentFilter = 'all';
    let allCalendarEvents = [];

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            week: 'Minggu',
            list: 'Daftar'
        },
        locale: 'id',
        navLinks: true,
        editable: false,
        selectable: false,
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        height: 'auto',
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('/api/calendar-events')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    allCalendarEvents = data;
                    if (currentFilter === 'all') {
                        successCallback(allCalendarEvents);
                    } else {
                        const filtered = allCalendarEvents.filter(evt => evt.extendedProps && evt.extendedProps.category === currentFilter);
                        successCallback(filtered);
                    }
                })
                .catch(err => {
                    console.error('Gagal mengambil jadwal kalender:', err);
                    failureCallback(err);
                });
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            const event = info.event;
            const props = event.extendedProps || {};
            const isRoom = props.category === 'room';
            const isApproved = props.status === 'approved';

            // Modal Badge
            const badgeEl = document.getElementById('calModalBadge');
            if (badgeEl) {
                badgeEl.className = 'badge rounded-pill px-3 py-1.5 fw-semibold ' + 
                    (isApproved ? (isRoom ? 'bg-success text-white' : 'bg-info text-white') : 'bg-warning text-dark');
                badgeEl.innerHTML = (isRoom ? '<i class="bi bi-door-open-fill me-1"></i> Ruangan' : '<i class="bi bi-car-front-fill me-1"></i> Kendaraan') + 
                    ' &bull; ' + (isApproved ? 'Approved' : 'Pending');
            }

            document.getElementById('calModalEventTitle').textContent = props.eventTitle || event.title;
            document.getElementById('calModalResourceName').textContent = props.resourceName || '-';
            document.getElementById('calModalDateTime').textContent = (props.date || '-') + ' (' + (props.time || '-') + ')';
            document.getElementById('calModalBooker').textContent = props.bookerName || '-';
            document.getElementById('calModalDepartment').textContent = props.department || '-';

            const extraLabel = document.getElementById('calModalExtraLabel');
            const extraValue = document.getElementById('calModalExtraValue');
            if (isRoom) {
                extraLabel.innerHTML = '<i class="bi bi-gear-fill text-secondary me-1"></i>Setup &amp; Perlengkapan:';
                let extraTxt = [];
                if (props.setup) extraTxt.push('Setup Ruangan: ' + props.setup);
                if (props.materials) extraTxt.push('Perlengkapan: ' + props.materials);
                if (props.special) extraTxt.push('Permintaan Khusus: ' + props.special);
                extraValue.textContent = extraTxt.length > 0 ? extraTxt.join(' | ') : 'Tidak ada catatan tambahan.';
            } else {
                extraLabel.innerHTML = '<i class="bi bi-info-circle-fill text-secondary me-1"></i>Supir &amp; Keterangan Dinas:';
                let extraTxt = [];
                if (props.driver) extraTxt.push('Supir: ' + props.driver);
                if (props.description) extraTxt.push('Keterangan: ' + props.description);
                extraValue.textContent = extraTxt.length > 0 ? extraTxt.join(' | ') : 'Tidak ada keterangan tambahan.';
            }

            const adminNoteBox = document.getElementById('calModalAdminNoteBox');
            const adminNoteVal = document.getElementById('calModalAdminNote');
            if (props.adminNote && props.adminNote.trim() !== '') {
                adminNoteVal.textContent = props.adminNote;
                adminNoteBox.classList.remove('d-none');
            } else {
                adminNoteBox.classList.add('d-none');
            }

            const statusText = document.getElementById('calModalStatusText');
            if (statusText) {
                statusText.innerHTML = 'Status: <strong class="' + (isApproved ? 'text-success' : 'text-warning') + '">' + 
                    (props.statusLabel || (isApproved ? 'Disetujui' : 'Menunggu Konfirmasi')) + '</strong>';
            }

            const modal = new bootstrap.Modal(document.getElementById('modalCalendarEventDetail'));
            modal.show();
        }
    });

    calendar.render();

    // Filter Buttons Listener
    const filterButtons = document.querySelectorAll('#calendarFilterButtons button');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => {
                b.classList.remove('active', 'btn-primary');
                b.classList.add('btn-outline-primary');
            });
            this.classList.add('active', 'btn-primary');
            this.classList.remove('btn-outline-primary');

            currentFilter = this.getAttribute('data-filter');
            calendar.refetchEvents();
        });
    });

    // Handle Window Resize Responsiveness
    window.addEventListener('resize', function () {
        if (window.innerWidth < 768 && calendar.view.type !== 'listMonth') {
            calendar.changeView('listMonth');
        } else if (window.innerWidth >= 768 && calendar.view.type === 'listMonth') {
            calendar.changeView('dayGridMonth');
        }
    });
});
</script>

<?= $this->endSection() ?>
