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
                    <span class="badge bg-white text-primary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">RESMI</span>
                    <span class="small fw-semibold text-white pe-1">Biro Sarana dan Prasarana &bull; Universitas Pignatelli Triputra</span>
                </div>
                
                <h1 class="display-4 fw-extrabold mb-3 tracking-tight lh-sm hero-title">
                    Infrastruktur Kampus Terpadu, Pelayanan Cepat & Transparan
                </h1>
                
                <p class="lead mb-4 text-white-50 fs-5 pe-lg-4 fw-light hero-description">
                    Portal digital terintegrasi untuk reservasi ruangan representatif, peminjaman kendaraan dinas, perbaikan fasilitas kampus, permohonan persediaan ATK, dan layanan publik bagi seluruh civitas akademika.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-4">
                    <a href="#layanan-utama" class="btn btn-light text-primary fw-bold px-4 py-3 rounded-pill shadow-lg d-inline-flex align-items-center gap-2 btn-hero-cta">
                        <i class="bi bi-grid-fill"></i>
                        <span>Katalog 6 Layanan</span>
                        <i class="bi bi-arrow-down-short fs-5"></i>
                    </a>

                    <a href="#jadwal-kalender" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill d-inline-flex align-items-center gap-2 btn-hero-secondary">
                        <i class="bi bi-calendar3"></i>
                        <span>Kalender Fasilitas</span>
                        <i class="bi bi-arrow-right-short fs-5"></i>
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
                        <span class="text-white-75">Sistem Anti Double-Booking Real-Time</span>
                    </div>
                    <div class="d-none d-sm-inline opacity-50">&bull;</div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-info fs-5"></i>
                        <span class="text-white-75">Standar Respon SLA &lt; 24 Jam Kerja</span>
                    </div>
                </div>
            </div>

            <!-- Sisi Kanan: Live Asset Readiness & Operational Status Panel (Menghilangkan Duplikasi Link) -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white text-dark p-3 hero-status-card">
                    <div class="card-body p-3 p-md-4">
                        <!-- Header Card Status -->
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-2.5">
                                <img src="/logo.png" alt="Logo UPT" style="height: 42px; width: auto;" class="rounded-2 p-1 border bg-white shadow-sm">
                                <div>
                                    <h6 class="fw-bold mb-0 text-primary">Kesiapan Aset &amp; Layanan</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">Biro Sarpras UPT &bull; Status Hari Ini</small>
                                </div>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 small fw-bold d-inline-flex align-items-center gap-1">
                                <span class="status-pulse-dot"></span>
                                <span>Operasional Aktif</span>
                            </span>
                        </div>

                        <!-- 3 Aspek Kesiapan Sarpras -->
                        <div class="d-flex flex-column gap-3 mb-3">
                            <!-- Status Ruangan -->
                            <div class="p-3 rounded-3 bg-light border border-light-subtle d-flex align-items-start gap-3 readiness-item">
                                <div class="readiness-icon bg-primary bg-opacity-10 text-primary rounded-3 p-2 text-center">
                                    <i class="bi bi-door-open-fill fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark small">Ruang Rapat &amp; Aula Kampus</strong>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">Tersedia &amp; Terawat</span>
                                    </div>
                                    <p class="text-muted mb-0 small" style="font-size: 0.8rem;">
                                        Auditorium, Excellent, Compassion, Integrity, &amp; MFH Hall dengan fasilitas AC, sound system, &amp; proyektor.
                                    </p>
                                </div>
                            </div>

                            <!-- Status Kendaraan -->
                            <div class="p-3 rounded-3 bg-light border border-light-subtle d-flex align-items-start gap-3 readiness-item">
                                <div class="readiness-icon bg-primary bg-opacity-10 text-primary rounded-3 p-2 text-center">
                                    <i class="bi bi-car-front-fill fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark small">Armada Kendaraan Dinas</strong>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill small">Siap Jalan</span>
                                    </div>
                                    <p class="text-muted mb-0 small" style="font-size: 0.8rem;">
                                        Toyota Avanza, Innova, dan Isuzu Elf siap melayani perjalanan dinas akademik dengan supir resmi.
                                    </p>
                                </div>
                            </div>

                            <!-- Status Pemeliharaan -->
                            <div class="p-3 rounded-3 bg-light border border-light-subtle d-flex align-items-start gap-3 readiness-item">
                                <div class="readiness-icon bg-primary bg-opacity-10 text-primary rounded-3 p-2 text-center">
                                    <i class="bi bi-tools fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark small">Tanggap Perbaikan Fasilitas</strong>
                                        <span class="badge bg-warning bg-opacity-10 text-dark rounded-pill small">Siaga Respon</span>
                                    </div>
                                    <p class="text-muted mb-0 small" style="font-size: 0.8rem;">
                                        Tim teknisi siaga untuk penanganan AC kelas, kelistrikan, sanitasi air, dan sarana IT pembelajaran.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Info Loket Fisik -->
                        <div class="pt-2 border-top d-flex align-items-center justify-content-between text-muted small" style="font-size: 0.78rem;">
                            <span><i class="bi bi-geo-alt-fill text-danger me-1"></i>Gedung 4, Lantai 1 (Samping Auditorium)</span>
                            <span class="fw-semibold text-primary">08:00 - 16:30 WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================== -->
