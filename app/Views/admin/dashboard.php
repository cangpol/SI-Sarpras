<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Dashboard Sarpras</h2>
        <p class="text-muted mb-0">Selamat datang kembali, <strong><?= esc(session()->get('user_name') ?? 'Admin') ?></strong>!</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/" class="btn btn-outline-primary fw-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house me-1" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
            </svg>
            Halaman Utama
        </a>
        <a href="/logout" class="btn btn-outline-danger fw-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right me-1" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 10 1H2a1.5 1.5 0 0 0-1.5 1.5v9A1.5 1.5 0 0 0 2 15h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-1.647 1.646a.5.5 0 0 0 .708.708z"/>
            </svg>
            Logout
        </a>
    </div>
</div>

<!-- Statistik Ringkas -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Lost & Found</div>
                        <h3 class="fw-bold my-1 text-primary"><?= esc($stats['lost_found'] ?? 0) ?></h3>
                        <small class="text-muted">Laporan Barang Hilang</small>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Visitor ID Pass</div>
                        <h3 class="fw-bold my-1 text-info"><?= esc($stats['visitors'] ?? 0) ?></h3>
                        <small class="text-muted">Kunjungan Tamu</small>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                            <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Booking Ruangan</div>
                        <h3 class="fw-bold my-1 text-success"><?= esc($stats['room_bookings'] ?? 0) ?></h3>
                        <small class="text-muted">Pengajuan Ruang</small>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                            <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                            <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Booking Kendaraan</div>
                        <h3 class="fw-bold my-1 text-secondary"><?= esc($stats['vehicle_bookings'] ?? 0) ?></h3>
                        <small class="text-muted">Operasional Kampus</small>
                    </div>
                    <div class="bg-secondary bg-opacity-10 text-secondary p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                            <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                            <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.315.38.396.904.43 1.348 1.444 1.348 2.457v5.612A1.5 1.5 0 0 1 14.5 15h-1a1.5 1.5 0 0 1-1.5-1.5V13H4v.5A1.5 1.5 0 0 1 2.5 15h-1A1.5 1.5 0 0 1 0 13.515V7.9c0-1.013.444-2.027 1.348-2.457.17-.081.305-.221.38-.396zM4.82 3a1.5 1.5 0 0 0-1.38 1.09l-.792 1.849a1.8 1.8 0 0 0-.148.675v5.612c0 .276.224.5.5.5h1a.5.5 0 0 0 .5-.5V12h8v.226a.5.5 0 0 0 .5.5h1c.276 0 .5-.224.5-.5V6.614c0-.233-.052-.464-.148-.675l-.792-1.849A1.5 1.5 0 0 0 11.18 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Maintenance</div>
                        <h3 class="fw-bold my-1 text-warning"><?= esc($stats['maintenance'] ?? 0) ?></h3>
                        <small class="text-muted">Perbaikan Fasilitas</small>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                            <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.969-.969L12.206 5.857a3.003 3.003 0 0 0 .851-5.878A3 3 0 0 0 10.153 3.824L7.5 6.478l-2.675-2.675a1 1 0 0 1-.293-.707V3.025a1 1 0 0 0-.419-.815zm1.5 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Request Supplies</div>
                        <h3 class="fw-bold my-1 text-danger"><?= esc($stats['supplies'] ?? 0) ?></h3>
                        <small class="text-muted">Permintaan ATK</small>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Akses Cepat Formulir -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold mb-0" style="color: var(--primary-blue);">Navigasi Cepat Formulir</h5>
    </div>
    <div class="card-body pt-0">
        <div class="row g-2">
            <div class="col-md-4">
                <a href="/pelaporan/lost-found" class="btn btn-outline-primary w-100 text-start py-2">
                    <i class="bi bi-arrow-right-circle me-1"></i> Form Lost & Found
                </a>
            </div>
            <div class="col-md-4">
                <a href="/pelaporan/visitor" class="btn btn-outline-primary w-100 text-start py-2">
                    <i class="bi bi-arrow-right-circle me-1"></i> Visitor ID Pass
                </a>
            </div>
            <div class="col-md-4">
                <a href="/peminjaman/ruangan" class="btn btn-outline-success w-100 text-start py-2">
                    <i class="bi bi-arrow-right-circle me-1"></i> Peminjaman Ruangan
                </a>
            </div>
            <div class="col-md-4">
                <a href="/peminjaman/kendaraan" class="btn btn-outline-success w-100 text-start py-2">
                    <i class="bi bi-arrow-right-circle me-1"></i> Peminjaman Kendaraan
                </a>
            </div>
            <div class="col-md-4">
                <a href="/request/maintenance" class="btn btn-outline-warning w-100 text-start py-2">
                    <i class="bi bi-arrow-right-circle me-1"></i> Request Maintenance
                </a>
            </div>
            <div class="col-md-4">
                <a href="/request/supplies" class="btn btn-outline-danger w-100 text-start py-2">
                    <i class="bi bi-arrow-right-circle me-1"></i> Request Supplies
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
