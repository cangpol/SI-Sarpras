<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- ============================================== -->
<!-- 1. HERO SECTION MODERN (BIRU & PUTIH) -->
<!-- ============================================== -->
<section class="hero-section text-white position-relative overflow-hidden">
    <div class="hero-bg-overlay"></div>
    <div class="container position-relative py-5">
        <div class="row align-items-center py-4 py-lg-5">
            <div class="col-lg-7 text-center text-lg-start mb-4 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill border border-white border-opacity-25 mb-3 shadow-sm" style="background-color: rgba(255, 255, 255, 0.16); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
                    <span class="badge bg-white text-primary rounded-pill px-2.5 py-1 fw-bold shadow-sm" style="font-size: 0.75rem; letter-spacing: 0.5px;">RESMI</span>
                    <span class="small fw-semibold text-white pe-1">Biro Sarana dan Prasarana &bull; Universitas Pignatelli Triputra</span>
                </div>
                
                <h1 class="display-4 fw-extrabold mb-3 tracking-tight lh-sm">
                    Layanan Sarana & Prasarana Kampus Terpadu
                </h1>
                
                <p class="lead mb-4 text-white-50 fs-5 pe-lg-4 fw-light">
                    Sistem informasi digital terintegrasi untuk reservasi ruangan pertemuan, peminjaman kendaraan dinas, perbaikan fasilitas, permohonan ATK, dan layanan publik kampus secara transparan dan efisien.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="#layanan-utama" class="btn btn-light text-primary fw-bold px-4 py-3 rounded-pill shadow-lg d-inline-flex align-items-center gap-2">
                        <i class="bi bi-grid-fill"></i>
                        <span>Jelajahi 6 Layanan</span>
                        <i class="bi bi-arrow-down-short fs-5"></i>
                    </a>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <a href="/dashboard" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill d-inline-flex align-items-center gap-2">
                            <i class="bi bi-speedometer2"></i>
                            <span>Buka Dashboard Saya</span>
                            <i class="bi bi-arrow-right-short fs-5"></i>
                        </a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill d-inline-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Login Akun Civitas</span>
                            <i class="bi bi-arrow-right-short fs-5"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Informasi Jam Operasional Singkat -->
                <div class="d-flex flex-wrap align-items-center gap-3 mt-4 pt-2 text-white-50 small justify-content-center justify-content-lg-start">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-info"></i>
                        <span>Pelayanan Cepat & Terdata</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-info"></i>
                        <span>Akses Mudah via Smartphone & PC</span>
                    </div>
                </div>
            </div>

            <!-- Banner Card Profil Sarpras UPT -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden hero-card bg-white text-dark p-2">
                    <div class="card-body p-4 p-md-4">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                            <div class="logo-box p-2 rounded-3 shadow-sm bg-white border">
                                <img src="/logo.png" alt="Logo UPT" style="height: 52px; width: auto;">
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-primary" style="color: var(--primary-blue) !important;">Universitas Pignatelli Triputra</h5>
                                <small class="text-muted">Biro Sarana dan Prasarana (Sarpras)</small>
                            </div>
                        </div>

                        <h6 class="fw-bold text-uppercase text-muted small mb-3" style="letter-spacing: 0.5px;">Akses Cepat Layanan Unggulan</h6>

                        <div class="list-group list-group-flush gap-2">
                            <a href="/peminjaman/ruangan" class="list-group-item list-group-item-action border rounded-3 p-3 d-flex align-items-center justify-content-between text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="service-icon-circle bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-door-open-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Pinjam Ruangan & Aula</div>
                                        <small class="text-muted">Meeting Room, Auditorium, MFH</small>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>

                            <a href="/peminjaman/kendaraan" class="list-group-item list-group-item-action border rounded-3 p-3 d-flex align-items-center justify-content-between text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="service-icon-circle bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-car-front-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Pinjam Kendaraan Dinas</div>
                                        <small class="text-muted">Avanza, Innova, Elf Kampus</small>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>

                            <a href="/pelaporan/lost-found" class="list-group-item list-group-item-action border rounded-3 p-3 d-flex align-items-center justify-content-between text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="service-icon-circle bg-info bg-opacity-10 text-info-emphasis">
                                        <i class="bi bi-search-heart-fill fs-5 text-info"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Lost & Found (Umum)</div>
                                        <small class="text-muted">Lapor & cari barang hilang</small>
                                    </div>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 small">Publik</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================== -->