<!-- 2. STANDAR PELAYANAN & METRIK KEUNGGULAN       -->
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
                        <h4 class="fw-bold mb-0 text-primary">5+ Ruang &amp; Aula</h4>
                        <small class="text-muted d-block">Representatif &amp; Ber-AC</small>
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
                        <h4 class="fw-bold mb-0 text-primary">Armada Mobil Dinas</h4>
                        <small class="text-muted d-block">Terawat &amp; Siap Penugasan</small>
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
                        <h4 class="fw-bold mb-0 text-primary">&lt; 24 Jam Kerja</h4>
                        <small class="text-muted d-block">SLA Respon Pemeliharaan</small>
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
                        <h4 class="fw-bold mb-0 text-primary">Layanan Terbuka</h4>
                        <small class="text-muted d-block">Lost &amp; Found &amp; Buku Tamu</small>
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
                Portal Pelayanan Terpadu Sarana &amp; Prasarana
            </h2>
            <p class="text-muted fs-6">
                Seluruh kebutuhan reservasi, pengadaan, perbaikan, dan pelaporan aset kampus dapat diakses secara daring dengan pembagian hak akses yang transparan.
            </p>
        </div>

        <!-- SUB-HEADING 1: LAYANAN KHUSUS CIVITAS AKADEMIKA -->
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fw-semibold small">
                    <i class="bi bi-lock-fill me-1"></i> CIVITAS AKADEMIKA
                </span>
                <span class="fw-bold text-dark fs-5">Layanan Akademik &amp; Kedinasan (Wajib Login SSO)</span>
            </div>
            <small class="text-muted d-none d-md-inline">Khusus Mahasiswa &amp; Dosen UPT</small>
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
                        <p class="text-muted small mb-3 flex-grow-1">
                            Reservasi ruang rapat &amp; aula representatif (Excellent, Compassion, Integrity, Auditorium, MFH) untuk perkuliahan, rapat, dan seminar.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Auditorium</span>
                            <span class="badge bg-light text-secondary border">Meeting Room</span>
                            <span class="badge bg-light text-secondary border">AC &amp; Sound</span>
                        </div>
                        <a href="/peminjaman/ruangan" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
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
                        <p class="text-muted small mb-3 flex-grow-1">
                            Booking armada mobil dinas universitas (Avanza, Innova, Isuzu Elf) untuk perjalanan dinas resmi, kompetisi, dan penugasan kampus.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Avanza &amp; Innova</span>
                            <span class="badge bg-light text-secondary border">Isuzu Elf</span>
                            <span class="badge bg-light text-secondary border">Driver Resmi</span>
                        </div>
                        <a href="/peminjaman/kendaraan" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
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
                        <p class="text-muted small mb-3 flex-grow-1">
                            Laporan perbaikan fasilitas kampus meliputi AC ruangan, kelistrikan &amp; lampu, sanitasi air, proyektor kelas, dan jaringan IT penunjang.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">AC &amp; Listrik</span>
                            <span class="badge bg-light text-secondary border">Sanitasi</span>
                            <span class="badge bg-light text-secondary border">Fasilitas IT</span>
                        </div>
                        <a href="/request/maintenance" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
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
                        <p class="text-muted small mb-3 flex-grow-1">
                            Pengajuan alat tulis kantor dan perlengkapan administrasi akademik (kertas, pulpen, map, ordner, tinta) dengan input multi-item praktis.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Multi-Item</span>
                            <span class="badge bg-light text-secondary border">Kertas &amp; Tinta</span>
                            <span class="badge bg-light text-secondary border">Stok Real-Time</span>
                        </div>
                        <a href="/request/supplies" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>Ajukan ATK</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUB-HEADING 2: LAYANAN PUBLIK & TAMU KAMPUS -->
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success text-white rounded-pill px-3 py-1.5 fw-semibold small">
                    <i class="bi bi-globe me-1"></i> UMUM &amp; PUBLIK
                </span>
                <span class="fw-bold text-dark fs-5">Layanan Terbuka untuk Seluruh Pengunjung Kampus (Tanpa Login)</span>
            </div>
            <small class="text-muted d-none d-md-inline">Akses Terbuka untuk Tamu, Kurir, &amp; Warga Kampus</small>
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
                        <p class="text-muted small mb-3 flex-grow-1">
                            Pusat inventarisasi barang hilang dan barang yang ditemukan di seluruh gedung dan lingkungan kampus UPT. Pemilik barang dapat melacak dan mengonfirmasi pengambilan barang dengan cepat dan aman.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-light text-secondary border"><i class="bi bi-check2 me-1"></i>Tanpa Registrasi Akun</span>
                            <span class="badge bg-light text-secondary border"><i class="bi bi-check2 me-1"></i>Lapor Barang Hilang</span>
                            <span class="badge bg-light text-secondary border"><i class="bi bi-check2 me-1"></i>Klaim Pengambilan Aman</span>
                        </div>
                        <a href="/pelaporan/lost-found" class="btn btn-outline-primary py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-pill">
                            <span>Buka Form Pelaporan Lost &amp; Found</span>
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
                        <h4 class="card-title fw-bold mb-2">Visitor ID Pass (Buku Tamu Digital)</h4>
                        <p class="text-muted small mb-3 flex-grow-1">
                            Sistem registrasi buku tamu digital kampus untuk pengunjung, tamu dinas universitas, mitra instansi, narasumber, maupun orang tua mahasiswa guna menjaga ketertiban, keamanan, dan tata kelola kampus.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-light text-secondary border"><i class="bi bi-check2 me-1"></i>Check-in Digital Cepat</span>
                            <span class="badge bg-light text-secondary border"><i class="bi bi-check2 me-1"></i>Verifikasi Pejabat / Host</span>
                            <span class="badge bg-light text-secondary border"><i class="bi bi-check2 me-1"></i>Ketertiban Kampus</span>
                        </div>
                        <a href="/pelaporan/visitor" class="btn btn-outline-primary py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-pill">
                            <span>Registrasi Kunjungan Tamu (Visitor Pass)</span>
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
                    Kalender Ketersediaan Ruangan &amp; Kendaraan
                </h2>
                <p class="text-muted fs-6 mb-0">
                    Pantau ketersediaan sarana dan prasarana kampus secara langsung. Sistem secara otomatis memproteksi jadwal dari tabrakan pemesanan (Anti Double-Booking).
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

        <!-- Filter Pills & Legenda Warna Kalender -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 p-3 bg-white calendar-control-card">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-6 col-lg-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-bold text-dark text-nowrap"><i class="bi bi-funnel-fill text-primary"></i> Filter Kategori:</span>
                        <div class="btn-group w-100" role="group" id="calendarFilterButtons">
                            <button type="button" class="btn btn-sm btn-primary active fw-semibold rounded-start-pill px-3" data-filter="all">Semua Jadwal</button>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-3" data-filter="room">🏢 Ruangan</button>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold rounded-end-pill px-3" data-filter="vehicle">🚗 Kendaraan</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-7">
                    <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-3 small">
                        <span class="text-muted fw-semibold">Indikator Warna:</span>
                        <span class="d-inline-flex align-items-center gap-1.5 legend-item">
                            <span class="legend-color-dot" style="background-color: #059669;"></span>
                            <span class="text-secondary fw-semibold">Ruangan (Approved)</span>
                        </span>
                        <span class="d-inline-flex align-items-center gap-1.5 legend-item">
                            <span class="legend-color-dot" style="background-color: #0284c7;"></span>
                            <span class="text-secondary fw-semibold">Kendaraan (Approved)</span>
                        </span>
                        <span class="d-inline-flex align-items-center gap-1.5 legend-item">
                            <span class="legend-color-dot" style="background-color: #ea580c;"></span>
                            <span class="text-secondary fw-semibold">Menunggu Konfirmasi (Pending)</span>
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

