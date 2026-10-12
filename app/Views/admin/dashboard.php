<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
$role = session()->get('role') ?? 'user';
$userName = session()->get('user_name') ?? 'Pengguna';
$userDept = session()->get('department') ?? 'Universitas Pignatelli Triputra';
$userEmail = session()->get('email') ?? '-';
$userLoginName = session()->get('username') ?? 'user';

if ($role === 'super_admin') {
    $roleName = 'Super Admin (Biro IT)';
    $roleBadgeClass = 'bg-danger';
} elseif ($role === 'admin') {
    $roleName = 'Admin (Sarpras)';
    $roleBadgeClass = 'bg-primary';
} else {
    $roleName = 'User (Mahasiswa / Dosen)';
    $roleBadgeClass = 'bg-success';
}
?>

<!-- Kartu Selamat Datang & Profil Akun yang Login -->
<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white;">
    <div class="card-body p-4 p-md-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                            <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">Selamat Datang, <?= esc($userName) ?>!</h3>
                        <p class="mb-0 text-white-50">Sistem Informasi Biro Sarana dan Prasarana - Universitas Pignatelli Triputra</p>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
                    <span class="badge <?= $roleBadgeClass ?> px-3 py-2 rounded-pill fs-6 shadow-sm">
                        Level: <?= esc($roleName) ?>
                    </span>
                    <span class="badge bg-white bg-opacity-20 px-3 py-2 rounded-pill fs-6 text-white">
                        <i class="bi bi-building me-1"></i> Unit: <?= esc($userDept) ?>
                    </span>
                    <span class="badge bg-white bg-opacity-20 px-3 py-2 rounded-pill fs-6 text-white">
                        <i class="bi bi-person me-1"></i> Username: <?= esc($userLoginName) ?>
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="/" class="btn btn-light fw-bold px-3 py-2 rounded-pill shadow-sm text-primary me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe me-1" viewBox="0 0 16 16">
                        <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 5a14 14 0 0 0-.411 2h2.82V5zm0 3H3.679q.13.995.411 2h2.41V8zm.517 3H6.5v1.923c-.67-.204-1.335-.82-1.887-1.855A8 8 0 0 1 4.607 11M7.5 13.923V12h2.393a8 8 0 0 1-.506 1.923M8.5 11h2.41a14 14 0 0 0 .411-2H8.5zm0-3h2.82a14 14 0 0 0-.411-2H8.5zm0-4h2.355a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.281 8.5 1.077M11.855 4H9.645a8 8 0 0 1 .506-1.923A8 8 0 0 1 11.855 4"/>
                    </svg>
                    Lihat Web Depan
                </a>
                <a href="/logout" class="btn btn-outline-light px-3 py-2 rounded-pill">
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Alert Notifikasi Flashdata -->
<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div><?= session()->getFlashdata('message') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ============================================== -->
<!-- LAYOUT UTAMA: SIDEBAR + CONTENT AREA -->
<!-- ============================================== -->
<div class="row g-4">
    <!-- 1. SIDEBAR NAVIGASI DASHBOARD -->
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px; z-index: 10;">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold text-uppercase text-muted mb-0 small" style="letter-spacing: 0.5px;">Menu Navigasi</h6>
            </div>
            <div class="card-body p-2">
                <div class="nav flex-column nav-pills custom-nav-pills" id="dashboardTab" role="tablist">
                    <button class="nav-link active text-start py-3 px-3 rounded-3 mb-1" id="tab-overview-btn" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-speedometer2 me-2" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.287l-4.796 1.88a.78.78 0 0 0-.41.341l-1.97 3.284a.78.78 0 0 0 .045.866l3.182 3.181a.78.78 0 0 0 .867.045l3.284-1.97a.78.78 0 0 0 .34-.41z"/>
                            <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                            <path d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25-1.026-.332-2.18-.73-3.615-.73s-2.589.398-3.615.73c-1.087.352-2.49-.003-2.932-1.25A8 8 0 0 1 0 10"/>
                        </svg>
                        Ringkasan Overview
                    </button>

                    <?php if (in_array($role, ['super_admin', 'admin'])): ?>
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-supplies-btn" data-bs-toggle="pill" data-bs-target="#tab-supplies" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-seam me-2" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                        </svg>
                        Manajemen Supplies (ATK)
                    </button>

                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-verifikasi-btn" data-bs-toggle="pill" data-bs-target="#tab-verifikasi" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check2-square me-2" viewBox="0 0 16 16">
                            <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                            <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"/>
                        </svg>
                        Verifikasi Permohonan
                    </button>
                    <?php endif; ?>

                    <?php if ($role === 'user'): ?>
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-myrequests-btn" data-bs-toggle="pill" data-bs-target="#tab-myrequests" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-clock-history me-2" viewBox="0 0 16 16">
                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .79.522l-.492.871zM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-1 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0m-6.5-4a.5.5 0 0 0-1 0v4.5a.5.5 0 0 0 .246.43l3 1.5a.5.5 0 1 0 .492-.868L8.5 8.243z"/>
                        </svg>
                        Pengajuan Saya
                    </button>
                    <?php endif; ?>

                    <?php if (in_array($role, ['super_admin', 'admin'])): ?>
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-users-btn" data-bs-toggle="pill" data-bs-target="#tab-users" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-gear me-2" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                        </svg>
                        Setting Manajemen Users
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. KONTEN AREA (TAB CONTENT) -->
    <div class="col-lg-9">
        <div class="tab-content" id="dashboardTabContent">

            <!-- TAB A: OVERVIEW & RINGKASAN -->
            <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                <!-- Statistik Card -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm border-start border-4 border-success">
                            <div class="card-body">
                                <div class="text-muted small fw-semibold text-uppercase">Ruangan</div>
                                <h3 class="fw-bold my-1 text-success"><?= esc($stats['room_bookings'] ?? 0) ?></h3>
                                <small class="text-muted">Booking Ruangan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm border-start border-4 border-primary">
                            <div class="card-body">
                                <div class="text-muted small fw-semibold text-uppercase">Kendaraan</div>
                                <h3 class="fw-bold my-1 text-primary"><?= esc($stats['vehicle_bookings'] ?? 0) ?></h3>
                                <small class="text-muted">Booking Mobil Dinas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm border-start border-4 border-warning">
                            <div class="card-body">
                                <div class="text-muted small fw-semibold text-uppercase">Maintenance</div>
                                <h3 class="fw-bold my-1 text-warning"><?= esc($stats['maintenance'] ?? 0) ?></h3>
                                <small class="text-muted">Perbaikan Fasilitas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm border-start border-4 border-danger">
                            <div class="card-body">
                                <div class="text-muted small fw-semibold text-uppercase">Supplies (ATK)</div>
                                <h3 class="fw-bold my-1 text-danger"><?= esc($stats['supplies'] ?? 0) ?></h3>
                                <small class="text-muted">Permintaan Barang</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Akses Cepat Formulir Depan -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0 text-primary">Akses Cepat Pengajuan & Formulir</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <a href="/peminjaman/ruangan" class="btn btn-outline-success w-100 text-start py-2">
                                    <i class="bi bi-door-open me-2"></i> Peminjaman Ruangan
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/peminjaman/kendaraan" class="btn btn-outline-primary w-100 text-start py-2">
                                    <i class="bi bi-car-front me-2"></i> Peminjaman Kendaraan
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/request/maintenance" class="btn btn-outline-warning w-100 text-start py-2">
                                    <i class="bi bi-tools me-2"></i> Request Maintenance
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/request/supplies" class="btn btn-outline-danger w-100 text-start py-2">
                                    <i class="bi bi-box-seam me-2"></i> Request Supplies (ATK)
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/pelaporan/lost-found" class="btn btn-outline-info w-100 text-start py-2">
                                    <i class="bi bi-search me-2"></i> Form Lost & Found
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/pelaporan/visitor" class="btn btn-outline-secondary w-100 text-start py-2">
                                    <i class="bi bi-person-badge me-2"></i> Visitor ID Pass
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB B: CRUD SUPPLIES (Nama Barang, Jumlah, Satuan, Stock, Batas) -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-supplies" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-primary">
                                <i class="bi bi-box-seam me-2"></i>Manajemen Persediaan Barang (Supplies)
                            </h5>
                            <small class="text-muted">Kelola data Nama Barang, Jumlah, Satuan, Stock, dan Batas Minimum Stok.</small>
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddSupply">
                            + Tambah Barang Baru
                        </button>
                    </div>

                    <div class="card-body pt-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Stock Saat Ini</th>
                                    <th>Batas Min.</th>
                                    <th>Status Stok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($suppliesList)): ?>
                                    <?php $no = 1; foreach ($suppliesList as $sup): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= esc($sup['item_name']) ?></strong></td>
                                            <td><?= esc($sup['quantity'] ?? 0) ?></td>
                                            <td><span class="badge bg-light text-dark border"><?= esc($sup['unit']) ?></span></td>
                                            <td>
                                                <strong class="fs-6"><?= esc($sup['stock']) ?></strong>
                                            </td>
                                            <td><?= esc($sup['min_stock'] ?? 0) ?></td>
                                            <td>
                                                <?php if ((int)$sup['stock'] <= (int)($sup['min_stock'] ?? 0)): ?>
                                                    <span class="badge bg-danger">Stok Menipis / Kritis</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Stok Aman</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditSupply<?= $sup['id'] ?>" title="Edit">
                                                        Edit
                                                    </button>
                                                    <form method="post" action="/dashboard/supplies/delete" class="d-inline ms-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang <?= esc($sup['item_name']) ?>?');">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= $sup['id'] ?>">
                                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- MODAL EDIT SUPPLY -->
                                        <div class="modal fade" id="modalEditSupply<?= $sup['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold">Edit Barang Supplies</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="post" action="/dashboard/supplies/update">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= $sup['id'] ?>">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Barang</label>
                                                                <input type="text" name="item_name" class="form-control" value="<?= esc($sup['item_name']) ?>" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Jumlah</label>
                                                                    <input type="number" name="quantity" class="form-control" value="<?= esc($sup['quantity'] ?? 0) ?>" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Satuan</label>
                                                                    <input type="text" name="unit" class="form-control" value="<?= esc($sup['unit']) ?>" placeholder="Pcs, Rim, Box" required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Stock</label>
                                                                    <input type="number" name="stock" class="form-control" value="<?= esc($sup['stock']) ?>" required>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Batas (Min. Stock)</label>
                                                                    <input type="number" name="min_stock" class="form-control" value="<?= esc($sup['min_stock'] ?? 0) ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data barang persediaan (Supplies).</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- TAB C: VERIFIKASI WORKFLOW PERMOHONAN -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-verifikasi" role="tabpanel">
                <!-- Ruangan -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-success"><i class="bi bi-door-open me-2"></i>Peminjaman Ruangan</h5>
                        <a href="/peminjaman/ruangan" class="btn btn-sm btn-outline-success rounded-pill">+ Form Peminjaman</a>
                    </div>
                    <div class="card-body pt-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Ruangan</th>
                                    <th>Acara</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pendingRooms)): ?>
                                    <?php foreach ($pendingRooms as $r): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($r['booker_name']) ?></strong><br>
                                                <small class="text-muted"><?= esc($r['department']) ?></small>
                                            </td>
                                            <td><?= esc($r['room_name'] ?? 'Ruang #' . $r['room_id']) ?></td>
                                            <td><?= esc($r['event_name']) ?></td>
                                            <td>
                                                <?= esc($r['booking_date']) ?><br>
                                                <small class="text-muted"><?= esc($r['start_time']) ?> - <?= esc($r['end_time']) ?></small>
                                            </td>
                                            <td>
                                                <?php if ($r['status'] === 'approved'): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php elseif ($r['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <form method="post" action="/dashboard/update-status" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="table" value="room_bookings">
                                                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-outline-success">Setujui</button>
                                                    </form>
                                                    <form method="post" action="/dashboard/update-status" class="d-inline ms-1">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="table" value="room_bookings">
                                                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn btn-outline-danger">Tolak</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada pengajuan ruangan.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Kendaraan -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-car-front me-2"></i>Peminjaman Kendaraan</h5>
                        <a href="/peminjaman/kendaraan" class="btn btn-sm btn-outline-primary rounded-pill">+ Form Kendaraan</a>
                    </div>
                    <div class="card-body pt-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Kendaraan</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Driver</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pendingVehicles)): ?>
                                    <?php foreach ($pendingVehicles as $v): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($v['booker_name']) ?></strong><br>
                                                <small class="text-muted"><?= esc($v['department']) ?></small>
                                            </td>
                                            <td><?= esc($v['vehicle_name'] ?? 'Kendaraan') ?> (<?= esc($v['plate_number'] ?? '-') ?>)</td>
                                            <td><?= esc($v['destination']) ?></td>
                                            <td>
                                                <?= esc($v['booking_date']) ?><br>
                                                <small class="text-muted"><?= esc($v['start_time']) ?> - <?= esc($v['end_time']) ?></small>
                                            </td>
                                            <td><?= esc($v['driver_name']) ?></td>
                                            <td>
                                                <?php if ($v['status'] === 'approved'): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php elseif ($v['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <form method="post" action="/dashboard/update-status" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="table" value="vehicle_bookings">
                                                        <input type="hidden" name="id" value="<?= $v['id'] ?>">
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-outline-success">Setujui</button>
                                                    </form>
                                                    <form method="post" action="/dashboard/update-status" class="d-inline ms-1">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="table" value="vehicle_bookings">
                                                        <input type="hidden" name="id" value="<?= $v['id'] ?>">
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn btn-outline-danger">Tolak</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada pengajuan kendaraan.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- TAB D: SETTING MANAJEMEN USERS PADA SIDEBAR -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-users" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill me-2" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                </svg>
                                Pengaturan & Manajemen Pengguna (Users)
                            </h5>
                            <small class="text-muted">Kelola akun dan level hak akses untuk Admin Sarpras, User (Mahasiswa/Dosen), dan Super Admin Biro IT.</small>
                        </div>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                            + Tambah Pengguna Baru
                        </button>
                    </div>

                    <div class="card-body pt-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Level Akses</th>
                                    <th>Department</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($allUsers)): ?>
                                    <?php foreach ($allUsers as $u): ?>
                                        <tr>
                                            <td>#<?= esc($u['id']) ?></td>
                                            <td><strong><?= esc($u['username']) ?></strong></td>
                                            <td><?= esc($u['name']) ?></td>
                                            <td><?= esc($u['email'] ?? '-') ?></td>
                                            <td>
                                                <?php if ($u['role'] === 'super_admin'): ?>
                                                    <span class="badge bg-danger">Super Admin (Biro IT)</span>
                                                <?php elseif ($u['role'] === 'admin'): ?>
                                                    <span class="badge bg-primary">Admin (Sarpras)</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">User (Mhs & Dosen)</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($u['department'] ?? '-') ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditUser<?= $u['id'] ?>" title="Edit">
                                                        Edit
                                                    </button>
                                                    <?php if ((int)$u['id'] !== (int)session()->get('user_id')): ?>
                                                        <form method="post" action="/dashboard/users/delete" class="d-inline ms-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user <?= esc($u['name']) ?>?');">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">Hapus</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- MODAL EDIT USER -->
                                        <div class="modal fade" id="modalEditUser<?= $u['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold">Edit Akun Pengguna</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="post" action="/dashboard/users/update">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Username</label>
                                                                <input type="text" name="username" class="form-control" value="<?= esc($u['username']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                                                <input type="text" name="name" class="form-control" value="<?= esc($u['name']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Email</label>
                                                                <input type="email" name="email" class="form-control" value="<?= esc($u['email'] ?? '') ?>">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Role / Hak Akses</label>
                                                                    <select name="role" class="form-select" required>
                                                                        <option value="user" <?= ($u['role'] === 'user') ? 'selected' : '' ?>>User (Mahasiswa / Dosen)</option>
                                                                        <option value="admin" <?= ($u['role'] === 'admin') ? 'selected' : '' ?>>Admin (Sarpras)</option>
                                                                        <option value="super_admin" <?= ($u['role'] === 'super_admin') ? 'selected' : '' ?>>Super Admin (Biro IT)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Department / Unit</label>
                                                                    <input type="text" name="department" class="form-control" value="<?= esc($u['department'] ?? '') ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Password Baru (Opsional)</label>
                                                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Simpan Pengguna</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data user.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- TAB E: PENGAJUAN SAYA (KHUSUS MAHASISWA & DOSEN) -->
            <?php if ($role === 'user'): ?>
            <div class="tab-pane fade" id="tab-myrequests" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Status & Riwayat Pengajuan Saya</h5>
                    </div>
                    <div class="card-body pt-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Layanan</th>
                                    <th>Keterangan / Detail</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($myRequests)): ?>
                                    <?php foreach ($myRequests as $req): ?>
                                        <tr>
                                            <td><span class="badge bg-secondary"><?= esc($req['type']) ?></span></td>
                                            <td>
                                                <strong><?= esc($req['title']) ?></strong><br>
                                                <small class="text-muted"><?= esc($req['detail'] ?? '-') ?></small>
                                            </td>
                                            <td><?= esc($req['date'] ?? '-') ?></td>
                                            <td>
                                                <?php if ($req['status'] === 'approved' || $req['status'] === 'resolved'): ?>
                                                    <span class="badge bg-success">Disetujui / Selesai</span>
                                                <?php elseif ($req['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger">Ditolak</span>
                                                <?php elseif ($req['status'] === 'in_progress'): ?>
                                                    <span class="badge bg-info text-dark">Dalam Pengerjaan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat permohonan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH BARANG (SUPPLIES) -->
<!-- ============================================== -->
<div class="modal fade" id="modalAddSupply" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Tambah Barang Supplies (ATK)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/supplies/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" name="item_name" class="form-control" placeholder="Contoh: Kertas A4 80gr, Pulpen Pilot" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Jumlah</label>
                            <input type="number" name="quantity" class="form-control" value="0" min="0" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Satuan</label>
                            <input type="text" name="unit" class="form-control" placeholder="Rim, Box, Pcs, Botol" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Stock Saat Ini</label>
                            <input type="number" name="stock" class="form-control" value="0" min="0" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Batas (Min. Stock)</label>
                            <input type="number" name="min_stock" class="form-control" value="5" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">+ Tambah Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH USER (SETTING USERS) -->
<!-- ============================================== -->
<div class="modal fade" id="modalAddUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/users/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="username_login" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap User" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@pignatelli.ac.id">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Role / Level Akses</label>
                            <select name="role" class="form-select" required>
                                <option value="user" selected>User (Mahasiswa / Dosen)</option>
                                <option value="admin">Admin (Sarpras)</option>
                                <option value="super_admin">Super Admin (Biro IT)</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Department / Unit</label>
                            <input type="text" name="department" class="form-control" placeholder="Contoh: IT, SDM, Dosen">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password akun" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">+ Tambah User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.custom-nav-pills .nav-link {
    color: #495057;
    font-weight: 600;
    transition: all 0.2s ease;
}
.custom-nav-pills .nav-link:hover {
    background-color: #f0f4f8;
    color: var(--primary-blue);
}
.custom-nav-pills .nav-link.active {
    background-color: var(--primary-blue) !important;
    color: white !important;
    box-shadow: 0 4px 10px rgba(10, 58, 102, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sinkronisasi tab dengan URL Hash (#supplies, #users, dll.)
    var hash = window.location.hash;
    if (hash) {
        if (hash === '#supplies') {
            var btn = document.getElementById('tab-supplies-btn');
            if (btn) btn.click();
        } else if (hash === '#users') {
            var btn = document.getElementById('tab-users-btn');
            if (btn) btn.click();
        } else if (hash === '#verifikasi') {
            var btn = document.getElementById('tab-verifikasi-btn');
            if (btn) btn.click();
        } else if (hash === '#myrequests') {
            var btn = document.getElementById('tab-myrequests-btn');
            if (btn) btn.click();
        }
    }
});
</script>

<?= $this->endSection() ?>