<!-- 2. HIGHLIGHT STATISTIK KAMPUS -->
<!-- ============================================== -->
<div class="container position-relative stats-overlap">
    <div class="row g-3">
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-door-open fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary">5+ Ruangan</h4>
                        <small class="text-muted">Auditorium & Ruang Rapat</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-car-front fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary">Mobil Dinas</h4>
                        <small class="text-muted">Armada Siap Jalan</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-tools fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary">Perbaikan</h4>
                        <small class="text-muted">Tanggap & Terjadwal</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3 stat-card text-center text-lg-start">
                <div class="d-flex flex-column flex-lg-row align-items-center gap-3">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-primary">Publik 24/7</h4>
                        <small class="text-muted">Lost&Found & Tamu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- 3. KATALOG 6 LAYANAN UTAMA BIRO SARPRAS -->
<!-- ============================================== -->
<section class="py-5" id="layanan-utama">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                KATALOG LAYANAN DIGITAL
            </span>
            <h2 class="fw-bold display-6 mb-2 text-dark">
                Pilih Layanan Sarpras Sesuai Kebutuhan Anda
            </h2>
            <p class="text-muted fs-6">
                Kemudahan akses terintegrasi untuk seluruh civitas akademika (Mahasiswa & Dosen) serta masyarakat umum kampus Universitas Pignatelli Triputra.
            </p>
        </div>

        <div class="row g-4">
            <!-- LAYANAN 1: PINJAM RUANGAN -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm service-card border">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-door-open-fill fs-3"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-semibold">
                                <i class="bi bi-person-badge me-1"></i> Mahasiswa & Dosen
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Peminjaman Ruangan</h4>
                        <p class="text-muted small mb-4 flex-grow-1">
                            Reservasi ruang rapat dan aula representatif (Excellent, Compassion, Integrity, Auditorium, MFH) untuk perkuliahan, rapat fakultas, seminar, dan kegiatan himpunan mahasiswa.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Auditorium</span>
                            <span class="badge bg-light text-secondary border">Meeting Room</span>
                            <span class="badge bg-light text-secondary border">AC & Sound</span>
                        </div>
                        <a href="/peminjaman/ruangan" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>Pinjam Ruangan</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 2: PINJAM KENDARAAN -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm service-card border">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-car-front-fill fs-3"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-semibold">
                                <i class="bi bi-person-badge me-1"></i> Mahasiswa & Dosen
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Peminjaman Kendaraan</h4>
                        <p class="text-muted small mb-4 flex-grow-1">
                            Booking armada mobil dinas kampus (Toyota Avanza, Toyota Innova, Isuzu Elf) untuk perjalanan dinas resmi, kompetisi mahasiswa, dan penugasan akademik universitas.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Avanza & Innova</span>
                            <span class="badge bg-light text-secondary border">Isuzu Elf</span>
                            <span class="badge bg-light text-secondary border">Tersedia Supir</span>
                        </div>
                        <a href="/peminjaman/kendaraan" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>Pinjam Kendaraan</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 3: REQUEST MAINTENANCE -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm service-card border">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-tools fs-3"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-semibold">
                                <i class="bi bi-person-badge me-1"></i> Mahasiswa & Dosen
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Request Maintenance</h4>
                        <p class="text-muted small mb-4 flex-grow-1">
                            Layanan perbaikan fasilitas kampus seperti AC ruangan, instalasi kelistrikan & lampu, sanitasi air, proyektor kelas, dan sambungan jaringan IT agar aktivitas akademik tetap nyaman.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">AC & Listrik</span>
                            <span class="badge bg-light text-secondary border">Jaringan IT</span>
                            <span class="badge bg-light text-secondary border">Cepat Tanggap</span>
                        </div>
                        <a href="/request/maintenance" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>Request Maintenance</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 4: REQUEST SUPPLIES (ATK) -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm service-card border">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-box-seam-fill fs-3"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-semibold">
                                <i class="bi bi-person-badge me-1"></i> Mahasiswa & Dosen
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Request Supplies (ATK)</h4>
                        <p class="text-muted small mb-4 flex-grow-1">
                            Pengajuan permohonan alat tulis kantor dan perlengkapan administrasi akademik (kertas, pulpen, map, ordner, tinta printer) dengan input multi-item yang praktis.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Multi-Item</span>
                            <span class="badge bg-light text-secondary border">Kertas & Tinta</span>
                            <span class="badge bg-light text-secondary border">Stok Realtime</span>
                        </div>
                        <a href="/request/supplies" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>Request ATK</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 5: LOST & FOUND -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm service-card border" style="border-top: 4px solid var(--accent-blue) !important;">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-info bg-opacity-10 text-primary">
                                <i class="bi bi-search-heart-fill fs-3 text-primary"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small fw-bold">
                                <i class="bi bi-globe me-1"></i> Umum & Tamu
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Lost & Found</h4>
                        <p class="text-muted small mb-4 flex-grow-1">
                            Pusat informasi barang hilang dan ditemukan di seluruh area kampus Universitas Pignatelli Triputra. Terbuka untuk umum tanpa perlu login akun.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Tanpa Login</span>
                            <span class="badge bg-light text-secondary border">Lapor Hilang</span>
                            <span class="badge bg-light text-secondary border">Barang Ditemukan</span>
                        </div>
                        <a href="/pelaporan/lost-found" class="btn btn-outline-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>Form Lost & Found</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LAYANAN 6: VISITOR ID PASS -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm service-card border" style="border-top: 4px solid var(--accent-blue) !important;">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="service-badge-icon bg-info bg-opacity-10 text-primary">
                                <i class="bi bi-person-vcard-fill fs-3 text-primary"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small fw-bold">
                                <i class="bi bi-globe me-1"></i> Umum & Tamu
                            </span>
                        </div>
                        <h4 class="card-title fw-bold mb-2">Visitor ID Pass</h4>
                        <p class="text-muted small mb-4 flex-grow-1">
                            Registrasi buku tamu digital kampus untuk pengunjung, tamu dinas, mitra kerjasama, maupun orang tua mahasiswa demi keamanan dan ketertiban kampus.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="badge bg-light text-secondary border">Buku Tamu Digital</span>
                            <span class="badge bg-light text-secondary border">Check-in Cepat</span>
                            <span class="badge bg-light text-secondary border">Aman & Tertib</span>
                        </div>
                        <a href="/pelaporan/visitor" class="btn btn-outline-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <span>Daftar Visitor Pass</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================== -->