<!-- Modal Detail Event Kalender (Didesain Mewah Seperti Tiket/Voucher Reservasi Resmi) -->
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
                Alur Pengajuan Cepat, Tertib, &amp; Terdata
            </h2>
            <p class="text-muted fs-6">
                Empat langkah ringkas untuk memastikan seluruh kegiatan akademik dan operasional kampus terfasilitasi dengan prima.
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
                        Pilih menu peminjaman ruangan, armada mobil dinas, perbaikan fasilitas, atau pelaporan publik sesuai kebutuhan Anda.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 h-100 d-flex flex-column align-items-center">
                    <div class="step-circle bg-primary text-white mb-3 shadow">
                        2
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Isi Formulir Online</h5>
                    <p class="text-muted small mb-0">
                        Lengkapi tanggal pemakaian, rentang waktu, rincian ruangan/armada, keperluan kegiatan, dan kontak narahubung.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 h-100 d-flex flex-column align-items-center">
                    <div class="step-circle bg-primary text-white mb-3 shadow">
                        3
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Verifikasi Bebas Bentrok</h5>
                    <p class="text-muted small mb-0">
                        Sistem &amp; staf Biro Sarpras memvalidasi ketersediaan aset secara real-time dengan standar respon maksimal 1x24 jam kerja.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 h-100 d-flex flex-column align-items-center">
                    <div class="step-circle bg-success text-white mb-3 shadow">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Fasilitas Siap Digunakan</h5>
                    <p class="text-muted small mb-0">
                        Status persetujuan langsung tampil di dashboard pemohon dan sarana prasarana kampus siap dipakai sesuai jadwal.
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
                        <h3 class="fw-bold text-dark mb-3">
                            Kantor Biro Sarana dan Prasarana (Sarpras)
                        </h3>
                        <p class="text-muted mb-4">
                            Untuk konsultasi teknis peminjaman skala besar, koordinasi event universitas, serah terima barang persediaan (ATK), maupun pengambilan kunci ruangan dan mobil dinas, Anda dapat mengunjungi loket pelayanan fisik kami.
                        </p>

                        <div class="row g-3 mb-4">
                            <!-- Lokasi Loket Fisik Sesuai Request User -->
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                                        <i class="bi bi-geo-alt-fill fs-5"></i>
                                        <strong class="text-dark small">Lokasi Loket Pelayanan Fisik</strong>
                                    </div>
                                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">
                                        Gedung 4, Lantai 1
                                    </p>
                                    <small class="text-muted">(Samping Auditorium UPT)</small>
                                </div>
                            </div>

                            <!-- Jam Kerja Pelayanan -->
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3 bg-light border h-100">
                                    <div class="d-flex align-items-center gap-2 mb-2 text-primary">
                                        <i class="bi bi-clock-history fs-5"></i>
                                        <strong class="text-dark small">Jam Operasional Kantor</strong>
                                    </div>
                                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">
                                        Senin &ndash; Jumat
                                    </p>
                                    <small class="text-muted">08:00 &ndash; 16:30 WIB</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Cepat Sesuai Request User -->
                    <div class="pt-3 border-top d-flex flex-wrap align-items-center gap-3">
                        <span class="small fw-bold text-dark">Kontak Cepat Resmi:</span>
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

                        <h4 class="fw-bold text-white mb-3">
                            Mendukung Pembelajaran &amp; Tata Kelola Berintegritas
                        </h4>

                        <p class="text-white-50 small mb-4">
                            Seluruh pemakaian aset universitas dicatat dan dilaporkan secara periodik untuk menjamin pemeliharaan yang berkesinambungan dan kenyamanan seluruh civitas akademika.
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
    width: 44px;
    height: 44px;
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
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.border-top-accent-blue {
    border-top: 4px solid var(--accent-blue) !important;
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
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Step Circle */
.step-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 700;
}