<!-- 3.5. KALENDER JADWAL FASILITAS KAMPUS (ANTI DOUBLE BOOKING) -->
<!-- ============================================== -->
<section class="py-5" id="jadwal-kalender" style="background-color: var(--light-bg);">
    <div class="container py-3">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-4 gap-3">
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                    <i class="bi bi-calendar-week-fill me-1"></i> JADWAL FASILITAS REAL-TIME
                </span>
                <h2 class="fw-bold display-6 mb-2 text-dark">
                    Kalender Ruangan & Kendaraan Dinas
                </h2>
                <p class="text-muted fs-6 mb-0">
                    Jadwal pemakaian sarana dan prasarana kampus terpadu. Sistem otomatis memproteksi bentrok jadwal (Anti Double Booking) berdasarkan tanggal dan rentang jam.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="/peminjaman/ruangan" class="btn btn-outline-success rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-door-open-fill"></i>
                    <span>Pinjam Ruangan</span>
                </a>
                <a href="/peminjaman/kendaraan" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Pinjam Kendaraan</span>
                </a>
            </div>
        </div>

        <!-- Filter & Legenda Warna -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 p-3 bg-white">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-6 col-lg-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-bold text-dark text-nowrap"><i class="bi bi-funnel-fill text-primary"></i> Filter Kategori:</span>
                        <div class="btn-group w-100" role="group" id="calendarFilterButtons">
                            <button type="button" class="btn btn-sm btn-primary active fw-semibold" data-filter="all">Semua Jadwal</button>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" data-filter="room">🏢 Ruangan</button>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" data-filter="vehicle">🚗 Kendaraan</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-7">
                    <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-3 small">
                        <span class="text-muted fw-semibold">Legenda:</span>
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <span class="rounded-circle d-inline-block" style="width: 11px; height: 11px; background-color: #059669;"></span>
                            <span class="text-secondary fw-medium">Ruangan (Approved)</span>
                        </span>
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <span class="rounded-circle d-inline-block" style="width: 11px; height: 11px; background-color: #0284c7;"></span>
                            <span class="text-secondary fw-medium">Kendaraan (Approved)</span>
                        </span>
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <span class="rounded-circle d-inline-block" style="width: 11px; height: 11px; background-color: #ea580c;"></span>
                            <span class="text-secondary fw-medium">Menunggu Verifikasi (Pending)</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wadah FullCalendar -->
        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
            <div id="facilityCalendar" style="min-height: 600px;"></div>
        </div>
    </div>
</section>

<!-- Modal Detail Event Kalender -->
<div class="modal fade" id="modalCalendarEventDetail" tabindex="-1" aria-labelledby="modalCalendarEventDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-bottom py-3 px-4 bg-light">
                <div class="d-flex align-items-center gap-2">
                    <span id="calModalBadge" class="badge rounded-pill px-3 py-1.5 fw-semibold"></span>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="modalCalendarEventDetailLabel">Rincian Jadwal Peminjaman</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-dark">
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Kegiatan / Acara / Keperluan</small>
                    <h5 class="fw-bold text-primary mb-0" id="calModalEventTitle">-</h5>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 bg-light border">
                            <small class="text-muted d-block fw-semibold mb-1"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Fasilitas / Armada:</small>
                            <span class="fw-bold text-dark d-block" id="calModalResourceName">-</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 bg-light border">
                            <small class="text-muted d-block fw-semibold mb-1"><i class="bi bi-clock-fill text-warning me-1"></i>Tanggal & Waktu:</small>
                            <span class="fw-bold text-dark d-block" id="calModalDateTime">-</span>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light border mb-3">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-semibold">Nama Peminjam:</small>
                            <span class="fw-medium text-dark" id="calModalBooker">-</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-semibold">Prodi / Unit Kerja:</small>
                            <span class="fw-medium text-dark" id="calModalDepartment">-</span>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light border mb-3" id="calModalExtraBox">
                    <small class="text-muted d-block fw-semibold mb-1" id="calModalExtraLabel">Keterangan:</small>
                    <span class="text-dark small" id="calModalExtraValue">-</span>
                </div>

                <div class="alert alert-info border-0 rounded-3 mb-0 d-none" id="calModalAdminNoteBox">
                    <div class="d-flex gap-2">
                        <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                        <div>
                            <strong class="d-block text-dark small">Catatan Verifikasi Admin:</strong>
                            <span class="small text-dark" id="calModalAdminNote">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light px-4 py-3 justify-content-between">
                <span class="small text-muted" id="calModalStatusText">Status: -</span>
                <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- 4. ALUR PROSES PENGAJUAN (STEP BY STEP) -->
<!-- ============================================== -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                PANDUAN PENGGUNAAN
            </span>
            <h2 class="fw-bold display-6 mb-2 text-dark">
                Alur Pengajuan Layanan Sarpras
            </h2>
            <p class="text-muted fs-6">
                Proses mudah hanya dalam 4 tahapan ringkas untuk menikmati seluruh fasilitas kampus.
            </p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-sm-6 col-lg-3">
                <div class="p-3">
                    <div class="step-circle bg-primary text-white mx-auto mb-3 shadow">
                        1
                    </div>
                    <h5 class="fw-bold mb-2">Pilih Layanan</h5>
                    <p class="text-muted small mb-0">
                        Pilih menu peminjaman, perbaikan fasilitas, atau pelaporan yang Anda butuhkan.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3">
                    <div class="step-circle bg-primary text-white mx-auto mb-3 shadow">
                        2
                    </div>
                    <h5 class="fw-bold mb-2">Isi Formulir</h5>
                    <p class="text-muted small mb-0">
                        Lengkapi rincian tanggal, ruangan/barang, keperluan acara, dan kontak pemohon.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3">
                    <div class="step-circle bg-primary text-white mx-auto mb-3 shadow">
                        3
                    </div>
                    <h5 class="fw-bold mb-2">Verifikasi Tim</h5>
                    <p class="text-muted small mb-0">
                        Biro Sarpras akan memeriksa jadwal dan ketersediaan sarana secara real-time.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3">
                    <div class="step-circle bg-success text-white mx-auto mb-3 shadow">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Fasilitas Siap</h5>
                    <p class="text-muted small mb-0">
                        Pengajuan disetujui dan sarana prasarana siap digunakan sesuai jadwal kegiatan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================== -->