/* Kalender Controls & Theme */
.calendar-control-card {
    border: 1px solid #e2e8f0 !important;
}
.legend-color-dot {
    width: 11px;
    height: 11px;
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
.fc .fc-toolbar.fc-header-toolbar {
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 0.75rem;
}
.fc .fc-toolbar-title {
    font-size: 1.35rem !important;
    font-weight: 800 !important;
    color: var(--primary-blue) !important;
    letter-spacing: -0.3px;
}
.fc .fc-button-primary {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%) !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 6px 14px !important;
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 6px rgba(10, 58, 102, 0.15) !important;
    transition: all 0.2s ease !important;
}
.fc .fc-button-primary:hover {
    background: linear-gradient(135deg, #072B4D 0%, var(--primary-blue) 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(10, 58, 102, 0.25) !important;
}
.fc .fc-button-primary:disabled {
    background: #94a3b8 !important;
    border-color: #94a3b8 !important;
    opacity: 0.65;
}
.fc .fc-button-primary:not(:disabled).fc-button-active, 
.fc .fc-button-primary:not(:disabled):active {
    background: #072B4D !important;
}
.fc .fc-col-header-cell {
    background-color: #f8fafc;
    padding: 10px 0 !important;
}
.fc .fc-col-header-cell-cushion {
    color: #1e293b !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.fc .fc-daygrid-day-number {
    color: #334155 !important;
    text-decoration: none !important;
    font-weight: 600;
    padding: 6px 8px !important;
}
.fc .fc-event {
    cursor: pointer;
    border-radius: 6px;
    padding: 3px 6px;
    font-size: 0.78rem;
    font-weight: 600;
    margin-bottom: 2px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.fc .fc-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.18);
}
.fc .fc-daygrid-more-link {
    font-weight: 700;
    color: var(--secondary-blue) !important;
    text-decoration: none;
    font-size: 0.8rem;
}
.fc-theme-standard td, .fc-theme-standard th {
    border-color: #e2e8f0 !important;
}

@media (max-width: 991.98px) {
    .hero-section {
        border-bottom-left-radius: 28px;
        border-bottom-right-radius: 28px;
    }
    .stats-overlap {
        margin-top: 15px;
    }
}
</style>

<!-- FullCalendar v6 CDN -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('facilityCalendar');
    if (!calendarEl) return;

    let allCalendarEvents = [];
    let currentFilter = 'all';

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