<!-- 5. KOTAK INFORMASI AKSES CIVITAS & UMUM -->
<!-- ============================================== -->
<section class="py-5">
    <div class="container py-2">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4 h-100" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%); color: white;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle text-white d-inline-flex align-items-center justify-content-center" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35); width: 60px; height: 60px;">
                            <i class="bi bi-shield-lock fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Akses Akun Civitas Akademika</h4>
                            <small class="text-white-50">Mahasiswa & Dosen UPT</small>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-4">
                        Untuk menjaga ketertiban penggunaan aset kampus, formulir Peminjaman Ruangan, Peminjaman Mobil Dinas, Request Maintenance, dan Pengambilan ATK hanya dapat diakses melalui akun kampus.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mt-auto">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <a href="/dashboard" class="btn btn-light text-primary fw-bold rounded-pill px-4">
                                Buka Dashboard Saya &rarr;
                            </a>
                        <?php else: ?>
                            <a href="/login" class="btn btn-light text-primary fw-bold rounded-pill px-4">
                                Masuk Akun Civitas &rarr;
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4 h-100 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 bg-primary bg-opacity-10 rounded-circle text-primary">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-primary">Akses Terbuka untuk Publik</h4>
                            <small class="text-muted">Tamu Kampus & Masyarakat Umum</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-4">
                        Bagi tamu dari instansi luar, orang tua, kurir, dan seluruh pengunjung umum kampus, layanan <strong>Pelaporan Barang Hilang (Lost & Found)</strong> serta <strong>Buku Tamu (Visitor ID Pass)</strong> dapat diisi secara langsung tanpa registrasi akun.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mt-auto">
                        <a href="/pelaporan/visitor" class="btn btn-outline-primary rounded-pill px-3">
                            Isi Buku Tamu (Visitor Pass)
                        </a>
                        <a href="/pelaporan/lost-found" class="btn btn-outline-secondary rounded-pill px-3">
                            Cek Lost & Found
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================== -->
<!-- CSS KHUSUS HALAMAN DEPAN (HOME PAGE) -->
<!-- ============================================== -->
<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #072B4D 0%, #0A3A66 45%, #0D62AC 100%);
    border-bottom-left-radius: 40px;
    border-bottom-right-radius: 40px;
    box-shadow: 0 15px 35px rgba(10, 58, 102, 0.18);
    position: relative;
}
.hero-bg-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle at 85% 20%, rgba(255, 255, 255, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 10% 80%, rgba(42, 133, 208, 0.2) 0%, transparent 60%);
    pointer-events: none;
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

/* Service Cards */
.service-card {
    border-radius: 20px;
    border: 1px solid var(--card-border) !important;
    transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease, border-color 0.3s ease;
}
.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(10, 58, 102, 0.1) !important;
    border-color: rgba(13, 98, 172, 0.3) !important;
}
.service-badge-icon {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Stats Overlap */
.stats-overlap {
    margin-top: -35px;
    z-index: 10;
}
.stat-card {
    transition: transform 0.25s ease;
}
.stat-card:hover {
    transform: translateY(-4px);
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

/* Small Quick Service Circle in Hero */
.service-icon-circle {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* FullCalendar Custom Theme Styles */
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
                extraLabel.innerHTML = '<i class="bi bi-gear-fill text-secondary me-1"></i>Setup & Perlengkapan:';
                let extraTxt = [];
                if (props.setup) extraTxt.push('Setup Ruangan: ' + props.setup);
                if (props.materials) extraTxt.push('Perlengkapan: ' + props.materials);
                if (props.special) extraTxt.push('Permintaan Khusus: ' + props.special);
                extraValue.textContent = extraTxt.length > 0 ? extraTxt.join(' | ') : 'Tidak ada catatan tambahan.';
            } else {
                extraLabel.innerHTML = '<i class="bi bi-info-circle-fill text-secondary me-1"></i>Supir & Keterangan Dinas:';
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


