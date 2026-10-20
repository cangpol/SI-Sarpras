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
    $uType = $userType ?? ((stripos($userDept, 'dosen') !== false || stripos($userLoginName, 'dosen') !== false) ? 'Dosen' : 'Mahasiswa');
    $roleName = 'User (' . $uType . ')';
    $roleBadgeClass = ($uType === 'Dosen') ? 'bg-info text-dark' : 'bg-success';
}

$departments = [
    'Finance', 'SDM', 'LPPM', 'LPM', 'Kerjasama', 'IT', 'Kemahasiswaan', 
    'BAA', 'Marketing', 'Rektorat', 'Sekretariat', 'FEB', 'FSH', 'FST', 
    'Yayasan & Ten', 'Sarpras', 'Mahasiswa', 'Security', 'CS'
];
?>

<style>
.custom-nav-pills .nav-link {
    color: #1e293b !important;
    font-weight: 600;
    transition: all 0.2s ease;
}
.custom-nav-pills .nav-link:hover {
    background-color: #f1f5f9 !important;
    color: var(--primary-blue) !important;
}
.custom-nav-pills .nav-link.active {
    background-color: var(--primary-blue) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 10px rgba(10, 58, 102, 0.25);
}

/* Anti-Blink & Anti-Jitter untuk Seluruh Modal Dashboard */
body.modal-open,
body.modal-open .card,
body.modal-open .card:hover,
body.modal-open .table-responsive,
body.modal-open .table-responsive-scroll {
    transform: none !important;
    transition: none !important;
}
.modal {
    transform: none !important;
}
.modal-dialog {
    will-change: transform;
}

/* Tabel Dashboard Responsif Mengikuti Tinggi Layar & Anti-Tenggelam (Super Admin, Admin, User) */
.table-responsive-scroll {
    max-height: calc(100vh - 290px);
    min-height: 280px;
    overflow-y: auto;
    overflow-x: auto;
    border-radius: 0.75rem;
    margin-bottom: 0.5rem;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: #94a3b8 #f1f5f9;
}
@media (max-height: 720px) {
    .table-responsive-scroll {
        max-height: calc(100vh - 210px);
        min-height: 220px;
    }
}
/* Custom WebKit Scrollbar (Chrome, Edge, Safari, Opera) */
.table-responsive-scroll::-webkit-scrollbar {
    height: 10px;
    width: 8px;
}
.table-responsive-scroll::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 6px;
}
.table-responsive-scroll::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 6px;
    border: 2px solid #f1f5f9;
}
.table-responsive-scroll::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}
.table-responsive-scroll table {
    min-width: 820px;
}
.table-responsive-scroll th {
    white-space: nowrap;
    font-size: 0.82rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding-top: 11px;
    padding-bottom: 11px;
    background-color: #f8fafc !important;
    color: #475569;
}
.table-responsive-scroll td {
    font-size: 0.865rem;
    vertical-align: middle;
}
.col-w-no { width: 55px; min-width: 50px; text-align: center; }
.col-w-type { width: 130px; min-width: 120px; }
.col-w-user { width: 180px; min-width: 160px; }
.col-w-item { width: 180px; min-width: 160px; }
.col-w-date { width: 145px; min-width: 130px; }
.col-w-time { width: 130px; min-width: 120px; }
.col-w-desc { min-width: 200px; max-width: 320px; word-break: break-word; }
.col-w-status { width: 160px; min-width: 145px; }
.col-w-action { width: 140px; min-width: 120px; text-align: center; }
.admin-note-bubble {
    font-size: 0.78rem;
    line-height: 1.35;
    border-radius: 6px;
    padding: 5px 8px;
    margin-top: 5px;
    word-break: break-word;
}
</style>

<!-- Kartu Selamat Datang & Profil Akun yang Login -->
<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-person-badge text-white" viewBox="0 0 16 16">
                    <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
                </svg>
            </div>
            <div>
                <h3 class="fw-bold mb-0">Selamat Datang, <?= esc($userName) ?>!</h3>
                <p class="mb-0 text-white-50">Sistem Informasi Biro Sarana dan Prasarana - Universitas Pignatelli Triputra</p>
            </div>
        </div>
    </div>
</div>

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
                    <?php if (in_array($role, ['super_admin', 'admin'])): ?>
                    <button class="nav-link active text-start py-3 px-3 rounded-3 mb-1" id="tab-overview-btn" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-speedometer2 me-2" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.287l-4.796 1.88a.78.78 0 0 0-.41.341l-1.97 3.284a.78.78 0 0 0 .045.866l3.182 3.181a.78.78 0 0 0 .867.045l3.284-1.97a.78.78 0 0 0 .34-.41z"/>
                            <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                            <path d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25-1.026-.332-2.18-.73-3.615-.73s-2.589.398-3.615.73c-1.087.352-2.49-.003-2.932-1.25A8 8 0 0 1 0 10"/>
                        </svg>
                        Ringkasan Overview
                    </button>
                    <?php endif; ?>

                    <?php if (in_array($role, ['super_admin', 'admin'])): ?>
                    <!-- MENU CRUD PELAPORAN -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-pelaporan-btn" data-bs-toggle="pill" data-bs-target="#tab-pelaporan" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-clipboard-data me-2" viewBox="0 0 16 16">
                            <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0z"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                        </svg>
                        CRUD Pelaporan
                    </button>

                    <!-- MENU CRUD PEMINJAMAN -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-peminjaman-btn" data-bs-toggle="pill" data-bs-target="#tab-peminjaman" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-calendar2-range me-2" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 3.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5H2.545C2.245 3 2 3.224 2 3.5m1 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                        </svg>
                        CRUD Peminjaman
                    </button>

                    <!-- MENU CRUD REQUEST -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-request-btn" data-bs-toggle="pill" data-bs-target="#tab-request" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-tools me-2" viewBox="0 0 16 16">
                            <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.969-.969 2.676-2.675a1 1 0 0 1 .707-.293h.07a1 1 0 0 0 .815-.419L16 1 15 0 11.919 2.2a1 1 0 0 0-.419.815v.07a1 1 0 0 1-.293.708L8.532 6.468 6.468 4.404l2.675-2.676a1 1 0 0 1 .708-.293h.07a1 1 0 0 0 .815-.419z"/>
                        </svg>
                        CRUD Request
                    </button>

                    <!-- MENU CRUD SUPPLIES -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-supplies-btn" data-bs-toggle="pill" data-bs-target="#tab-supplies" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-seam me-2" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                        </svg>
                        Stok Supplies (ATK)
                    </button>

                    <!-- MENU VERIFIKASI -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1 d-flex justify-content-between align-items-center" id="tab-verifikasi-btn" data-bs-toggle="pill" data-bs-target="#tab-verifikasi" type="button" role="tab">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check2-square me-2" viewBox="0 0 16 16">
                                <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"/>
                                <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"/>
                            </svg>
                            Verifikasi Status
                        </div>
                        <?php if (!empty($totalPendingCount) && $totalPendingCount > 0): ?>
                            <span class="badge bg-danger rounded-pill px-2 py-1"><?= $totalPendingCount ?></span>
                        <?php endif; ?>
                    </button>

                    <!-- MENU USERS -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-users-btn" data-bs-toggle="pill" data-bs-target="#tab-users" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-gear me-2" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                        </svg>
                        Setting Manajemen Users
                    </button>

                    <!-- MENU MASTER SARPRAS -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-master-sarpras-btn" data-bs-toggle="pill" data-bs-target="#tab-master-sarpras" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-collection me-2" viewBox="0 0 16 16">
                            <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z"/>
                        </svg>
                        Master Ruangan & Mobil
                    </button>

                    <!-- MENU BIODATA PROFIL (ADMIN / SUPER ADMIN) -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-biodata-btn" data-bs-toggle="pill" data-bs-target="#tab-biodata" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-badge me-2" viewBox="0 0 16 16">
                            <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
                            <path d="M8 11a4.978 4.978 0 0 0-3.5 1.454.5.5 0 0 0 .352.854h6.296a.5.5 0 0 0 .354-.854A4.978 4.978 0 0 0 8 11"/>
                        </svg>
                        Biodata Profil
                    </button>
                    <?php endif; ?>

                    <?php if ($role === 'user'): ?>
                    <?php
                    $pRooms = $pendingRoomsCount ?? count(array_filter($myRoomBookings ?? [], fn($r) => ($r['status'] ?? '') === 'pending'));
                    $pVehicles = $pendingVehiclesCount ?? count(array_filter($myVehicleBookings ?? [], fn($v) => ($v['status'] ?? '') === 'pending'));
                    $pMaintenance = $pendingMaintenanceCount ?? count(array_filter($myMaintenance ?? [], fn($m) => in_array($m['status'] ?? '', ['pending', 'in_progress'])));
                    $pSupplies = $pendingSuppliesCount ?? count(array_filter($mySupplyRequests ?? [], fn($s) => ($s['status'] ?? '') === 'pending'));
                    ?>
                    <button class="nav-link <?= ($role === 'user') ? 'active' : '' ?> text-start py-3 px-3 rounded-3 mb-1 d-flex justify-content-between align-items-center" id="tab-myrooms-btn" data-bs-toggle="pill" data-bs-target="#tab-myrooms" type="button" role="tab">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-door-open me-2" viewBox="0 0 16 16">
                                <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                                <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                            </svg>
                            Ruangan Saya
                        </div>
                        <span class="badge bg-success rounded-pill"><?= $pRooms ?></span>
                    </button>

                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1 d-flex justify-content-between align-items-center" id="tab-myvehicles-btn" data-bs-toggle="pill" data-bs-target="#tab-myvehicles" type="button" role="tab">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-car-front me-2" viewBox="0 0 16 16">
                                <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.81h7.194a.51.51 0 0 0 .497-.81l-.956-1.913A1 1 0 0 0 10.244 3.75H5.756a1 1 0 0 0-.894.526M2.52 3.515A2 2 0 0 1 4.309 2.5h7.382a2 2 0 0 1 1.79 1.015l1.096 2.193A1.5 1.5 0 0 1 15 6.837V12.5a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5V12H5v.5A1.5 1.5 0 0 1 3.5 14h-1A1.5 1.5 0 0 1 1 12.5V6.837a1.5 1.5 0 0 1 .424-1.129zM2 7v5.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V11h8v1.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V7a.5.5 0 0 0-.5-.5H2.5a.5.5 0 0 0-.5.5"/>
                            </svg>
                            Kendaraan Saya
                        </div>
                        <span class="badge bg-primary rounded-pill"><?= $pVehicles ?></span>
                    </button>

                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1 d-flex justify-content-between align-items-center" id="tab-mymaintenance-btn" data-bs-toggle="pill" data-bs-target="#tab-mymaintenance" type="button" role="tab">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-tools me-2" viewBox="0 0 16 16">
                                <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.969-.969 2.676-2.675a1 1 0 0 1 .707-.293h.07a1 1 0 0 0 .815-.419L16 1 15 0 11.919 2.2a1 1 0 0 0-.419.815v.07a1 1 0 0 1-.293.708L8.532 6.468 6.468 4.404l2.675-2.676a1 1 0 0 1 .708-.293h.07a1 1 0 0 0 .815-.419z"/>
                            </svg>
                            Maintenance Saya
                        </div>
                        <span class="badge bg-warning text-dark rounded-pill"><?= $pMaintenance ?></span>
                    </button>

                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1 d-flex justify-content-between align-items-center" id="tab-mysupplies-btn" data-bs-toggle="pill" data-bs-target="#tab-mysupplies" type="button" role="tab">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-seam me-2" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                            </svg>
                            Supplies (ATK) Saya
                        </div>
                        <span class="badge bg-danger rounded-pill"><?= $pSupplies ?></span>
                    </button>

                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1 d-flex justify-content-between align-items-center" id="tab-myrequests-btn" data-bs-toggle="pill" data-bs-target="#tab-myrequests" type="button" role="tab">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-clock-history me-2" viewBox="0 0 16 16">
                                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .79.522l-.492.871zM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-1 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0m-6.5-4a.5.5 0 0 0-1 0v4.5a.5.5 0 0 0 .246.43l3 1.5a.5.5 0 1 0 .492-.868L8.5 8.243z"/>
                            </svg>
                            Riwayat Semua Pengajuan
                        </div>
                        <span class="badge bg-secondary rounded-pill"><?= $userStats['total_all'] ?? 0 ?></span>
                    </button>

                    <!-- MENU BIODATA PROFIL SAYA (USER) -->
                    <button class="nav-link text-start py-3 px-3 rounded-3 mb-1" id="tab-biodata-user-btn" data-bs-toggle="pill" data-bs-target="#tab-biodata" type="button" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-badge me-2" viewBox="0 0 16 16">
                            <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/>
                            <path d="M8 11a4.978 4.978 0 0 0-3.5 1.454.5.5 0 0 0 .352.854h6.296a.5.5 0 0 0 .354-.854A4.978 4.978 0 0 0 8 11"/>
                        </svg>
                        Biodata Profil Saya
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. KONTEN AREA (TAB CONTENT) -->
    <div class="col-lg-9">
        <div class="tab-content" id="dashboardTabContent">

            <!-- ============================================== -->
            <!-- TAB 1: OVERVIEW & RINGKASAN (SUPER ADMIN & ADMIN) -->
            <!-- ============================================== -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                <?php if (!empty($totalPendingCount) && $totalPendingCount > 0): ?>
                <!-- ALERT CALLOUT: ANTREAN BUTUH VERIFIKASI SEGERA -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #b91c1c, #dc2626);">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.2); width: 48px; height: 48px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bell-fill text-white" viewBox="0 0 16 16">
                                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Terdapat <?= $totalPendingCount ?> Pengajuan Menunggu Konfirmasi</h5>
                                    <small class="text-white-50">Pengguna (Dosen/Mahasiswa) sedang menunggu respon persetujuan (Approve / Reject) dari Admin.</small>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light text-danger fw-bold rounded-pill px-4 shadow-sm" onclick="document.getElementById('tab-verifikasi-btn').click();">
                                    <i class="bi bi-shield-check me-1"></i>Proses Sekarang &rarr;
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 4 KPI Metrics Card (Compact SaaS Style) -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card stat-kpi-card h-100 bg-white border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold text-uppercase">Ruangan</span>
                                    <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success">
                                        <i class="bi bi-door-open fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark my-0"><?= esc($stats['room_bookings'] ?? 0) ?></h3>
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                    <small class="text-muted">Booking Masuk</small>
                                    <?php if (!empty($pendingRooms) && count($pendingRooms) > 0): ?>
                                        <span class="badge bg-danger rounded-pill"><?= count($pendingRooms) ?> Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Clear</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card stat-kpi-card h-100 bg-white border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold text-uppercase">Kendaraan</span>
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                                        <i class="bi bi-car-front fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark my-0"><?= esc($stats['vehicle_bookings'] ?? 0) ?></h3>
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                    <small class="text-muted">Mobil Dinas</small>
                                    <?php if (!empty($pendingVehicles) && count($pendingVehicles) > 0): ?>
                                        <span class="badge bg-danger rounded-pill"><?= count($pendingVehicles) ?> Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Clear</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card stat-kpi-card h-100 bg-white border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold text-uppercase">Maintenance</span>
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-2 text-warning">
                                        <i class="bi bi-tools fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark my-0"><?= esc($stats['maintenance'] ?? 0) ?></h3>
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                    <small class="text-muted">Laporan Kerusakan</small>
                                    <?php if (!empty($pendingMaintenance) && count($pendingMaintenance) > 0): ?>
                                        <span class="badge bg-warning text-dark rounded-pill"><?= count($pendingMaintenance) ?> Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Clear</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card stat-kpi-card h-100 bg-white border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted small fw-semibold text-uppercase">Supplies (ATK)</span>
                                    <div class="rounded-circle bg-danger bg-opacity-10 p-2 text-danger">
                                        <i class="bi bi-box-seam fs-5"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark my-0"><?= esc($stats['supplies'] ?? 0) ?></h3>
                                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                    <small class="text-muted">Permintaan Barang</small>
                                    <?php if (!empty($pendingSupplies) && count($pendingSupplies) > 0): ?>
                                        <span class="badge bg-danger rounded-pill"><?= count($pendingSupplies) ?> Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Clear</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRAFIK TREN BULANAN: PEMINJAMAN, ATK, DAN MAINTENANCE -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">
                                    <i class="bi bi-graph-up-arrow text-primary me-2"></i>Grafik Tren Pengajuan Bulanan (Tahun <?= esc($monthlyStats['year'] ?? date('Y')) ?>)
                                </h5>
                                <small class="text-muted">Statistik perbandingan tren peminjaman fasilitas, permintaan ATK, dan request maintenance per bulan.</small>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background-color: rgba(37, 99, 235, 0.12); color: #1d4ed8; border: 1px solid rgba(37, 99, 235, 0.25);">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Peminjaman (<?= array_sum($monthlyStats['peminjaman'] ?? []) ?>)
                                </span>
                                <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background-color: rgba(220, 38, 38, 0.12); color: #b91c1c; border: 1px solid rgba(220, 38, 38, 0.25);">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Request ATK (<?= array_sum($monthlyStats['supplies'] ?? []) ?>)
                                </span>
                                <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background-color: rgba(217, 119, 6, 0.12); color: #b45309; border: 1px solid rgba(217, 119, 6, 0.25);">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Maintenance (<?= array_sum($monthlyStats['maintenance'] ?? []) ?>)
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div style="position: relative; height: 320px; width: 100%;">
                            <canvas id="monthlyTrendsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- TAB 2: CRUD PELAPORAN (LOST & FOUND + VISITOR) -->
            <!-- ============================================== -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-pelaporan" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <div>
                                <h4 class="fw-bold mb-1 text-primary">
                                    <i class="bi bi-clipboard-data me-2"></i>Manajemen Pelaporan
                                </h4>
                                <small class="text-muted">Kelola data Pelaporan Barang Hilang (Lost & Found) dan Buku Tamu Kampus (Visitors).</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="/dashboard/export-pdf/pelaporan" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF Semua Pelaporan
                                </a>
                            </div>
                        </div>

                        <!-- Sub-Nav Pelaporan -->
                        <ul class="nav nav-pills" id="pelaporanSubTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active rounded-pill px-4" id="sub-lostfound-tab" data-bs-toggle="pill" data-bs-target="#sub-lostfound" type="button" role="tab">
                                    Lost & Found (<?= count($allLostFound) ?>)
                                </button>
                            </li>
                            <li class="nav-item ms-2">
                                <button class="nav-link rounded-pill px-4" id="sub-visitor-tab" data-bs-toggle="pill" data-bs-target="#sub-visitor" type="button" role="tab">
                                    Buku Tamu / Visitor (<?= count($allVisitors) ?>)
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body pt-0">
                        <div class="tab-content">
                            <!-- SUB-TAB: LOST & FOUND -->
                            <div class="tab-pane fade show active" id="sub-lostfound" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">Daftar Laporan Lost & Found</h6>
                                    <div class="d-flex gap-2">
                                        <a href="/dashboard/export-pdf/lost-found" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                                        </a>
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalAddLostFound">
                                            + Tambah Laporan
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive table-responsive-scroll">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>No</th>
                                                <th>Pelapor</th>
                                                <th>Barang Hilang</th>
                                                <th>Kontak</th>
                                                <th>Waktu Kejadian</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($allLostFound)): ?>
                                                <?php $no = 1; foreach ($allLostFound as $lf): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td>
                                                            <strong><?= esc($lf['reporter_name']) ?></strong><br>
                                                            <small class="text-muted"><?= esc($lf['reporter_status']) ?></small>
                                                        </td>
                                                        <td><strong><?= esc($lf['lost_item']) ?></strong></td>
                                                        <td><?= esc($lf['contact']) ?></td>
                                                        <td>
                                                            <?= esc($lf['incident_date']) ?><br>
                                                            <small class="text-muted"><?= esc($lf['incident_time']) ?></small>
                                                        </td>
                                                        <td>
                                                            <?php if ($lf['status'] === 'claimed'): ?>
                                                                <span class="badge bg-success">Claimed (Diambil)</span>
                                                            <?php elseif ($lf['status'] === 'found'): ?>
                                                                <span class="badge bg-info text-dark">Found (Ditemukan)</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning text-dark">Reported</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditLostFound<?= $lf['id'] ?>">Edit</button>
                                                                <form method="post" action="/dashboard/pelaporan/lost-found/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Laporan Lost & Found" data-swal-text="Hapus laporan barang <?= esc($lf['lost_item']) ?>?">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $lf['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="sub-lostfound">
                                                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- MODAL EDIT LOST FOUND -->
                                                    <div class="modal fade" id="modalEditLostFound<?= $lf['id'] ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow rounded-4">
                                                                <div class="modal-header border-0 pb-0">
                                                                    <h5 class="modal-title fw-bold">Edit Laporan Lost & Found</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form method="post" action="/dashboard/pelaporan/lost-found/update">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $lf['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="sub-lostfound">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Nama Pelapor</label>
                                                                            <input type="text" name="reporter_name" class="form-control" value="<?= esc($lf['reporter_name']) ?>" required>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Status Pelapor</label>
                                                                                <input type="text" name="reporter_status" class="form-control" value="<?= esc($lf['reporter_status']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">No. Kontak / WA</label>
                                                                                <input type="text" name="contact" class="form-control" value="<?= esc($lf['contact']) ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Nama Barang Hilang</label>
                                                                            <input type="text" name="lost_item" class="form-control" value="<?= esc($lf['lost_item']) ?>" required>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Tanggal Kejadian</label>
                                                                                <input type="date" name="incident_date" class="form-control" value="<?= esc($lf['incident_date']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Waktu Kejadian</label>
                                                                                <input type="time" name="incident_time" class="form-control" value="<?= esc($lf['incident_time']) ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Status Barang</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="reported" <?= $lf['status'] === 'reported' ? 'selected' : '' ?>>Reported (Barang Dilaporkan)</option>
                                                                                <option value="found" <?= $lf['status'] === 'found' ? 'selected' : '' ?>>Found (Barang Ditemukan)</option>
                                                                                <option value="claimed" <?= $lf['status'] === 'claimed' ? 'selected' : '' ?>>Claimed (Sudah Diambil Pemilik)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 pt-0">
                                                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data Lost & Found.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- SUB-TAB: BUKU TAMU / VISITOR -->
                            <div class="tab-pane fade" id="sub-visitor" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">Daftar Buku Tamu (Visitor)</h6>
                                    <div class="d-flex gap-2">
                                        <a href="/dashboard/export-pdf/visitor" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                                        </a>
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalAddVisitor">
                                            + Tambah Tamu
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive table-responsive-scroll">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Tamu & Instansi</th>
                                                <th>Kontak</th>
                                                <th>Keperluan</th>
                                                <th>Host yang Dituju</th>
                                                <th>Waktu Check In / Out</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($allVisitors)): ?>
                                                <?php $no = 1; foreach ($allVisitors as $vt): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td>
                                                            <strong><?= esc($vt['visitor_name']) ?></strong><br>
                                                            <small class="text-muted"><?= esc($vt['institution']) ?></small>
                                                        </td>
                                                        <td><?= esc($vt['contact']) ?></td>
                                                        <td><?= esc($vt['purpose']) ?></td>
                                                        <td><?= esc($vt['host_name']) ?></td>
                                                        <td>
                                                            <small class="d-block text-success">In: <?= esc($vt['check_in'] ?? '-') ?></small>
                                                            <small class="d-block text-secondary">Out: <?= esc($vt['check_out'] ?? 'Belum Keluar') ?></small>
                                                        </td>
                                                        <td>
                                                            <?php if ($vt['status'] === 'checked_out'): ?>
                                                                <span class="badge bg-secondary">Checked Out</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-success">Checked In (Aktif)</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditVisitor<?= $vt['id'] ?>">Edit</button>
                                                                <form method="post" action="/dashboard/pelaporan/visitor/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Data Tamu" data-swal-text="Hapus data kunjungan tamu <?= esc($vt['visitor_name']) ?>?">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $vt['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="sub-visitor">
                                                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- MODAL EDIT VISITOR -->
                                                    <div class="modal fade" id="modalEditVisitor<?= $vt['id'] ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow rounded-4">
                                                                <div class="modal-header border-0 pb-0">
                                                                    <h5 class="modal-title fw-bold">Edit Kunjungan Tamu</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form method="post" action="/dashboard/pelaporan/visitor/update">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $vt['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="sub-visitor">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Nama Pengunjung</label>
                                                                            <input type="text" name="visitor_name" class="form-control" value="<?= esc($vt['visitor_name']) ?>" required>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Instansi / Asal</label>
                                                                                <input type="text" name="institution" class="form-control" value="<?= esc($vt['institution']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Kontak</label>
                                                                                <input type="text" name="contact" class="form-control" value="<?= esc($vt['contact']) ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Keperluan</label>
                                                                            <input type="text" name="purpose" class="form-control" value="<?= esc($vt['purpose']) ?>" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Host / Yang Dituju</label>
                                                                            <input type="text" name="host_name" class="form-control" value="<?= esc($vt['host_name']) ?>" required>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Check-In</label>
                                                                                <input type="text" name="check_in" class="form-control" value="<?= esc($vt['check_in'] ?? '') ?>">
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Check-Out</label>
                                                                                <input type="text" name="check_out" class="form-control" value="<?= esc($vt['check_out'] ?? '') ?>" placeholder="YYYY-MM-DD HH:MM:SS">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Status Tamu</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="checked_in" <?= $vt['status'] === 'checked_in' ? 'selected' : '' ?>>Checked In (Masih di Kampus)</option>
                                                                                <option value="checked_out" <?= $vt['status'] === 'checked_out' ? 'selected' : '' ?>>Checked Out (Sudah Keluar)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 pt-0">
                                                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data kunjungan tamu.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- TAB 3: CRUD PEMINJAMAN (RUANGAN + KENDARAAN) -->
            <!-- ============================================== -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-peminjaman" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <div>
                                <h4 class="fw-bold mb-1 text-success">
                                    <i class="bi bi-calendar2-range me-2"></i>Manajemen Peminjaman
                                </h4>
                                <small class="text-muted">Kelola data Peminjaman Ruangan Rapat/Auditorium dan Peminjaman Kendaraan Operasional Kampus.</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="/dashboard/export-pdf/peminjaman" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF Semua Peminjaman
                                </a>
                            </div>
                        </div>

                        <!-- Sub-Nav Peminjaman -->
                        <ul class="nav nav-pills" id="peminjamanSubTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active rounded-pill px-4" id="sub-ruangan-tab" data-bs-toggle="pill" data-bs-target="#sub-ruangan" type="button" role="tab">
                                    Peminjaman Ruangan (<?= count($allRoomBookings) ?>)
                                </button>
                            </li>
                            <li class="nav-item ms-2">
                                <button class="nav-link rounded-pill px-4" id="sub-kendaraan-tab" data-bs-toggle="pill" data-bs-target="#sub-kendaraan" type="button" role="tab">
                                    Peminjaman Kendaraan (<?= count($allVehicleBookings) ?>)
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body pt-0">
                        <div class="tab-content">
                            <!-- SUB-TAB: PEMINJAMAN RUANGAN -->
                            <div class="tab-pane fade show active" id="sub-ruangan" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">Daftar Peminjaman Ruangan</h6>
                                    <div class="d-flex gap-2">
                                        <a href="/dashboard/export-pdf/ruangan" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                                        </a>
                                        <button type="button" class="btn btn-success btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddRoomBooking">
                                            + Tambah Booking Ruangan
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive table-responsive-scroll">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>No</th>
                                                <th>Peminjam & Unit</th>
                                                <th>Ruangan</th>
                                                <th>Nama Event & Setup</th>
                                                <th>Tanggal & Jam</th>
                                                <th>Material & Catatan</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($allRoomBookings)): ?>
                                                <?php $no = 1; foreach ($allRoomBookings as $rb): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td>
                                                            <strong><?= esc($rb['booker_name']) ?></strong><br>
                                                            <small class="badge bg-light text-dark border"><?= esc($rb['department']) ?></small>
                                                            <?php if (!empty($rb['submitter_username'])): ?>
                                                                <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($rb['submitter_user_name'] ?? $rb['submitter_username']) ?> (@<?= esc($rb['submitter_username']) ?>)</small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <strong class="text-success"><?= esc($rb['room_name'] ?? 'Ruang #' . $rb['room_id']) ?></strong><br>
                                                            <small class="text-muted">Kapasitas: <?= esc($rb['capacity'] ?? '-') ?> orang</small>
                                                        </td>
                                                        <td>
                                                            <strong><?= esc($rb['event_name']) ?></strong><br>
                                                            <small class="text-muted">Setup: <?= esc($rb['setup'] ?: '-') ?></small>
                                                        </td>
                                                        <td>
                                                            <?= esc($rb['booking_date']) ?><br>
                                                            <small class="text-muted"><?= esc($rb['start_time']) ?> - <?= esc($rb['end_time']) ?></small>
                                                        </td>
                                                        <td>
                                                            <small class="d-block text-truncate" style="max-width: 150px;" title="<?= esc($rb['material_needed']) ?>">Mat: <?= esc($rb['material_needed'] ?: '-') ?></small>
                                                            <small class="d-block text-truncate text-muted" style="max-width: 150px;" title="<?= esc($rb['special_request']) ?>">Req: <?= esc($rb['special_request'] ?: '-') ?></small>
                                                        </td>
                                                        <td>
                                                            <?php if ($rb['status'] === 'approved'): ?>
                                                                <span class="badge bg-success">Approved</span>
                                                            <?php elseif ($rb['status'] === 'rejected'): ?>
                                                                <span class="badge bg-danger">Rejected</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            <?php endif; ?>
                                                            <?php if ($rb['status'] === 'rejected' && !empty($rb['admin_note'])): ?>
                                                                <br><small class="text-danger"><i class="bi bi-x-circle me-1"></i><?= esc($rb['admin_note']) ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm">
                                                                <?php if ($rb['status'] === 'pending'): ?>
                                                                    <button type="button" class="btn btn-success" title="Setujui" onclick="openApproveModal('room_bookings', <?= $rb['id'] ?>, 'Peminjaman Ruangan', '<?= esc($rb['room_name'] ?? 'Ruang') ?>', '<?= esc($rb['booker_name']) ?>', 'peminjaman')">
                                                                        <i class="bi bi-check-lg"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger" title="Tolak" onclick="openRejectModal('room_bookings', <?= $rb['id'] ?>, 'Peminjaman Ruangan', '<?= esc($rb['room_name'] ?? 'Ruang') ?>', '<?= esc($rb['booker_name']) ?>', 'peminjaman')">
                                                                        <i class="bi bi-x-lg"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditRoomBooking<?= $rb['id'] ?>">Edit</button>
                                                                <form method="post" action="/dashboard/peminjaman/ruangan/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Booking Ruangan" data-swal-text="Hapus booking ruangan kegiatan <?= esc($rb['event_name']) ?>?">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $rb['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="sub-room">
                                                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- MODAL EDIT ROOM BOOKING -->
                                                    <div class="modal fade" id="modalEditRoomBooking<?= $rb['id'] ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow rounded-4">
                                                                <div class="modal-header border-0 pb-0">
                                                                    <h5 class="modal-title fw-bold text-success">Edit Peminjaman Ruangan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form method="post" action="/dashboard/peminjaman/ruangan/update">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $rb['id'] ?>">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Pilih Ruangan</label>
                                                                            <select name="room_id" class="form-select" required>
                                                                                <?php foreach ($roomsList as $rm): ?>
                                                                                    <option value="<?= $rm['id'] ?>" <?= $rm['id'] == $rb['room_id'] ? 'selected' : '' ?>>
                                                                                        <?= esc($rm['room_name']) ?> (Kapasitas: <?= esc($rm['capacity']) ?>)
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Nama Peminjam</label>
                                                                                <input type="text" name="booker_name" class="form-control" value="<?= esc($rb['booker_name']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Department</label>
                                                                                <select name="department" class="form-select" required>
                                                                                    <?php foreach ($departments as $dept): ?>
                                                                                        <option value="<?= $dept ?>" <?= $dept === $rb['department'] ? 'selected' : '' ?>><?= $dept ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4 mb-3">
                                                                                <label class="form-label fw-semibold">Tanggal</label>
                                                                                <input type="date" name="booking_date" class="form-control" value="<?= esc($rb['booking_date']) ?>" required>
                                                                            </div>
                                                                            <div class="col-4 mb-3">
                                                                                <label class="form-label fw-semibold">Waktu Masuk</label>
                                                                                <input type="time" name="start_time" class="form-control" value="<?= esc($rb['start_time']) ?>" required>
                                                                            </div>
                                                                            <div class="col-4 mb-3">
                                                                                <label class="form-label fw-semibold">Waktu Keluar</label>
                                                                                <input type="time" name="end_time" class="form-control" value="<?= esc($rb['end_time']) ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Nama Event</label>
                                                                            <input type="text" name="event_name" class="form-control" value="<?= esc($rb['event_name']) ?>" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Set UP Ruangan</label>
                                                                            <input type="text" name="setup" class="form-control" value="<?= esc($rb['setup']) ?>" placeholder="Classroom, U-Shape, Theater">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Material Needed</label>
                                                                                <input type="text" name="material_needed" class="form-control" value="<?= esc($rb['material_needed']) ?>">
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Special Request</label>
                                                                                <input type="text" name="special_request" class="form-control" value="<?= esc($rb['special_request']) ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Status Pengajuan</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="pending" <?= $rb['status'] === 'pending' ? 'selected' : '' ?>>Pending (Menunggu)</option>
                                                                                <option value="approved" <?= $rb['status'] === 'approved' ? 'selected' : '' ?>>Approved (Disetujui)</option>
                                                                                <option value="rejected" <?= $rb['status'] === 'rejected' ? 'selected' : '' ?>>Rejected (Ditolak)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Catatan Admin / Alasan Penolakan</label>
                                                                            <textarea name="admin_note" class="form-control" rows="2" placeholder="Catatan persetujuan atau alasan jika ditolak"><?= esc($rb['admin_note'] ?? '') ?></textarea>
                                                                            <small class="text-muted">Catatan ini akan dapat dilihat oleh pemohon pada dashboard mereka.</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 pt-0">
                                                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data peminjaman ruangan.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- SUB-TAB: PEMINJAMAN KENDARAAN -->
                            <div class="tab-pane fade" id="sub-kendaraan" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">Daftar Peminjaman Kendaraan</h6>
                                    <div class="d-flex gap-2">
                                        <a href="/dashboard/export-pdf/kendaraan" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                                        </a>
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddVehicleBooking">
                                            + Tambah Booking Kendaraan
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive table-responsive-scroll">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>No</th>
                                                <th>Peminjam & Unit</th>
                                                <th>Kendaraan</th>
                                                <th>Tujuan & Keperluan</th>
                                                <th>Jadwal (Hari, Tgl, Jam)</th>
                                                <th>Driver & KM</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($allVehicleBookings)): ?>
                                                <?php $no = 1; foreach ($allVehicleBookings as $vb): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td>
                                                            <strong><?= esc($vb['booker_name']) ?></strong><br>
                                                            <small class="badge bg-light text-dark border"><?= esc($vb['department']) ?></small>
                                                            <?php if (!empty($vb['submitter_username'])): ?>
                                                                <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($vb['submitter_user_name'] ?? $vb['submitter_username']) ?> (@<?= esc($vb['submitter_username']) ?>)</small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <strong class="text-primary"><?= esc($vb['vehicle_name'] ?? 'Kendaraan') ?></strong><br>
                                                            <span class="badge bg-secondary-subtle text-secondary"><?= esc($vb['plate_number'] ?? '-') ?></span>
                                                        </td>
                                                        <td>
                                                            <strong><?= esc($vb['destination']) ?></strong><br>
                                                            <small class="text-muted"><?= esc($vb['description'] ?: '-') ?></small>
                                                        </td>
                                                        <td>
                                                            <?= esc($vb['booking_day']) ?>, <?= esc($vb['booking_date']) ?><br>
                                                            <small class="text-muted"><?= esc($vb['start_time']) ?> - <?= esc($vb['end_time']) ?></small>
                                                        </td>
                                                        <td>
                                                            <small class="d-block fw-semibold"><i class="bi bi-person me-1"></i><?= esc($vb['driver_name']) ?></small>
                                                            <small class="text-muted">In: <?= esc($vb['km_in'] ?? '-') ?> | Out: <?= esc($vb['km_out'] ?? '-') ?></small>
                                                        </td>
                                                        <td>
                                                            <?php if ($vb['status'] === 'approved'): ?>
                                                                <span class="badge bg-success">Approved</span>
                                                            <?php elseif ($vb['status'] === 'rejected'): ?>
                                                                <span class="badge bg-danger">Rejected</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            <?php endif; ?>
                                                            <?php if ($vb['status'] === 'rejected' && !empty($vb['admin_note'])): ?>
                                                                <br><small class="text-danger"><i class="bi bi-x-circle me-1"></i><?= esc($vb['admin_note']) ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm">
                                                                <?php if ($vb['status'] === 'pending'): ?>
                                                                    <button type="button" class="btn btn-success" title="Setujui" onclick="openApproveModal('vehicle_bookings', <?= $vb['id'] ?>, 'Peminjaman Kendaraan', '<?= esc($vb['vehicle_name'] ?? 'Kendaraan') ?>', '<?= esc($vb['booker_name']) ?>', 'peminjaman')">
                                                                        <i class="bi bi-check-lg"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger" title="Tolak" onclick="openRejectModal('vehicle_bookings', <?= $vb['id'] ?>, 'Peminjaman Kendaraan', '<?= esc($vb['vehicle_name'] ?? 'Kendaraan') ?>', '<?= esc($vb['booker_name']) ?>', 'peminjaman')">
                                                                        <i class="bi bi-x-lg"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditVehicleBooking<?= $vb['id'] ?>">Edit</button>
                                                                <form method="post" action="/dashboard/peminjaman/kendaraan/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Booking Kendaraan" data-swal-text="Hapus booking kendaraan tujuan <?= esc($vb['destination']) ?>?">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $vb['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="sub-kendaraan">
                                                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- MODAL EDIT VEHICLE BOOKING -->
                                                    <div class="modal fade" id="modalEditVehicleBooking<?= $vb['id'] ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow rounded-4">
                                                                <div class="modal-header border-0 pb-0">
                                                                    <h5 class="modal-title fw-bold text-primary">Edit Peminjaman Kendaraan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form method="post" action="/dashboard/peminjaman/kendaraan/update">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $vb['id'] ?>">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Pilih Kendaraan</label>
                                                                            <select name="vehicle_id" class="form-select" required>
                                                                                <?php foreach ($vehiclesList as $vc): ?>
                                                                                    <option value="<?= $vc['id'] ?>" <?= $vc['id'] == $vb['vehicle_id'] ? 'selected' : '' ?>>
                                                                                        <?= esc($vc['vehicle_name']) ?> (<?= esc($vc['plate_number']) ?>)
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Nama Peminjam</label>
                                                                                <input type="text" name="booker_name" class="form-control" value="<?= esc($vb['booker_name']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Department</label>
                                                                                <select name="department" class="form-select" required>
                                                                                    <?php foreach ($departments as $dept): ?>
                                                                                        <option value="<?= $dept ?>" <?= $dept === $vb['department'] ? 'selected' : '' ?>><?= $dept ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Tanggal Peminjaman</label>
                                                                                <input type="date" name="booking_date" class="form-control" value="<?= esc($vb['booking_date']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Hari</label>
                                                                                <input type="text" name="booking_day" class="form-control" value="<?= esc($vb['booking_day']) ?>" placeholder="Senin / Selasa / dll">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Jam Masuk (Berangkat)</label>
                                                                                <input type="time" name="start_time" class="form-control" value="<?= esc($vb['start_time']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Jam Keluar (Kembali)</label>
                                                                                <input type="time" name="end_time" class="form-control" value="<?= esc($vb['end_time']) ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Tujuan</label>
                                                                            <input type="text" name="destination" class="form-control" value="<?= esc($vb['destination']) ?>" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Keterangan / Keperluan</label>
                                                                            <textarea name="description" class="form-control" rows="2"><?= esc($vb['description']) ?></textarea>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Nama Driver</label>
                                                                                <input type="text" name="driver_name" class="form-control" value="<?= esc($vb['driver_name']) ?>">
                                                                            </div>
                                                                            <div class="col-3 mb-3">
                                                                                <label class="form-label fw-semibold">KM In</label>
                                                                                <input type="number" name="km_in" class="form-control" value="<?= esc($vb['km_in'] ?? '') ?>">
                                                                            </div>
                                                                            <div class="col-3 mb-3">
                                                                                <label class="form-label fw-semibold">KM Out</label>
                                                                                <input type="number" name="km_out" class="form-control" value="<?= esc($vb['km_out'] ?? '') ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Status</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="pending" <?= $vb['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                                                <option value="approved" <?= $vb['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                                                                <option value="rejected" <?= $vb['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Catatan Admin / Alasan Penolakan</label>
                                                                            <textarea name="admin_note" class="form-control" rows="2" placeholder="Catatan persetujuan atau alasan jika ditolak"><?= esc($vb['admin_note'] ?? '') ?></textarea>
                                                                            <small class="text-muted">Catatan ini akan dapat dilihat oleh pemohon pada dashboard mereka.</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 pt-0">
                                                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data peminjaman kendaraan.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- TAB 4: CRUD REQUEST (MAINTENANCE + SUPPLIES) -->
            <!-- ============================================== -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-request" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <div>
                                <h4 class="fw-bold mb-1 text-warning">
                                    <i class="bi bi-tools me-2"></i>Manajemen Permintaan (Request)
                                </h4>
                                <small class="text-muted">Kelola data Request Maintenance (Perbaikan Fasilitas) dan Permohonan Supplies (ATK).</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="/dashboard/export-pdf/request" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF Semua Request
                                </a>
                            </div>
                        </div>

                        <!-- Sub-Nav Request -->
                        <ul class="nav nav-pills" id="requestSubTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active rounded-pill px-4" id="sub-maint-tab" data-bs-toggle="pill" data-bs-target="#sub-maint" type="button" role="tab">
                                    Request Maintenance (<?= count($allMaintenance) ?>)
                                </button>
                            </li>
                            <li class="nav-item ms-2">
                                <button class="nav-link rounded-pill px-4" id="sub-supp-tab" data-bs-toggle="pill" data-bs-target="#sub-supp" type="button" role="tab">
                                    Permohonan Supplies (<?= count($allSupplyRequests) ?>)
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body pt-0">
                        <div class="tab-content">
                            <!-- SUB-TAB: REQUEST MAINTENANCE -->
                            <div class="tab-pane fade show active" id="sub-maint" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">Daftar Request Maintenance</h6>
                                    <div class="d-flex gap-2">
                                        <a href="/dashboard/export-pdf/maintenance" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#modalAddMaintenance">
                                            + Tambah Maintenance
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive table-responsive-scroll">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>No</th>
                                                <th>Pemohon & Unit</th>
                                                <th>Fasilitas</th>
                                                <th>Lokasi Kerusakan</th>
                                                <th>Keterangan Kerusakan</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($allMaintenance)): ?>
                                                <?php $no = 1; foreach ($allMaintenance as $m): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td>
                                                            <strong><?= esc($m['requester_name']) ?></strong><br>
                                                            <small class="badge bg-light text-dark border"><?= esc($m['department']) ?></small>
                                                            <?php if (!empty($m['submitter_username'])): ?>
                                                                <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($m['submitter_user_name'] ?? $m['submitter_username']) ?> (@<?= esc($m['submitter_username']) ?>)</small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><span class="badge bg-warning text-dark"><?= esc($m['facility']) ?></span></td>
                                                        <td><?= esc($m['location']) ?></td>
                                                        <td><small><?= esc($m['description']) ?></small></td>
                                                        <td>
                                                            <?php if ($m['status'] === 'resolved' || $m['status'] === 'approved'): ?>
                                                                <span class="badge bg-success">Resolved (Selesai)</span>
                                                            <?php elseif ($m['status'] === 'rejected'): ?>
                                                                <span class="badge bg-danger">Rejected (Ditolak)</span>
                                                            <?php elseif ($m['status'] === 'in_progress'): ?>
                                                                <span class="badge bg-info text-dark">In Progress (Dikerjakan)</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            <?php endif; ?>
                                                            <?php if ($m['status'] === 'rejected' && !empty($m['admin_note'])): ?>
                                                                <br><small class="text-danger"><i class="bi bi-x-circle me-1"></i><?= esc($m['admin_note']) ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm">
                                                                <?php if ($m['status'] === 'pending' || $m['status'] === 'in_progress'): ?>
                                                                    <button type="button" class="btn btn-success" title="Update / Selesaikan" onclick="openApproveModal('maintenance_requests', <?= $m['id'] ?>, 'Maintenance', '<?= esc($m['facility']) ?>', '<?= esc($m['requester_name']) ?>', 'request')">
                                                                        <i class="bi bi-check-lg"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger" title="Tolak" onclick="openRejectModal('maintenance_requests', <?= $m['id'] ?>, 'Maintenance', '<?= esc($m['facility']) ?>', '<?= esc($m['requester_name']) ?>', 'request')">
                                                                        <i class="bi bi-x-lg"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditMaintenance<?= $m['id'] ?>">Edit</button>
                                                                <form method="post" action="/dashboard/request/maintenance/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Request Maintenance" data-swal-text="Hapus request maintenance di <?= esc($m['location']) ?>?">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="request-maintenance">
                                                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- MODAL EDIT MAINTENANCE -->
                                                    <div class="modal fade" id="modalEditMaintenance<?= $m['id'] ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow rounded-4">
                                                                <div class="modal-header border-0 pb-0">
                                                                    <h5 class="modal-title fw-bold text-warning text-dark">Edit Request Maintenance</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form method="post" action="/dashboard/request/maintenance/update">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Nama Pemohon</label>
                                                                                <input type="text" name="requester_name" class="form-control" value="<?= esc($m['requester_name']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Department</label>
                                                                                <select name="department" class="form-select" required>
                                                                                    <?php foreach ($departments as $dept): ?>
                                                                                        <option value="<?= $dept ?>" <?= $dept === $m['department'] ? 'selected' : '' ?>><?= $dept ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Fasilitas</label>
                                                                                <select name="facility" class="form-select" required>
                                                                                    <option value="Lampu" <?= $m['facility'] === 'Lampu' ? 'selected' : '' ?>>Lampu</option>
                                                                                    <option value="AC" <?= $m['facility'] === 'AC' ? 'selected' : '' ?>>AC</option>
                                                                                    <option value="Air" <?= $m['facility'] === 'Air' ? 'selected' : '' ?>>Air</option>
                                                                                    <option value="Komputer/Jaringan" <?= $m['facility'] === 'Komputer/Jaringan' ? 'selected' : '' ?>>Komputer / Jaringan IT</option>
                                                                                    <option value="Other" <?= !in_array($m['facility'], ['Lampu', 'AC', 'Air', 'Komputer/Jaringan']) ? 'selected' : '' ?>>Other (Lainnya)</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Lokasi Kerusakan</label>
                                                                                <input type="text" name="location" class="form-control" value="<?= esc($m['location']) ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Keterangan Kerusakan</label>
                                                                            <textarea name="description" class="form-control" rows="3" required><?= esc($m['description']) ?></textarea>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Status Penanganan</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="pending" <?= $m['status'] === 'pending' ? 'selected' : '' ?>>Pending (Menunggu Antrian)</option>
                                                                                <option value="in_progress" <?= $m['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress (Sedang Dikerjakan Teknisi)</option>
                                                                                <option value="resolved" <?= $m['status'] === 'resolved' ? 'selected' : '' ?>>Resolved (Sudah Diperbaiki / Selesai)</option>
                                                                                <option value="rejected" <?= $m['status'] === 'rejected' ? 'selected' : '' ?>>Rejected (Ditolak)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Catatan Admin / Alasan Penolakan</label>
                                                                            <textarea name="admin_note" class="form-control" rows="2" placeholder="Catatan tindak lanjut atau alasan jika ditolak"><?= esc($m['admin_note'] ?? '') ?></textarea>
                                                                            <small class="text-muted">Catatan ini akan dapat dilihat oleh pemohon pada dashboard mereka.</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 pt-0">
                                                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada request maintenance.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- SUB-TAB: PERMOHONAN SUPPLIES -->
                            <div class="tab-pane fade" id="sub-supp" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">Daftar Permohonan Supplies (ATK)</h6>
                                    <div class="d-flex gap-2">
                                        <a href="/dashboard/export-pdf/supplies" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddSupplyRequest">
                                            + Tambah Permohonan ATK
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive table-responsive-scroll">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>No</th>
                                                <th>Pemohon & Email</th>
                                                <th>Unit Kerja</th>
                                                <th>Barang yang Diminta</th>
                                                <th>Jumlah (Qty)</th>
                                                <th>Tanggal (Request / Needed)</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($allSupplyRequests)): ?>
                                                <?php $no = 1; foreach ($allSupplyRequests as $sr): ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td>
                                                            <strong><?= esc($sr['requester_name']) ?></strong><br>
                                                            <small class="text-muted"><?= esc($sr['email'] ?: '-') ?></small>
                                                            <?php if (!empty($sr['submitter_username'])): ?>
                                                                <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($sr['submitter_user_name'] ?? $sr['submitter_username']) ?> (@<?= esc($sr['submitter_username']) ?>)</small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><span class="badge bg-light text-dark border"><?= esc($sr['department']) ?></span></td>
                                                        <td>
                                                            <strong><?= esc($sr['item_name'] ?? 'Barang #' . $sr['supply_id']) ?></strong><br>
                                                            <small class="text-muted">Stok Sarpras: <?= esc($sr['stock'] ?? 0) ?> <?= esc($sr['unit'] ?? '') ?></small>
                                                        </td>
                                                        <td>
                                                            <strong class="fs-6"><?= esc($sr['quantity']) ?></strong> <?= esc($sr['unit'] ?? 'Unit') ?>
                                                        </td>
                                                        <td>
                                                            Req: <?= esc($sr['date_requested']) ?><br>
                                                            <small class="text-danger fw-semibold">Butuh: <?= esc($sr['date_needed']) ?></small>
                                                        </td>
                                                        <td>
                                                            <?php if ($sr['status'] === 'approved'): ?>
                                                                <span class="badge bg-success">Approved</span>
                                                            <?php elseif ($sr['status'] === 'rejected'): ?>
                                                                <span class="badge bg-danger">Rejected</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            <?php endif; ?>
                                                            <?php if ($sr['status'] === 'rejected' && !empty($sr['admin_note'])): ?>
                                                                <br><small class="text-danger"><i class="bi bi-x-circle me-1"></i><?= esc($sr['admin_note']) ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm">
                                                                <?php if ($sr['status'] === 'pending'): ?>
                                                                    <button type="button" class="btn btn-success" title="Setujui & Serahkan" onclick="openApproveModal('supply_requests', <?= $sr['id'] ?>, 'Supplies (ATK)', '<?= esc($sr['item_name'] ?? 'Barang') ?>', '<?= esc($sr['requester_name']) ?>', 'request')">
                                                                        <i class="bi bi-check-lg"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger" title="Tolak" onclick="openRejectModal('supply_requests', <?= $sr['id'] ?>, 'Supplies (ATK)', '<?= esc($sr['item_name'] ?? 'Barang') ?>', '<?= esc($sr['requester_name']) ?>', 'request')">
                                                                        <i class="bi bi-x-lg"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditSupplyRequest<?= $sr['id'] ?>">Edit</button>
                                                                <form method="post" action="/dashboard/request/supplies/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Permohonan ATK" data-swal-text="Hapus permohonan barang <?= esc($sr['item_name'] ?? '') ?>?">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $sr['id'] ?>">
                                                                    <input type="hidden" name="redirect_tab" value="request-supplies">
                                                                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- MODAL EDIT SUPPLY REQUEST -->
                                                    <div class="modal fade" id="modalEditSupplyRequest<?= $sr['id'] ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow rounded-4">
                                                                <div class="modal-header border-0 pb-0">
                                                                    <h5 class="modal-title fw-bold text-danger">Edit Permohonan Supplies</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form method="post" action="/dashboard/request/supplies/update">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $sr['id'] ?>">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Nama Pemohon</label>
                                                                                <input type="text" name="requester_name" class="form-control" value="<?= esc($sr['requester_name']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Email</label>
                                                                                <input type="email" name="email" class="form-control" value="<?= esc($sr['email']) ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Department / Unit</label>
                                                                            <select name="department" class="form-select" required>
                                                                                <?php foreach ($departments as $dept): ?>
                                                                                    <option value="<?= $dept ?>" <?= $dept === $sr['department'] ? 'selected' : '' ?>><?= $dept ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-8 mb-3">
                                                                                <label class="form-label fw-semibold">Pilih Barang</label>
                                                                                <select name="supply_id" class="form-select" required>
                                                                                    <?php foreach ($suppliesList as $s): ?>
                                                                                        <option value="<?= $s['id'] ?>" <?= $s['id'] == $sr['supply_id'] ? 'selected' : '' ?>>
                                                                                            <?= esc($s['item_name']) ?> (Stok: <?= esc($s['stock']) ?> <?= esc($s['unit']) ?>)
                                                                                        </option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-4 mb-3">
                                                                                <label class="form-label fw-semibold">Jumlah (Qty)</label>
                                                                                <input type="number" name="quantity" class="form-control" value="<?= esc($sr['quantity']) ?>" min="1" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Tanggal Diajukan</label>
                                                                                <input type="date" name="date_requested" class="form-control" value="<?= esc($sr['date_requested']) ?>" required>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label fw-semibold">Dibutuhkan Tanggal</label>
                                                                                <input type="date" name="date_needed" class="form-control" value="<?= esc($sr['date_needed']) ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Status Permohonan</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="pending" <?= $sr['status'] === 'pending' ? 'selected' : '' ?>>Pending (Menunggu)</option>
                                                                                <option value="approved" <?= $sr['status'] === 'approved' ? 'selected' : '' ?>>Approved (Disetujui / Diserahkan)</option>
                                                                                <option value="rejected" <?= $sr['status'] === 'rejected' ? 'selected' : '' ?>>Rejected (Ditolak)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-semibold">Catatan Admin / Alasan Penolakan</label>
                                                                            <textarea name="admin_note" class="form-control" rows="2" placeholder="Catatan pengambilan barang atau alasan jika ditolak"><?= esc($sr['admin_note'] ?? '') ?></textarea>
                                                                            <small class="text-muted">Catatan ini akan dapat dilihat oleh pemohon pada dashboard mereka.</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 pt-0">
                                                                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada permohonan supplies.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- TAB 5: MANAJEMEN STOK SUPPLIES (MASTER BARANG) -->
            <!-- ============================================== -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-supplies" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-primary">
                                <i class="bi bi-box-seam me-2"></i>Master Inventaris Barang (Supplies)
                            </h5>
                            <small class="text-muted">Kelola data Nama Barang, Jumlah, Satuan, Stock, dan Batas Minimum Stok.</small>
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddSupply">
                            + Tambah Barang Baru
                        </button>
                    </div>

                    <div class="card-body pt-0 table-responsive table-responsive-scroll">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
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
                                                    <form method="post" action="/dashboard/supplies/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Master Barang ATK" data-swal-text="Apakah Anda yakin ingin menghapus barang <?= esc($sup['item_name']) ?>?">
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

            <!-- ============================================== -->
            <!-- TAB 6: VERIFIKASI CEPAT STATUS PERMOHONAN -->
            <!-- ============================================== -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-verifikasi" role="tabpanel">
                <!-- Summary Banner Verifikasi -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white" style="background: linear-gradient(135deg, #0a3a66 0%, #1e5a8a 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <h4 class="fw-bold mb-1">
                                    <i class="bi bi-shield-check me-2"></i>Pusat Verifikasi & Approval Pengajuan
                                </h4>
                                <p class="mb-0 text-white-50 small">
                                    Admin wajib menyetujui (Approve) atau menolak (Decline) setiap permohonan peminjaman dan request dari user. Status dan catatan admin akan langsung muncul di dashboard pemohon.
                                </p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge bg-white text-dark px-3 py-2 rounded-pill fs-6">
                                    <i class="bi bi-clock-history text-warning me-1"></i>Total Menunggu: <strong><?= $totalPendingCount ?? 0 ?></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row g-2 mt-3 pt-3 border-top border-white border-opacity-25">
                            <div class="col-6 col-md-3">
                                <small class="text-white-50 d-block">Ruangan Pending</small>
                                <strong class="fs-5 text-white"><?= count($pendingRooms ?? []) ?> Pengajuan</strong>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-white-50 d-block">Kendaraan Pending</small>
                                <strong class="fs-5 text-white"><?= count($pendingVehicles ?? []) ?> Pengajuan</strong>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-white-50 d-block">Maintenance Pending</small>
                                <strong class="fs-5 text-white"><?= count($pendingMaintenance ?? []) ?> Laporan</strong>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-white-50 d-block">Supplies Pending</small>
                                <strong class="fs-5 text-white"><?= count($pendingSupplies ?? []) ?> Permohonan</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub-Tabs Navigasi Verifikasi (Anti-Scroll Panjang) -->
                <ul class="nav nav-pills custom-subtabs gap-2 mb-3" id="verifikasiSubTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="sub-verif-rooms-tab" data-bs-toggle="pill" data-bs-target="#sub-verif-rooms" type="button" role="tab">
                            <i class="bi bi-door-open me-1 text-success"></i>Ruangan 
                            <span class="badge bg-success ms-1"><?= count($pendingRooms ?? []) ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sub-verif-vehicles-tab" data-bs-toggle="pill" data-bs-target="#sub-verif-vehicles" type="button" role="tab">
                            <i class="bi bi-car-front me-1 text-primary"></i>Kendaraan 
                            <span class="badge bg-primary ms-1"><?= count($pendingVehicles ?? []) ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sub-verif-maintenance-tab" data-bs-toggle="pill" data-bs-target="#sub-verif-maintenance" type="button" role="tab">
                            <i class="bi bi-tools me-1 text-warning"></i>Maintenance 
                            <span class="badge bg-warning text-dark ms-1"><?= count($pendingMaintenance ?? []) ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sub-verif-supplies-tab" data-bs-toggle="pill" data-bs-target="#sub-verif-supplies" type="button" role="tab">
                            <i class="bi bi-box-seam me-1 text-danger"></i>Supplies (ATK) 
                            <span class="badge bg-danger ms-1"><?= count($pendingSupplies ?? []) ?></span>
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="verifikasiSubTabContent">
                    <!-- SUB-PANE 1: RUANGAN -->
                    <div class="tab-pane fade show active" id="sub-verif-rooms" role="tabpanel">
                        <!-- 1. Ruangan Quick Verification -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <h5 class="fw-bold mb-0 text-success"><i class="bi bi-door-open me-2"></i>Verifikasi Peminjaman Ruangan</h5>
                                    <small class="text-muted">Persetujuan booking ruang rapat, auditorium, dan hall kampus.</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold"><?= count($pendingRooms ?? []) ?> Menunggu</span>
                                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill" onclick="document.getElementById('tab-peminjaman-btn').click();">Kelola Lengkap &rarr;</button>
                                </div>
                            </div>
                            <div class="card-body pt-0 table-responsive table-responsive-scroll">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>Peminjam & Unit</th>
                                    <th>Ruangan</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Jadwal Peminjaman</th>
                                    <th>Status Saat Ini</th>
                                    <th>Catatan Terakhir</th>
                                    <th class="text-center" style="min-width: 170px;">Aksi Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pendingRooms)): ?>
                                    <?php foreach ($pendingRooms as $r): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($r['booker_name']) ?></strong><br>
                                                <small class="badge bg-light text-dark border"><?= esc($r['department']) ?></small>
                                                <?php if (!empty($r['submitter_username'])): ?>
                                                    <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($r['submitter_user_name'] ?? $r['submitter_username']) ?> (@<?= esc($r['submitter_username']) ?>)</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong class="text-success"><?= esc($r['room_name'] ?? 'Ruang #' . $r['room_id']) ?></strong><br>
                                                <small class="text-muted">Kapasitas: <?= esc($r['capacity'] ?? '-') ?> org</small>
                                            </td>
                                            <td>
                                                <strong><?= esc($r['event_name']) ?></strong><br>
                                                <small class="text-muted">Setup: <?= esc($r['setup'] ?: 'Standar') ?></small>
                                            </td>
                                            <td>
                                                <span class="fw-semibold"><?= esc($r['booking_date']) ?></span><br>
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
                                            <td>
                                                <?php if ($r['status'] === 'rejected' && !empty($r['admin_note'])): ?>
                                                    <small class="text-danger fst-italic"><?= esc($r['admin_note']) ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-success fw-semibold px-2" 
                                                            onclick="openApproveModal('room_bookings', <?= $r['id'] ?>, 'Ruangan', '<?= esc(addslashes($r['room_name'] ?? ('Ruang #' . $r['room_id']))) ?>', '<?= esc(addslashes($r['booker_name'])) ?>');">
                                                        <i class="bi bi-check-lg me-1"></i>Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger fw-semibold px-2 ms-1" 
                                                            onclick="openRejectModal('room_bookings', <?= $r['id'] ?>, 'Ruangan', '<?= esc(addslashes($r['room_name'] ?? ('Ruang #' . $r['room_id']))) ?>', '<?= esc(addslashes($r['booker_name'])) ?>');">
                                                        <i class="bi bi-x-lg me-1"></i>Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="bi bi-check2-circle text-success fs-3 d-block mb-1"></i>
                                            Semua permohonan peminjaman ruangan telah diproses. Tidak ada antrian pending saat ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div> <!-- end sub-verif-rooms -->

                <!-- SUB-PANE 2: KENDARAAN -->
                <div class="tab-pane fade" id="sub-verif-vehicles" role="tabpanel">
                    <!-- 2. Kendaraan Quick Verification -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-car-front me-2"></i>Verifikasi Peminjaman Kendaraan</h5>
                                <small class="text-muted">Persetujuan peminjaman mobil dinas operasional dan bus kampus.</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold"><?= count($pendingVehicles ?? []) ?> Menunggu</span>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="document.getElementById('tab-peminjaman-btn').click();">Kelola Lengkap &rarr;</button>
                            </div>
                        </div>
                        <div class="card-body pt-0 table-responsive table-responsive-scroll">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                <tr>
                                    <th>Peminjam & Unit</th>
                                    <th>Kendaraan & Plat</th>
                                    <th>Tujuan & Deskripsi</th>
                                    <th>Jadwal (Hari & Jam)</th>
                                    <th>Driver</th>
                                    <th>Status</th>
                                    <th>Catatan Terakhir</th>
                                    <th class="text-center" style="min-width: 170px;">Aksi Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pendingVehicles)): ?>
                                    <?php foreach ($pendingVehicles as $v): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($v['booker_name']) ?></strong><br>
                                                <small class="badge bg-light text-dark border"><?= esc($v['department']) ?></small>
                                                <?php if (!empty($v['submitter_username'])): ?>
                                                    <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($v['submitter_user_name'] ?? $v['submitter_username']) ?> (@<?= esc($v['submitter_username']) ?>)</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong class="text-primary"><?= esc($v['vehicle_name'] ?? 'Kendaraan') ?></strong><br>
                                                <span class="badge bg-secondary"><?= esc($v['plate_number'] ?? '-') ?></span>
                                            </td>
                                            <td>
                                                <strong><?= esc($v['destination']) ?></strong><br>
                                                <small class="text-muted"><?= esc($v['description'] ?: '-') ?></small>
                                            </td>
                                            <td>
                                                <span class="fw-semibold"><?= esc($v['booking_date']) ?></span> (<?= esc($v['booking_day'] ?: '-') ?>)<br>
                                                <small class="text-muted"><?= esc($v['start_time']) ?> - <?= esc($v['end_time']) ?></small>
                                            </td>
                                            <td><?= esc($v['driver_name'] ?: 'Tanpa Driver') ?></td>
                                            <td>
                                                <?php if ($v['status'] === 'approved'): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php elseif ($v['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($v['status'] === 'rejected' && !empty($v['admin_note'])): ?>
                                                    <small class="text-danger fst-italic"><?= esc($v['admin_note']) ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-success fw-semibold px-2" 
                                                            onclick="openApproveModal('vehicle_bookings', <?= $v['id'] ?>, 'Kendaraan', '<?= esc(addslashes($v['vehicle_name'] ?? 'Mobil Dinas')) ?> - Tujuan <?= esc(addslashes($v['destination'])) ?>', '<?= esc(addslashes($v['booker_name'])) ?>');">
                                                        <i class="bi bi-check-lg me-1"></i>Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger fw-semibold px-2 ms-1" 
                                                            onclick="openRejectModal('vehicle_bookings', <?= $v['id'] ?>, 'Kendaraan', '<?= esc(addslashes($v['vehicle_name'] ?? 'Mobil Dinas')) ?> - Tujuan <?= esc(addslashes($v['destination'])) ?>', '<?= esc(addslashes($v['booker_name'])) ?>');">
                                                        <i class="bi bi-x-lg me-1"></i>Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="bi bi-check2-circle text-primary fs-3 d-block mb-1"></i>
                                            Semua permohonan peminjaman kendaraan telah diproses. Tidak ada antrian pending saat ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div> <!-- end sub-verif-vehicles -->

                <!-- SUB-PANE 3: MAINTENANCE -->
                <div class="tab-pane fade" id="sub-verif-maintenance" role="tabpanel">
                    <!-- 3. Maintenance Quick Verification -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h5 class="fw-bold mb-0 text-warning text-dark"><i class="bi bi-tools me-2"></i>Verifikasi Laporan Maintenance (Perbaikan Fasilitas)</h5>
                                <small class="text-muted">Persetujuan & tindak lanjut perbaikan fasilitas rusak (AC, Listrik, Air, IT, dsb).</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-warning bg-opacity-25 text-dark fw-bold"><?= count($pendingMaintenance ?? []) ?> Menunggu</span>
                                <button type="button" class="btn btn-sm btn-outline-warning rounded-pill text-dark" onclick="document.getElementById('tab-request-btn').click();">Kelola Lengkap &rarr;</button>
                            </div>
                        </div>
                        <div class="card-body pt-0 table-responsive table-responsive-scroll">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-user">Pelapor & Unit</th>
                                    <th class="col-w-item">Fasilitas & Lokasi</th>
                                    <th class="col-w-desc">Keterangan Kerusakan</th>
                                    <th class="col-w-date">Tanggal Lapor</th>
                                    <th class="col-w-status">Status Saat Ini</th>
                                    <th class="col-w-desc">Catatan Teknisi</th>
                                    <th class="col-w-action text-center">Aksi Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pendingMaintenance)): ?>
                                    <?php foreach ($pendingMaintenance as $m): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($m['requester_name']) ?></strong><br>
                                                <small class="badge bg-light text-dark border"><?= esc($m['department']) ?></small>
                                                <?php if (!empty($m['submitter_username'])): ?>
                                                    <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($m['submitter_user_name'] ?? $m['submitter_username']) ?> (@<?= esc($m['submitter_username']) ?>)</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?= esc($m['facility']) ?></span><br>
                                                <strong class="text-dark"><?= esc($m['location']) ?></strong>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?= esc($m['description']) ?></small>
                                            </td>
                                            <td>
                                                <?= esc(substr($m['created_at'] ?? '-', 0, 10)) ?>
                                            </td>
                                            <td>
                                                <?php if ($m['status'] === 'resolved' || $m['status'] === 'approved'): ?>
                                                    <span class="badge bg-success">Resolved</span>
                                                <?php elseif ($m['status'] === 'in_progress'): ?>
                                                    <span class="badge bg-info text-dark">In Progress</span>
                                                <?php elseif ($m['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($m['status'] === 'rejected' && !empty($m['admin_note'])): ?>
                                                    <small class="text-danger fst-italic"><?= esc($m['admin_note']) ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-success fw-semibold px-2" 
                                                            onclick="openApproveModal('maintenance_requests', <?= $m['id'] ?>, 'Maintenance', '<?= esc(addslashes($m['facility'])) ?> @ <?= esc(addslashes($m['location'])) ?>', '<?= esc(addslashes($m['requester_name'])) ?>');">
                                                        <i class="bi bi-check-lg me-1"></i>Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger fw-semibold px-2 ms-1" 
                                                            onclick="openRejectModal('maintenance_requests', <?= $m['id'] ?>, 'Maintenance', '<?= esc(addslashes($m['facility'])) ?> @ <?= esc(addslashes($m['location'])) ?>', '<?= esc(addslashes($m['requester_name'])) ?>');">
                                                        <i class="bi bi-x-lg me-1"></i>Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="bi bi-check2-circle text-warning fs-3 d-block mb-1"></i>
                                            Semua laporan maintenance perbaikan telah ditangani. Tidak ada antrian pending saat ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div> <!-- end sub-verif-maintenance -->

                <!-- SUB-PANE 4: SUPPLIES (ATK) -->
                <div class="tab-pane fade" id="sub-verif-supplies" role="tabpanel">
                    <!-- 4. Supplies (ATK) Quick Verification -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-box-seam me-2"></i>Verifikasi Permohonan Supplies (ATK)</h5>
                                <small class="text-muted">Persetujuan pengambilan barang habis pakai / alat tulis kantor.</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-danger bg-opacity-10 text-danger fw-bold"><?= count($pendingSupplies ?? []) ?> Menunggu</span>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="document.getElementById('tab-request-btn').click();">Kelola Lengkap &rarr;</button>
                            </div>
                        </div>
                        <div class="card-body pt-0 table-responsive table-responsive-scroll">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-user">Pemohon & Email</th>
                                    <th class="col-w-user">Unit Kerja</th>
                                    <th class="col-w-item">Nama Barang (ATK)</th>
                                    <th class="col-w-item">Jumlah Diminta</th>
                                    <th class="col-w-item">Stok Sarpras</th>
                                    <th class="col-w-date">Tanggal (Req / Butuh)</th>
                                    <th class="col-w-status">Status</th>
                                    <th class="col-w-desc">Catatan Terakhir</th>
                                    <th class="col-w-action text-center">Aksi Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pendingSupplies)): ?>
                                    <?php foreach ($pendingSupplies as $s): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($s['requester_name']) ?></strong><br>
                                                <small class="text-muted"><?= esc($s['email'] ?: '-') ?></small>
                                                <?php if (!empty($s['submitter_username'])): ?>
                                                    <br><small class="text-primary"><i class="bi bi-person-check me-1"></i>User: <?= esc($s['submitter_user_name'] ?? $s['submitter_username']) ?> (@<?= esc($s['submitter_username']) ?>)</small>
                                                <?php endif; ?>
                                            </td>
                                            <td><span class="badge bg-light text-dark border"><?= esc($s['department']) ?></span></td>
                                            <td>
                                                <strong><?= esc($s['item_name'] ?? 'Barang #' . $s['supply_id']) ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6"><?= esc($s['quantity']) ?> <?= esc($s['unit'] ?? 'Unit') ?></span>
                                            </td>
                                            <td>
                                                <?php 
                                                    $stk = (int)($s['stock'] ?? 0);
                                                    $reqQty = (int)($s['quantity'] ?? 1);
                                                ?>
                                                <?php if ($stk < $reqQty): ?>
                                                    <span class="badge bg-danger">Stok Kurang (<?= $stk ?> <?= esc($s['unit'] ?? '') ?>)</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Tersedia (<?= $stk ?> <?= esc($s['unit'] ?? '') ?>)</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">Req: <?= esc($s['date_requested']) ?></small><br>
                                                <small class="text-danger fw-semibold">Butuh: <?= esc($s['date_needed']) ?></small>
                                            </td>
                                            <td>
                                                <?php if ($s['status'] === 'approved'): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php elseif ($s['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($s['status'] === 'rejected' && !empty($s['admin_note'])): ?>
                                                    <small class="text-danger fst-italic"><?= esc($s['admin_note']) ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-success fw-semibold px-2" 
                                                            onclick="openApproveModal('supply_requests', <?= $s['id'] ?>, 'Supplies (ATK)', '<?= esc(addslashes($s['item_name'] ?? 'Barang ATK')) ?> (<?= esc($s['quantity']) ?> <?= esc($s['unit'] ?? '') ?>)', '<?= esc(addslashes($s['requester_name'])) ?>');">
                                                        <i class="bi bi-check-lg me-1"></i>Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger fw-semibold px-2 ms-1" 
                                                            onclick="openRejectModal('supply_requests', <?= $s['id'] ?>, 'Supplies (ATK)', '<?= esc(addslashes($s['item_name'] ?? 'Barang ATK')) ?> (<?= esc($s['quantity']) ?> <?= esc($s['unit'] ?? '') ?>)', '<?= esc(addslashes($s['requester_name'])) ?>');">
                                                        <i class="bi bi-x-lg me-1"></i>Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">
                                            <i class="bi bi-check2-circle text-danger fs-3 d-block mb-1"></i>
                                            Semua permohonan barang supplies ATK telah diproses. Tidak ada antrian pending saat ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div> <!-- end sub-verif-supplies -->
            </div> <!-- end verifikasiSubTabContent -->
            </div> <!-- end tab-verifikasi -->
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- TAB 7: SETTING MANAJEMEN USERS -->
            <!-- ============================================== -->
            <?php if (in_array($role, ['super_admin', 'admin'])): ?>
            <div class="tab-pane fade" id="tab-users" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill me-2" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                </svg>
                                <?= $role === 'super_admin' ? 'Pusat Manajemen Pengguna & Otoritas Sistem (Biro IT)' : 'Manajemen Pengguna: Dosen & Mahasiswa (Sarpras)' ?>
                            </h5>
                            <small class="text-muted">
                                <?= $role === 'super_admin' 
                                    ? 'Kelola penuh seluruh akun sistem: Super Admin (Biro IT), Admin (Sarpras), serta Mahasiswa & Dosen.' 
                                    : 'Kelola data akun pengguna civitas akademika (Dosen & Mahasiswa). Akun level Admin Sarpras & Super Admin Biro IT dikelola terpusat oleh Super Admin.' ?>
                            </small>
                        </div>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                            + <?= $role === 'super_admin' ? 'Tambah Pengguna Baru' : 'Tambah Mahasiswa / Dosen' ?>
                        </button>
                    </div>

                    <div class="card-body pt-0 table-responsive table-responsive-scroll">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-no">ID</th>
                                    <th class="col-w-user">Username</th>
                                    <th class="col-w-user">Nama Lengkap</th>
                                    <th class="col-w-item">Email</th>
                                    <th class="col-w-status">Level Akses</th>
                                    <th class="col-w-item">Department</th>
                                    <th class="col-w-status text-center">Status Akun</th>
                                    <th class="col-w-action text-center">Aksi</th>
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
                                                <?php if (!empty($u['is_suspended'])): ?>
                                                    <span class="badge bg-danger d-inline-flex align-items-center gap-1" title="<?= esc($u['suspend_reason'] ?? 'Pelanggaran / Spam') ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-slash-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.646-5.646a.5.5 0 1 0-.708.708l8 8a.5.5 0 0 0 .708-.708z"/></svg>
                                                        Suspended (Spam)
                                                    </span>
                                                    <?php if (!empty($u['suspend_reason'])): ?>
                                                        <div class="text-danger small mt-1" style="font-size: 0.70rem; max-width: 140px; margin: 0 auto; line-height: 1.1;">
                                                            <?= esc($u['suspend_reason']) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                                                        Aktif
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEditUser<?= $u['id'] ?>" title="Edit">
                                                        Edit
                                                    </button>

                                                    <?php if ((int)$u['id'] !== (int)session()->get('user_id')): ?>
                                                        <!-- TOMBOL SUSPEND / BUKA SUSPEND -->
                                                        <?php if (!empty($u['is_suspended'])): ?>
                                                            <?php if ($role === 'super_admin'): ?>
                                                                <!-- Buka Suspend (HANYA SUPER ADMIN) -->
                                                                <form method="post" action="/dashboard/users/unsuspend" class="d-inline ms-1 form-swal-delete" data-swal-title="Buka Status Suspend" data-swal-text="Apakah Anda yakin ingin membuka status suspend untuk pengguna <?= esc($u['name']) ?>?" data-swal-icon="question" data-swal-confirm-btn="<i class='bi bi-check-circle me-1'></i> Ya, Buka Suspend" data-swal-confirm-color="#16a34a">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                                    <button type="submit" class="btn btn-outline-success" title="Buka Suspend Akun">
                                                                        Buka
                                                                    </button>
                                                                </form>
                                                            <?php else: ?>
                                                                <!-- Admin Sarpras terkunci -->
                                                                <button type="button" class="btn btn-outline-secondary ms-1" disabled title="Hanya Super Admin yang berhak membuka suspend">
                                                                    Terkunci
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <!-- Akun aktif: bisa disuspend jika role user atau dilakukan oleh super_admin -->
                                                            <?php if ($u['role'] === 'user' || $role === 'super_admin'): ?>
                                                                <button type="button" class="btn btn-outline-warning text-dark ms-1" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#modalSuspendUser<?= $u['id'] ?>" 
                                                                        title="Tangguhkan Akun (Spam / Asal-asalan)">
                                                                    Suspend
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <form method="post" action="/dashboard/users/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Pengguna" data-swal-text="Apakah Anda yakin ingin menghapus user <?= esc($u['name']) ?>?">
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
                                                                <input type="email" name="email" class="form-control" value="<?= esc($u['email'] ?? '') ?>" placeholder="nama@student.upitra.ac.id / nama@upitra.ac.id">
                                                                <small class="text-muted" style="font-size: 0.72rem;">Format: @student.upitra.ac.id (Mahasiswa) atau @upitra.ac.id (Dosen/Staff)</small>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Role / Hak Akses</label>
                                                                    <?php if ($role === 'super_admin'): ?>
                                                                    <select name="role" class="form-select" required>
                                                                        <option value="user" <?= ($u['role'] === 'user') ? 'selected' : '' ?>>User (Mahasiswa / Dosen)</option>
                                                                        <option value="admin" <?= ($u['role'] === 'admin') ? 'selected' : '' ?>>Admin (Sarpras)</option>
                                                                        <option value="super_admin" <?= ($u['role'] === 'super_admin') ? 'selected' : '' ?>>Super Admin (Biro IT)</option>
                                                                    </select>
                                                                    <?php else: ?>
                                                                    <input type="text" class="form-control bg-light" value="User (Mahasiswa / Dosen)" readonly>
                                                                    <input type="hidden" name="role" value="user">
                                                                    <small class="text-muted" style="font-size: 0.72rem;">Admin hanya mengelola Dosen & Mahasiswa.</small>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">Department / Unit</label>
                                                                    <input type="text" name="department" class="form-control" value="<?= esc($u['department'] ?? '') ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">No. WhatsApp / HP</label>
                                                                    <input type="text" name="phone" class="form-control" value="<?= esc($u['phone'] ?? '') ?>" placeholder="08xxxxxxxxxx">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label fw-semibold">NIM / NIDN / NIP</label>
                                                                    <input type="text" name="identity_number" class="form-control" value="<?= esc($u['identity_number'] ?? '') ?>" placeholder="Nomor Induk">
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

                                        <!-- MODAL SUSPEND USER -->
                                        <div class="modal fade" id="modalSuspendUser<?= $u['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-danger">Tangguhkan Akun (Suspend Spammer)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="post" action="/dashboard/users/suspend">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning py-2 mb-3">
                                                                <small>
                                                                    <strong>Peringatan Sistem:</strong> Pengguna yang ditangguhkan tidak akan dapat login atau mengajukan sarpras apapun. Sesuai kebijakan, <em>status suspend ini HANYA dapat dibuka kembali oleh <strong>Super Admin (Biro IT)</strong></em>.
                                                                </small>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold text-muted small">Target Akun Pengguna</label>
                                                                <div class="p-2 bg-light rounded-3">
                                                                    <strong><?= esc($u['name']) ?></strong> (<?= esc($u['username']) ?>)<br>
                                                                    <span class="text-muted small"><?= esc($u['email'] ?? '-') ?> &bull; <?= esc($u['department'] ?? '-') ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Alasan Penangguhan / Suspend <span class="text-danger">*</span></label>
                                                                <textarea name="reason" class="form-control" rows="3" placeholder="Contoh: Menginput permohonan spam berulang kali / data fiktif / melanggar ketentuan sarpras" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Tangguhkan Akun</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data user.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB MASTER DATA: RUANGAN & KENDARAAN (SARPRAS) -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="tab-master-sarpras" role="tabpanel">
                <div class="row g-4 mb-4">
                    <!-- CARD MASTER RUANGAN -->
                    <div class="col-12 col-xl-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <h5 class="fw-bold mb-0 text-success d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-door-open-fill me-2" viewBox="0 0 16 16">
                                            <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H4.5A1.5 1.5 0 0 0 3 2.5V15zM10 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                        </svg>
                                        Master Data Ruangan
                                    </h5>
                                    <small class="text-muted">Kelola nama ruangan, kapasitas, lokasi gedung, dan status operasional.</small>
                                </div>
                                <button type="button" class="btn btn-success rounded-pill px-3 fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddRoom">
                                    + Tambah Ruangan
                                </button>
                            </div>
                            <div class="card-body pt-0 table-responsive table-responsive-scroll">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="col-w-no">No</th>
                                            <th>Nama Ruangan</th>
                                            <th>Kapasitas</th>
                                            <th>Lokasi / Gedung</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($roomsList)): ?>
                                            <?php $rNo = 1; foreach ($roomsList as $rm): ?>
                                                <tr>
                                                    <td><?= $rNo++ ?></td>
                                                    <td><strong><?= esc($rm['name'] ?? $rm['room_name']) ?></strong></td>
                                                    <td><span class="badge bg-light text-dark border"><?= esc($rm['capacity'] ?? 30) ?> Orang</span></td>
                                                    <td><small class="text-muted"><?= esc($rm['location'] ?? 'Gedung Utama') ?></small></td>
                                                    <td>
                                                        <?php if (($rm['status'] ?? 'active') === 'active'): ?>
                                                            <span class="badge bg-success">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark">Pemeliharaan</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm">
                                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditRoom<?= $rm['id'] ?>" title="Edit">
                                                                Edit
                                                            </button>
                                                            <form method="post" action="/dashboard/master/rooms/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Master Ruangan" data-swal-text="Apakah Anda yakin ingin menghapus data ruangan <?= esc($rm['name'] ?? $rm['room_name']) ?>?">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="id" value="<?= $rm['id'] ?>">
                                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- MODAL EDIT RUANGAN -->
                                                <div class="modal fade" id="modalEditRoom<?= $rm['id'] ?>" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow rounded-4">
                                                            <div class="modal-header border-0 pb-0">
                                                                <h5 class="modal-title fw-bold text-success">Edit Data Ruangan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form method="post" action="/dashboard/master/rooms/update">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="id" value="<?= $rm['id'] ?>">
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Nama Ruangan <span class="text-danger">*</span></label>
                                                                        <input type="text" name="room_name" class="form-control" value="<?= esc($rm['name'] ?? $rm['room_name']) ?>" required>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6 mb-3">
                                                                            <label class="form-label fw-semibold">Kapasitas (Orang) <span class="text-danger">*</span></label>
                                                                            <input type="number" name="capacity" class="form-control" value="<?= esc($rm['capacity'] ?? 30) ?>" min="1" required>
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label class="form-label fw-semibold">Status Operasional</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="active" <?= (($rm['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Aktif (Tersedia)</option>
                                                                                <option value="maintenance" <?= (($rm['status'] ?? 'active') === 'maintenance') ? 'selected' : '' ?>>Pemeliharaan / Perbaikan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Lokasi / Gedung / Lantai</label>
                                                                        <input type="text" name="location" class="form-control" value="<?= esc($rm['location'] ?? 'Gedung Utama') ?>" placeholder="Contoh: Gedung A - Lantai 2">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer border-0 pt-0">
                                                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data master ruangan.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- CARD MASTER MOBIL / KENDARAAN -->
                    <div class="col-12 col-xl-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <h5 class="fw-bold mb-0 text-primary d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-car-front-fill me-2" viewBox="0 0 16 16">
                                            <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1h-5v1A1.5 1.5 0 0 1 5 15h-1A1.5 1.5 0 0 1 2.5 13.5v-1.993A2.5 2.5 0 0 1 1.5 9.5v-.413c0-.166.017-.33.049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M4 7h8a.5.5 0 0 0 0-1H4a.5.5 0 0 0 0 1"/>
                                        </svg>
                                        Master Data Mobil & Kendaraan
                                    </h5>
                                    <small class="text-muted">Kelola armada mobil operasional, plat polisi, kapasitas, dan status armada.</small>
                                </div>
                                <button type="button" class="btn btn-primary rounded-pill px-3 fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddVehicle">
                                    + Tambah Mobil
                                </button>
                            </div>
                            <div class="card-body pt-0 table-responsive table-responsive-scroll">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="col-w-no">No</th>
                                            <th>Nama Kendaraan</th>
                                            <th>Plat Nomor</th>
                                            <th>Kapasitas</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($vehiclesList)): ?>
                                            <?php $vNo = 1; foreach ($vehiclesList as $vc): ?>
                                                <tr>
                                                    <td><?= $vNo++ ?></td>
                                                    <td><strong><?= esc($vc['name'] ?? $vc['vehicle_name']) ?></strong></td>
                                                    <td><span class="badge bg-dark font-monospace text-uppercase"><?= esc($vc['plate_number'] ?? '-') ?></span></td>
                                                    <td><span class="badge bg-light text-dark border"><?= esc($vc['capacity'] ?? 7) ?> Kursi</span></td>
                                                    <td>
                                                        <?php if (($vc['status'] ?? 'available') === 'available'): ?>
                                                            <span class="badge bg-success">Tersedia</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark">Perbaikan</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm">
                                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditVehicle<?= $vc['id'] ?>" title="Edit">
                                                                Edit
                                                            </button>
                                                            <form method="post" action="/dashboard/master/vehicles/delete" class="d-inline ms-1 form-swal-delete" data-swal-title="Hapus Master Kendaraan" data-swal-text="Apakah Anda yakin ingin menghapus data kendaraan <?= esc($vc['name'] ?? $vc['vehicle_name']) ?>?">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="id" value="<?= $vc['id'] ?>">
                                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- MODAL EDIT MOBIL -->
                                                <div class="modal fade" id="modalEditVehicle<?= $vc['id'] ?>" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow rounded-4">
                                                            <div class="modal-header border-0 pb-0">
                                                                <h5 class="modal-title fw-bold text-primary">Edit Data Mobil</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form method="post" action="/dashboard/master/vehicles/update">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="id" value="<?= $vc['id'] ?>">
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Nama Kendaraan / Tipe Mobil <span class="text-danger">*</span></label>
                                                                        <input type="text" name="vehicle_name" class="form-control" value="<?= esc($vc['name'] ?? $vc['vehicle_name']) ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Plat Nomor Polisi <span class="text-danger">*</span></label>
                                                                        <input type="text" name="plate_number" class="form-control text-uppercase" value="<?= esc($vc['plate_number'] ?? '') ?>" placeholder="Contoh: AD 1234 XY" required>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6 mb-3">
                                                                            <label class="form-label fw-semibold">Kapasitas (Penumpang) <span class="text-danger">*</span></label>
                                                                            <input type="number" name="capacity" class="form-control" value="<?= esc($vc['capacity'] ?? 7) ?>" min="1" required>
                                                                        </div>
                                                                        <div class="col-6 mb-3">
                                                                            <label class="form-label fw-semibold">Status Kesiapan</label>
                                                                            <select name="status" class="form-select">
                                                                                <option value="available" <?= (($vc['status'] ?? 'available') === 'available') ? 'selected' : '' ?>>Tersedia (Siap Operasi)</option>
                                                                                <option value="maintenance" <?= (($vc['status'] ?? 'available') === 'maintenance') ? 'selected' : '' ?>>Dalam Perbaikan / Bengkel</option>
                                                                            </select>
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
                                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data master kendaraan.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- TAB KHUSUS PENGGUNA: RUANGAN SAYA -->
            <!-- ============================================== -->
            <?php if ($role === 'user'): ?>
            <div class="tab-pane fade <?= ($role === 'user') ? 'show active' : '' ?>" id="tab-myrooms" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h4 class="fw-bold mb-1 text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-door-open me-2" viewBox="0 0 16 16">
                                        <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                                        <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                                    </svg>
                                    Peminjaman Ruangan Saya (<?= $pRooms ?> Aktif)
                                </h4>
                                <small class="text-muted">Daftar permohonan peminjaman ruangan yang telah Anda ajukan.</small>
                            </div>
                            <a href="/peminjaman/ruangan" class="btn btn-success rounded-pill px-4 fw-bold">
                                + Pinjam Ruangan Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0 table-responsive table-responsive-scroll">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-no">No</th>
                                    <th class="col-w-user">Penginput / Peminjam</th>
                                    <th class="col-w-item">Ruangan</th>
                                    <th class="col-w-date">Tanggal & Waktu</th>
                                    <th class="col-w-desc">Kegiatan & Fasilitas</th>
                                    <th class="col-w-status">Status</th>
                                    <th class="col-w-action text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($myRoomBookings)): ?>
                                    <?php $no = 1; foreach ($myRoomBookings as $rb): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= esc($rb['booker_name'] ?? $userName) ?></strong><br>
                                                <small class="text-muted"><i class="bi bi-building me-1"></i><?= esc($rb['department'] ?? ($userDept ?? '-')) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= esc($rb['room_name'] ?? 'Ruangan #' . $rb['room_id']) ?></strong><br>
                                                <small class="text-muted">Kapasitas: <?= esc($rb['capacity'] ?? '-') ?> org</small>
                                            </td>
                                            <td>
                                                <span class="fw-semibold"><?= esc($rb['booking_date']) ?></span><br>
                                                <small class="text-muted"><?= esc($rb['start_time']) ?> - <?= esc($rb['end_time']) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= esc($rb['event_name']) ?></strong><br>
                                                <small class="text-muted">Setup: <?= esc($rb['setup'] ?: 'Standar') ?></small>
                                                <?php if (!empty($rb['material_needed'])): ?>
                                                    <br><small class="text-muted"><i class="bi bi-box me-1"></i><?= esc($rb['material_needed']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($rb['status'] === 'approved'): ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Disetujui</span>
                                                <?php elseif ($rb['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Konfirmasi</span>
                                                <?php endif; ?>
                                                <?php if ($rb['status'] === 'rejected' && !empty($rb['admin_note'])): ?>
                                                    <div class="mt-1 small text-danger p-1 px-2 rounded bg-danger bg-opacity-10 border border-danger border-opacity-25" style="max-width: 250px;">
                                                        <i class="bi bi-exclamation-circle me-1"></i><strong>Alasan Ditolak:</strong> <?= esc($rb['admin_note']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($rb['status'] === 'pending'): ?>
                                                    <form method="post" action="/dashboard/my-request/cancel" class="form-swal-delete" data-swal-title="Batalkan Booking Ruangan" data-swal-text="Batalkan permohonan booking ruangan ini?" data-swal-confirm-btn="<i class='bi bi-x-circle me-1'></i> Ya, Batalkan">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="type" value="room">
                                                        <input type="hidden" name="id" value="<?= $rb['id'] ?>">
                                                        <input type="hidden" name="redirect_tab" value="myrooms">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Anda belum pernah mengajukan peminjaman ruangan.<br>
                                            <a href="/peminjaman/ruangan" class="btn btn-success btn-sm rounded-pill mt-2">+ Ajukan Peminjaman Sekarang</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB KHUSUS PENGGUNA: KENDARAAN SAYA -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="tab-myvehicles" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h4 class="fw-bold mb-1 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-car-front me-2" viewBox="0 0 16 16">
                                        <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.81h7.194a.51.51 0 0 0 .497-.81l-.956-1.913A1 1 0 0 0 10.244 3.75H5.756a1 1 0 0 0-.894.526M2.52 3.515A2 2 0 0 1 4.309 2.5h7.382a2 2 0 0 1 1.79 1.015l1.096 2.193A1.5 1.5 0 0 1 15 6.837V12.5a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5V12H5v.5A1.5 1.5 0 0 1 3.5 14h-1A1.5 1.5 0 0 1 1 12.5V6.837a1.5 1.5 0 0 1 .424-1.129zM2 7v5.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V11h8v1.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V7a.5.5 0 0 0-.5-.5H2.5a.5.5 0 0 0-.5.5"/>
                                    </svg>
                                    Peminjaman Kendaraan Saya (<?= $pVehicles ?> Aktif)
                                </h4>
                                <small class="text-muted">Daftar permohonan peminjaman kendaraan dinas yang Anda ajukan.</small>
                            </div>
                            <a href="/peminjaman/kendaraan" class="btn btn-primary rounded-pill px-4 fw-bold">
                                + Pinjam Kendaraan Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0 table-responsive table-responsive-scroll">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-no">No</th>
                                    <th class="col-w-user">Penginput / Peminjam</th>
                                    <th class="col-w-item">Mobil Dinas</th>
                                    <th class="col-w-date">Tanggal & Hari</th>
                                    <th class="col-w-time">Tujuan & Jam</th>
                                    <th class="col-w-desc">Keperluan</th>
                                    <th class="col-w-status">Status</th>
                                    <th class="col-w-action text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($myVehicleBookings)): ?>
                                    <?php $no = 1; foreach ($myVehicleBookings as $vb): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= esc($vb['booker_name'] ?? $userName) ?></strong><br>
                                                <small class="text-muted"><i class="bi bi-building me-1"></i><?= esc($vb['department'] ?? ($userDept ?? '-')) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= esc($vb['vehicle_name'] ?? 'Kendaraan #' . $vb['vehicle_id']) ?></strong><br>
                                                <span class="badge bg-secondary"><?= esc($vb['plate_number'] ?? '-') ?></span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold"><?= esc($vb['booking_date']) ?></span><br>
                                                <small class="text-muted"><?= esc($vb['booking_day'] ?: '-') ?></small>
                                            </td>
                                            <td>
                                                <strong><?= esc($vb['destination']) ?></strong><br>
                                                <small class="text-muted"><?= esc($vb['start_time']) ?> - <?= esc($vb['end_time']) ?></small>
                                            </td>
                                            <td>
                                                <small><?= esc($vb['description'] ?: '-') ?></small>
                                                <?php if (!empty($vb['driver_name'])): ?>
                                                    <br><small class="text-muted"><i class="bi bi-person me-1"></i>Driver: <?= esc($vb['driver_name']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($vb['status'] === 'approved'): ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Disetujui</span>
                                                <?php elseif ($vb['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Konfirmasi</span>
                                                <?php endif; ?>
                                                <?php if ($vb['status'] === 'rejected' && !empty($vb['admin_note'])): ?>
                                                    <div class="mt-1 small text-danger p-1 px-2 rounded bg-danger bg-opacity-10 border border-danger border-opacity-25" style="max-width: 250px;">
                                                        <i class="bi bi-exclamation-circle me-1"></i><strong>Alasan Ditolak:</strong> <?= esc($vb['admin_note']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($vb['status'] === 'pending'): ?>
                                                    <form method="post" action="/dashboard/my-request/cancel" class="form-swal-delete" data-swal-title="Batalkan Booking Kendaraan" data-swal-text="Batalkan permohonan booking kendaraan ini?" data-swal-confirm-btn="<i class='bi bi-x-circle me-1'></i> Ya, Batalkan">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="type" value="vehicle">
                                                        <input type="hidden" name="id" value="<?= $vb['id'] ?>">
                                                        <input type="hidden" name="redirect_tab" value="myvehicles">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            Anda belum pernah mengajukan peminjaman kendaraan.<br>
                                            <a href="/peminjaman/kendaraan" class="btn btn-primary btn-sm rounded-pill mt-2">+ Ajukan Peminjaman Kendaraan</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB KHUSUS PENGGUNA: MAINTENANCE SAYA -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="tab-mymaintenance" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h4 class="fw-bold mb-1 text-warning text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-tools me-2" viewBox="0 0 16 16">
                                        <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.969-.969 2.676-2.675a1 1 0 0 1 .707-.293h.07a1 1 0 0 0 .815-.419L16 1 15 0 11.919 2.2a1 1 0 0 0-.419.815v.07a1 1 0 0 1-.293.708L8.532 6.468 6.468 4.404l2.675-2.676a1 1 0 0 1 .708-.293h.07a1 1 0 0 0 .815-.419z"/>
                                    </svg>
                                    Request Maintenance Saya (<?= $pMaintenance ?> Aktif)
                                </h4>
                                <small class="text-muted">Pantau status pengerjaan laporan perbaikan fasilitas kampus Anda.</small>
                            </div>
                            <a href="/request/maintenance" class="btn btn-warning rounded-pill px-4 fw-bold">
                                + Lapor Perbaikan Fasilitas
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0 table-responsive table-responsive-scroll">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-no">No</th>
                                    <th class="col-w-user">Penginput / Pelapor</th>
                                    <th class="col-w-item">Fasilitas & Lokasi</th>
                                    <th class="col-w-desc">Keterangan Kerusakan</th>
                                    <th class="col-w-date">Tanggal Lapor</th>
                                    <th class="col-w-status">Status Pengerjaan</th>
                                    <th class="col-w-action text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($myMaintenance)): ?>
                                    <?php $no = 1; foreach ($myMaintenance as $mt): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= esc($mt['requester_name'] ?? $userName) ?></strong><br>
                                                <small class="text-muted"><i class="bi bi-building me-1"></i><?= esc($mt['department'] ?? ($userDept ?? '-')) ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?= esc($mt['facility']) ?></span><br>
                                                <strong><?= esc($mt['location']) ?></strong>
                                            </td>
                                            <td>
                                                <small><?= esc($mt['description']) ?></small>
                                            </td>
                                            <td>
                                                <?= esc(substr($mt['created_at'] ?? '-', 0, 10)) ?>
                                            </td>
                                            <td>
                                                <?php if ($mt['status'] === 'resolved' || $mt['status'] === 'approved'): ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai / Disetujui</span>
                                                <?php elseif ($mt['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                                <?php elseif ($mt['status'] === 'in_progress'): ?>
                                                    <span class="badge bg-info text-dark"><i class="bi bi-arrow-repeat me-1"></i>Sedang Dikerjakan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Antrian</span>
                                                <?php endif; ?>
                                                <?php if ($mt['status'] === 'rejected' && !empty($mt['admin_note'])): ?>
                                                    <div class="mt-1 small text-danger p-1 px-2 rounded bg-danger bg-opacity-10 border border-danger border-opacity-25" style="max-width: 250px;">
                                                        <i class="bi bi-exclamation-circle me-1"></i><strong>Alasan Ditolak:</strong> <?= esc($mt['admin_note']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($mt['status'] === 'pending'): ?>
                                                    <form method="post" action="/dashboard/my-request/cancel" class="form-swal-delete" data-swal-title="Batalkan Permohonan Perbaikan" data-swal-text="Batalkan laporan perbaikan fasilitas ini?" data-swal-confirm-btn="<i class='bi bi-x-circle me-1'></i> Ya, Batalkan">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="type" value="maintenance">
                                                        <input type="hidden" name="id" value="<?= $mt['id'] ?>">
                                                        <input type="hidden" name="redirect_tab" value="mymaintenance">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Anda belum pernah mengajukan laporan maintenance perbaikan fasilitas.<br>
                                            <a href="/request/maintenance" class="btn btn-warning btn-sm rounded-pill mt-2">+ Buat Laporan Maintenance</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB KHUSUS PENGGUNA: SUPPLIES (ATK) SAYA -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="tab-mysupplies" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h4 class="fw-bold mb-1 text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-seam me-2" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                                    </svg>
                                    Permohonan Supplies (ATK) Saya (<?= $pSupplies ?> Aktif)
                                </h4>
                                <small class="text-muted">Daftar permohonan pengambilan barang/alat tulis kantor Anda.</small>
                            </div>
                            <a href="/request/supplies" class="btn btn-danger rounded-pill px-4 fw-bold">
                                + Request Barang ATK
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0 table-responsive table-responsive-scroll">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-no">No</th>
                                    <th class="col-w-user">Penginput / Pemohon</th>
                                    <th class="col-w-item">Nama Barang (ATK)</th>
                                    <th class="col-w-item">Jumlah Diminta</th>
                                    <th class="col-w-date">Tanggal Diajukan</th>
                                    <th class="col-w-date">Dibutuhkan Tanggal</th>
                                    <th class="col-w-status">Status</th>
                                    <th class="col-w-action text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($mySupplyRequests)): ?>
                                    <?php $no = 1; foreach ($mySupplyRequests as $sr): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= esc($sr['requester_name'] ?? $userName) ?></strong><br>
                                                <small class="text-muted"><i class="bi bi-building me-1"></i><?= esc($sr['department'] ?? ($userDept ?? '-')) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= esc($sr['item_name'] ?? 'Barang #' . $sr['supply_id']) ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6"><?= esc($sr['quantity']) ?> <?= esc($sr['unit'] ?? 'Unit') ?></span>
                                            </td>
                                            <td><?= esc($sr['date_requested']) ?></td>
                                            <td><?= esc($sr['date_needed']) ?></td>
                                            <td>
                                                <?php if ($sr['status'] === 'approved'): ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Disetujui</span>
                                                <?php elseif ($sr['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Konfirmasi</span>
                                                <?php endif; ?>
                                                <?php if ($sr['status'] === 'rejected' && !empty($sr['admin_note'])): ?>
                                                    <div class="mt-1 small text-danger p-1 px-2 rounded bg-danger bg-opacity-10 border border-danger border-opacity-25" style="max-width: 250px;">
                                                        <i class="bi bi-exclamation-circle me-1"></i><strong>Alasan Ditolak:</strong> <?= esc($sr['admin_note']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($sr['status'] === 'pending'): ?>
                                                    <form method="post" action="/dashboard/my-request/cancel" class="form-swal-delete" data-swal-title="Batalkan Permohonan ATK" data-swal-text="Batalkan permohonan barang persediaan ini?" data-swal-confirm-btn="<i class='bi bi-x-circle me-1'></i> Ya, Batalkan">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="type" value="supplies">
                                                        <input type="hidden" name="id" value="<?= $sr['id'] ?>">
                                                        <input type="hidden" name="redirect_tab" value="mysupplies">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            Anda belum pernah mengajukan permohonan barang supplies ATK.<br>
                                            <a href="/request/supplies" class="btn btn-danger btn-sm rounded-pill mt-2">+ Ajukan Permohonan ATK</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB KHUSUS PENGGUNA: SEMUA RIWAYAT PENGAJUAN -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="tab-myrequests" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div>
                                <h4 class="fw-bold mb-1 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-clock-history me-2" viewBox="0 0 16 16">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .79.522l-.492.871zM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-1 0a7 7 0 1 0-14 0 7 7 0 0 0 14 0m-6.5-4a.5.5 0 0 0-1 0v4.5a.5.5 0 0 0 .246.43l3 1.5a.5.5 0 1 0 .492-.868L8.5 8.243z"/>
                                    </svg>
                                    Riwayat Semua Pengajuan Saya (<?= $userStats['total_all'] ?? 0 ?>)
                                </h4>
                                <small class="text-muted">Seluruh arsip permohonan peminjaman ruangan, mobil dinas, maintenance, dan ATK Anda.</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 table-responsive table-responsive-scroll">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="col-w-type">Layanan</th>
                                    <th class="col-w-user">Penginput / Pemohon</th>
                                    <th class="col-w-desc">Keterangan / Detail</th>
                                    <th class="col-w-date">Tanggal Pengajuan</th>
                                    <th class="col-w-status">Status</th>
                                    <th class="col-w-action text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $listAll = !empty($allMyRequests) ? $allMyRequests : ($myRequests ?? []);
                                if (!empty($listAll)): 
                                ?>
                                    <?php foreach ($listAll as $req): ?>
                                        <tr>
                                            <td>
                                                <?php if ($req['type'] === 'Ruangan'): ?>
                                                    <span class="badge bg-success">Ruangan</span>
                                                <?php elseif ($req['type'] === 'Kendaraan'): ?>
                                                    <span class="badge bg-primary">Kendaraan</span>
                                                <?php elseif ($req['type'] === 'Maintenance'): ?>
                                                    <span class="badge bg-warning text-dark">Maintenance</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Supplies (ATK)</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= esc($req['submitter_name'] ?? $userName) ?></strong><br>
                                                <small class="text-muted"><i class="bi bi-building me-1"></i><?= esc($req['department'] ?? ($userDept ?? '-')) ?></small>
                                            </td>
                                            <td>
                                                <strong><?= esc($req['title']) ?></strong><br>
                                                <small class="text-muted"><?= esc($req['detail'] ?? '-') ?></small>
                                            </td>
                                            <td><?= esc($req['date'] ?? '-') ?></td>
                                            <td>
                                                <?php if ($req['status'] === 'approved' || $req['status'] === 'resolved'): ?>
                                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Disetujui / Selesai</span>
                                                <?php elseif ($req['status'] === 'rejected'): ?>
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                                <?php elseif ($req['status'] === 'in_progress'): ?>
                                                    <span class="badge bg-info text-dark"><i class="bi bi-arrow-repeat me-1"></i>Dalam Pengerjaan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Konfirmasi</span>
                                                <?php endif; ?>
                                                <?php if ($req['status'] === 'rejected' && !empty($req['admin_note'])): ?>
                                                    <div class="mt-1 small text-danger p-1 px-2 rounded bg-danger bg-opacity-10 border border-danger border-opacity-25" style="max-width: 250px;">
                                                        <i class="bi bi-exclamation-circle me-1"></i><strong>Alasan Ditolak:</strong> <?= esc($req['admin_note']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (($req['status'] ?? 'pending') === 'pending'): ?>
                                                    <?php 
                                                        $cancelType = 'room';
                                                        if ($req['type'] === 'Kendaraan') $cancelType = 'vehicle';
                                                        elseif ($req['type'] === 'Maintenance') $cancelType = 'maintenance';
                                                        elseif (stripos($req['type'], 'Supplies') !== false) $cancelType = 'supplies';
                                                    ?>
                                                    <form method="post" action="/dashboard/my-request/cancel" class="d-inline form-swal-delete" data-swal-title="Batalkan Pengajuan" data-swal-text="Apakah Anda yakin ingin membatalkan pengajuan ini?" data-swal-confirm-btn="<i class='bi bi-x-circle me-1'></i> Ya, Batalkan">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="type" value="<?= $cancelType ?>">
                                                        <input type="hidden" name="id" value="<?= $req['id'] ?>">
                                                        <input type="hidden" name="redirect_tab" value="myrequests">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat permohonan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================================== -->
            <!-- TAB BIODATA PROFIL (SEMUA LEVEL USER) -->
            <!-- ============================================== -->
            <div class="tab-pane fade" id="tab-biodata" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-primary d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-circle me-2" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>
                                Biodata & Profil Saya
                            </h5>
                            <small class="text-muted">Formulir sederhana untuk melengkapi data identitas dan kontak civitas akademika.</small>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 <?= $role === 'super_admin' ? 'bg-danger' : ($role === 'admin' ? 'bg-primary' : 'bg-success') ?>">
                            <?= $role === 'super_admin' ? 'Super Admin (Biro IT)' : ($role === 'admin' ? 'Admin Sarpras' : ($userType ?? 'Pengguna')) ?>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="/dashboard/profile/update">
                            <?= csrf_field() ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="<?= esc($myProfile['name'] ?? session()->get('user_name') ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Username <small class="text-muted">(Akun Login)</small></label>
                                    <input type="text" class="form-control bg-light" value="<?= esc($myProfile['username'] ?? session()->get('username') ?? '') ?>" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Universitas <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="<?= esc($myProfile['email'] ?? session()->get('email') ?? '') ?>" placeholder="nama@student.upitra.ac.id / nama@upitra.ac.id" required>
                                    <small class="text-muted" style="font-size: 0.72rem;">Format: @student.upitra.ac.id (Mahasiswa) atau @upitra.ac.id (Dosen/Staff)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor WhatsApp / HP</label>
                                    <input type="text" name="phone" class="form-control" value="<?= esc($myProfile['phone'] ?? '') ?>" placeholder="Contoh: 081234567890">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Program Studi / Fakultas / Unit Kerja</label>
                                    <input type="text" name="department" class="form-control" value="<?= esc($myProfile['department'] ?? session()->get('department') ?? '') ?>" placeholder="Contoh: S1 Informatika / Biro Sarpras">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold"><?= ($role === 'user') ? 'NIM / NIDN' : 'NIP / ID Karyawan' ?></label>
                                    <input type="text" name="identity_number" class="form-control" value="<?= esc($myProfile['identity_number'] ?? '') ?>" placeholder="Nomor Induk Mahasiswa atau Pegawai">
                                </div>

                                <div class="col-12 mt-4 pt-3 border-top">
                                    <h6 class="fw-bold mb-1 text-secondary">Ubah Password Akun (Opsional)</h6>
                                    <p class="text-muted small mb-3">Kosongkan kolom password di bawah jika Anda tidak ingin mengubah password akun.</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password Baru</label>
                                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirm" class="form-control" placeholder="Ulangi password baru">
                                </div>

                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold py-2 shadow-sm">
                                        Simpan Perubahan Biodata
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL TAMBAH: PELAPORAN (LOST & FOUND & VISITOR) -->
<!-- ============================================================== -->
<!-- 1. Modal Tambah Lost & Found -->
<div class="modal fade" id="modalAddLostFound" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Tambah Laporan Lost & Found</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/pelaporan/lost-found/create">
                <?= csrf_field() ?>
                <input type="hidden" name="redirect_tab" value="sub-lostfound">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Pelapor</label>
                        <input type="text" name="reporter_name" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Status Pelapor</label>
                            <input type="text" name="reporter_status" class="form-control" placeholder="Mahasiswa, Dosen, Tamu" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">No. Kontak / WA</label>
                            <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang yang Hilang / Ditemukan</label>
                        <input type="text" name="lost_item" class="form-control" placeholder="Contoh: Dompet Cokelat, Kunci Motor Honda" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Kejadian</label>
                            <input type="date" name="incident_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Waktu Kejadian</label>
                            <input type="time" name="incident_time" class="form-control" value="<?= date('H:i') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Laporan</label>
                        <select name="status" class="form-select">
                            <option value="reported" selected>Reported (Dilaporkan)</option>
                            <option value="found">Found (Barang Ditemukan)</option>
                            <option value="claimed">Claimed (Sudah Diambil)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">+ Simpan Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. Modal Tambah Visitor -->
<div class="modal fade" id="modalAddVisitor" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Tambah Kunjungan Tamu (Visitor)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/pelaporan/visitor/create">
                <?= csrf_field() ?>
                <input type="hidden" name="redirect_tab" value="sub-visitor">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Tamu / Pengunjung</label>
                        <input type="text" name="visitor_name" class="form-control" placeholder="Nama Lengkap Pengunjung" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Instansi / Perusahaan</label>
                            <input type="text" name="institution" class="form-control" placeholder="Asal Instansi / Umum" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">No. Kontak / HP</label>
                            <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tujuan / Keperluan Kunjungan</label>
                        <input type="text" name="purpose" class="form-control" placeholder="Contoh: Rapat Kerjasama, Pengantaran Dokumen" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pejabat / Host yang Dituju</label>
                        <input type="text" name="host_name" class="form-control" placeholder="Contoh: Biro IT, Rektorat, Warek I" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Waktu Check-In</label>
                            <input type="text" name="check_in" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Status Kunjungan</label>
                            <select name="status" class="form-select">
                                <option value="checked_in" selected>Checked In (Masih di Lokasi)</option>
                                <option value="checked_out">Checked Out (Sudah Keluar)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">+ Simpan Tamu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL TAMBAH: PEMINJAMAN (RUANGAN & KENDARAAN) -->
<!-- ============================================================== -->
<!-- 3. Modal Tambah Booking Ruangan -->
<div class="modal fade" id="modalAddRoomBooking" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success">Tambah Peminjaman Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/peminjaman/ruangan/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Ruangan</label>
                        <select name="room_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Ruangan --</option>
                            <?php foreach ($roomsList as $rm): ?>
                                <option value="<?= $rm['id'] ?>"><?= esc($rm['room_name']) ?> (Kapasitas: <?= esc($rm['capacity']) ?> orang)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Nama Peminjam</label>
                            <input type="text" name="booker_name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Department / Unit</label>
                            <select name="department" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Department --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept ?>"><?= $dept ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="booking_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label fw-semibold">Waktu Masuk</label>
                            <input type="time" name="start_time" class="form-control" value="08:00" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label fw-semibold">Waktu Keluar</label>
                            <input type="time" name="end_time" class="form-control" value="12:00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Event / Kegiatan</label>
                        <input type="text" name="event_name" class="form-control" placeholder="Contoh: Rapat Koordinasi Fakultas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Set UP Ruangan</label>
                        <input type="text" name="setup" class="form-control" placeholder="Classroom, U-Shape, Theater, Round Table">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Material Needed</label>
                            <input type="text" name="material_needed" class="form-control" placeholder="Proyektor, Mic Wireless, Whiteboard">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Special Request</label>
                            <input type="text" name="special_request" class="form-control" placeholder="Permintaan khusus lainnya">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Peminjaman</label>
                        <select name="status" class="form-select">
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">+ Booking Ruangan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 4. Modal Tambah Booking Kendaraan -->
<div class="modal fade" id="modalAddVehicleBooking" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Tambah Peminjaman Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/peminjaman/kendaraan/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Kendaraan</label>
                        <select name="vehicle_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kendaraan Dinas --</option>
                            <?php foreach ($vehiclesList as $vc): ?>
                                <option value="<?= $vc['id'] ?>"><?= esc($vc['vehicle_name']) ?> (<?= esc($vc['plate_number']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Nama Peminjam</label>
                            <input type="text" name="booker_name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Department / Unit</label>
                            <select name="department" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Department --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept ?>"><?= $dept ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Peminjaman</label>
                            <input type="date" name="booking_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Hari</label>
                            <input type="text" name="booking_day" class="form-control" placeholder="Senin / Selasa / dll">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Jam Masuk (Berangkat)</label>
                            <input type="time" name="start_time" class="form-control" value="08:00" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Jam Keluar (Kembali)</label>
                            <input type="time" name="end_time" class="form-control" value="17:00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tujuan Perjalanan</label>
                        <input type="text" name="destination" class="form-control" placeholder="Contoh: Kantor Dikti, Bandara Adi Soemarmo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan / Keperluan</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Keperluan dinas"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Nama Driver</label>
                            <input type="text" name="driver_name" class="form-control" placeholder="Nama Supir">
                        </div>
                        <div class="col-3 mb-3">
                            <label class="form-label fw-semibold">KM In</label>
                            <input type="number" name="km_in" class="form-control" placeholder="0">
                        </div>
                        <div class="col-3 mb-3">
                            <label class="form-label fw-semibold">KM Out</label>
                            <input type="number" name="km_out" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Peminjaman</label>
                        <select name="status" class="form-select">
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">+ Booking Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL TAMBAH: REQUEST (MAINTENANCE & SUPPLIES) -->
<!-- ============================================================== -->
<!-- 5. Modal Tambah Request Maintenance -->
<div class="modal fade" id="modalAddMaintenance" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-warning text-dark">Tambah Request Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/request/maintenance/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Nama Pemohon</label>
                            <input type="text" name="requester_name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Department / Unit</label>
                            <select name="department" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Department --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept ?>"><?= $dept ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Fasilitas Rusak</label>
                            <select name="facility" class="form-select" required>
                                <option value="Lampu">Lampu</option>
                                <option value="AC">AC</option>
                                <option value="Air">Air</option>
                                <option value="Komputer/Jaringan">Komputer / Jaringan IT</option>
                                <option value="Other">Other (Lainnya)</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Lokasi Kerusakan</label>
                            <input type="text" name="location" class="form-control" placeholder="Contoh: Gedung B Lt. 2 Ruang 203" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan / Rincian Kerusakan</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan kondisi kerusakan fasilitas" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Penanganan</label>
                        <select name="status" class="form-select">
                            <option value="pending" selected>Pending (Menunggu Antrian)</option>
                            <option value="in_progress">In Progress (Sedang Dikerjakan)</option>
                            <option value="resolved">Resolved (Selesai)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">+ Simpan Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 6. Modal Tambah Permohonan Supplies Request -->
<div class="modal fade" id="modalAddSupplyRequest" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">Tambah Permohonan Supplies (ATK)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/request/supplies/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Nama Pemohon</label>
                            <input type="text" name="requester_name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Email Pemohon</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@student.upitra.ac.id (Mhs) / nama@upitra.ac.id (Dosen)">
                        <small class="text-muted" style="font-size: 0.75rem;">Format resmi: Mahasiswa (nama@student.upitra.ac.id), Dosen / Staff (nama@upitra.ac.id)</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department / Unit Kerja</label>
                        <select name="department" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Department --</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept ?>"><?= $dept ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-8 mb-3">
                            <label class="form-label fw-semibold">Pilih Barang yang Diminta</label>
                            <select name="supply_id" class="form-select" required>
                                <option value="" disabled selected>-- Cari dan Pilih Barang --</option>
                                <?php foreach ($suppliesList as $s): ?>
                                    <option value="<?= $s['id'] ?>">
                                        <?= esc($s['item_name']) ?> (Stok: <?= esc($s['stock']) ?> <?= esc($s['unit']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label fw-semibold">Jumlah (Qty)</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Diajukan</label>
                            <input type="date" name="date_requested" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Dibutuhkan Tanggal</label>
                            <input type="date" name="date_needed" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">+ Kirim Permohonan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH BARANG (MASTER SUPPLIES) -->
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
                <h5 class="modal-title fw-bold text-danger"><?= $role === 'super_admin' ? 'Tambah Pengguna Baru (Biro IT)' : 'Tambah Akun Mahasiswa / Dosen' ?></h5>
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
                        <input type="email" name="email" class="form-control" placeholder="nama@student.upitra.ac.id (Mhs) / nama@upitra.ac.id (Dosen)">
                        <small class="text-muted" style="font-size: 0.75rem;">Format resmi: Mahasiswa (nama@student.upitra.ac.id), Dosen / Staff (nama@upitra.ac.id)</small>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Role / Level Akses</label>
                            <?php if ($role === 'super_admin'): ?>
                            <select name="role" class="form-select" required>
                                <option value="user" selected>User (Mahasiswa / Dosen)</option>
                                <option value="admin">Admin (Sarpras)</option>
                                <option value="super_admin">Super Admin (Biro IT)</option>
                            </select>
                            <?php else: ?>
                            <input type="text" class="form-control bg-light" value="User (Mahasiswa / Dosen)" readonly>
                            <input type="hidden" name="role" value="user">
                            <small class="text-muted" style="font-size: 0.72rem;">Admin hanya dapat menambah level Dosen & Mahasiswa.</small>
                            <?php endif; ?>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Department / Unit</label>
                            <input type="text" name="department" class="form-control" placeholder="Contoh: IT, SDM, Dosen">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">No. WhatsApp / HP</label>
                            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">NIM / NIDN / NIP</label>
                            <input type="text" name="identity_number" class="form-control" placeholder="Nomor Induk">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password akun" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">+ <?= $role === 'super_admin' ? 'Tambah User' : 'Tambah Pengguna' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH MASTER DATA RUANGAN -->
<!-- ============================================== -->
<div class="modal fade" id="modalAddRoom" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success">+ Tambah Data Ruangan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/master/rooms/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" name="room_name" class="form-control" placeholder="Contoh: Lab Komputer 3, Ruang Seminar B" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Kapasitas (Orang) <span class="text-danger">*</span></label>
                            <input type="number" name="capacity" class="form-control" value="30" min="1" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Status Operasional</label>
                            <select name="status" class="form-select">
                                <option value="active" selected>Aktif (Tersedia)</option>
                                <option value="maintenance">Pemeliharaan / Perbaikan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lokasi / Gedung / Lantai</label>
                        <input type="text" name="location" class="form-control" placeholder="Contoh: Gedung B - Lantai 3">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">+ Tambah Ruangan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH MASTER DATA MOBIL / KENDARAAN -->
<!-- ============================================== -->
<div class="modal fade" id="modalAddVehicle" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">+ Tambah Data Mobil Operasional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/master/vehicles/create">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kendaraan / Tipe Mobil <span class="text-danger">*</span></label>
                        <input type="text" name="vehicle_name" class="form-control" placeholder="Contoh: Toyota Avanza Silver, Toyota HiAce" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Plat Nomor Polisi <span class="text-danger">*</span></label>
                        <input type="text" name="plate_number" class="form-control text-uppercase" placeholder="Contoh: AD 1234 XY" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Kapasitas (Penumpang) <span class="text-danger">*</span></label>
                            <input type="number" name="capacity" class="form-control" value="7" min="1" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Status Kesiapan</label>
                            <select name="status" class="form-select">
                                <option value="available" selected>Tersedia (Siap Operasi)</option>
                                <option value="maintenance">Dalam Perbaikan / Bengkel</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">+ Tambah Mobil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.custom-nav-pills .nav-link {
    color: #1e293b !important;
    font-weight: 600;
    transition: all 0.2s ease;
}
.custom-nav-pills .nav-link:hover {
    background-color: #f1f5f9 !important;
    color: var(--primary-blue) !important;
}
.custom-nav-pills .nav-link.active {
    background-color: var(--primary-blue) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 10px rgba(10, 58, 102, 0.25);
}

/* Anti-Blink & Anti-Jitter untuk Seluruh Modal Dashboard */
body.modal-open,
body.modal-open .card,
body.modal-open .card:hover,
body.modal-open .table-responsive,
body.modal-open .table-responsive-scroll {
    transform: none !important;
    transition: none !important;
}
.modal {
    transform: none !important;
}
.modal-dialog {
    will-change: transform;
}
</style>

<!-- ============================================== -->
<!-- MODAL QUICK APPROVE & REJECT SYSTEM (ADMIN) -->
<!-- ============================================== -->
<?php if (in_array($role, ['super_admin', 'admin'])): ?>
<!-- MODAL QUICK APPROVE -->
<div class="modal fade" id="modalQuickApprove" tabindex="-1" aria-labelledby="modalQuickApproveLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-success text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="modalQuickApproveLabel">
                    <i class="bi bi-check-circle-fill me-2"></i>Setujui Pengajuan (Approve)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/update-status">
                <?= csrf_field() ?>
                <input type="hidden" name="table" id="approveTable">
                <input type="hidden" name="id" id="approveId">
                <input type="hidden" name="status" id="approveStatus" value="approved">
                <input type="hidden" name="redirect_tab" id="approveRedirect" value="verifikasi">
                <div class="modal-body p-4">
                    <div class="alert alert-success bg-success bg-opacity-10 border-0 rounded-3 mb-3">
                        <small class="text-success fw-bold text-uppercase d-block mb-1">Permohonan yang Disetujui:</small>
                        <strong id="approveItemInfo" class="text-dark fs-6">-</strong>
                    </div>
                    <div class="mb-3" id="approveStatusSelectWrapper" style="display: none;">
                        <label class="form-label fw-semibold">Pilih Status Penanganan</label>
                        <select id="approveStatusSelect" class="form-select" onchange="document.getElementById('approveStatus').value = this.value;">
                            <option value="resolved">Resolved (Selesai Dikerjakan)</option>
                            <option value="in_progress">In Progress (Sedang Dikerjakan)</option>
                            <option value="approved">Approved (Disetujui)</option>
                        </select>
                    </div>
                    <input type="hidden" name="admin_note" id="approveAdminNote" value="">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>Klik konfirmasi untuk menyetujui permohonan ini. Status permohonan akan otomatis diperbarui.</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                        <i class="bi bi-check2 me-1"></i>Konfirmasi Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL QUICK REJECT -->
<div class="modal fade" id="modalQuickReject" tabindex="-1" aria-labelledby="modalQuickRejectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-danger text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="modalQuickRejectLabel">
                    <i class="bi bi-x-circle-fill me-2"></i>Tolak Pengajuan (Decline)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/dashboard/update-status">
                <?= csrf_field() ?>
                <input type="hidden" name="table" id="rejectTable">
                <input type="hidden" name="id" id="rejectId">
                <input type="hidden" name="status" value="rejected">
                <input type="hidden" name="redirect_tab" id="rejectRedirect" value="verifikasi">
                <div class="modal-body p-4">
                    <div class="alert alert-danger bg-danger bg-opacity-10 border-0 rounded-3 mb-3">
                        <small class="text-danger fw-bold text-uppercase d-block mb-1">Permohonan yang Ditolak:</small>
                        <strong id="rejectItemInfo" class="text-dark fs-6">-</strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-danger">Alasan Penolakan (Wajib Diisi)</label>
                        <textarea name="admin_note" id="rejectAdminNote" class="form-control rounded-3" rows="3" placeholder="Contoh: Jadwal bentrok dengan acara Dies Natalis / Stok persediaan sedang habis / Silakan ajukan jadwal pengganti." required></textarea>
                        <small class="text-muted"><i class="bi bi-exclamation-triangle me-1"></i>Alasan penolakan ini akan langsung muncul di dashboard pemohon agar mereka memahami alasan penolakan.</small>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                        <i class="bi bi-x-lg me-1"></i>Tolak Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function openApproveModal(table, id, type, title, person, redirectTab) {
    if (!redirectTab) redirectTab = 'verifikasi';
    document.getElementById('approveTable').value = table;
    document.getElementById('approveId').value = id;
    document.getElementById('approveRedirect').value = redirectTab;
    document.getElementById('approveItemInfo').innerText = type + ': ' + title + ' (' + person + ')';
    document.getElementById('approveAdminNote').value = '';
    
    var statusSelectWrapper = document.getElementById('approveStatusSelectWrapper');
    if (table === 'maintenance_requests') {
        statusSelectWrapper.style.display = 'block';
        document.getElementById('approveStatus').value = document.getElementById('approveStatusSelect').value;
    } else {
        statusSelectWrapper.style.display = 'none';
        document.getElementById('approveStatus').value = 'approved';
    }
    
    var modalEl = document.getElementById('modalQuickApprove');
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

function openRejectModal(table, id, type, title, person, redirectTab) {
    if (!redirectTab) redirectTab = 'verifikasi';
    document.getElementById('rejectTable').value = table;
    document.getElementById('rejectId').value = id;
    document.getElementById('rejectRedirect').value = redirectTab;
    document.getElementById('rejectItemInfo').innerText = type + ': ' + title + ' (' + person + ')';
    document.getElementById('rejectAdminNote').value = '';
    
    var modalEl = document.getElementById('modalQuickReject');
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Teleportasi SELURUH elemen modal langsung ke document.body
    // Mencegah modal terkurung di dalam container table/card/transform/overflow yang menyebabkan efek ngeblink-blink
    document.querySelectorAll('.modal').forEach(function(modal) {
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
    });

    var role = <?= json_encode($role) ?>;
    var hash = window.location.hash;
    if (!hash && role === 'user') {
        var myRoomsBtn = document.getElementById('tab-myrooms-btn');
        if (myRoomsBtn) myRoomsBtn.click();
    }
    // Sinkronisasi tab & sub-tab dengan URL Hash di semua level (Super Admin, Admin, dan User)
    var hash = window.location.hash;
    if (hash) {
        if (hash === '#pelaporan' || hash === '#sub-lostfound' || hash === '#pelaporan-lostfound' || hash === '#lost-found') {
            var btn = document.getElementById('tab-pelaporan-btn');
            if (btn) btn.click();
            var subBtn = document.getElementById('sub-lostfound-tab');
            if (subBtn) subBtn.click();
        } else if (hash === '#pelaporan-visitor' || hash === '#sub-visitor' || hash === '#visitor' || hash === '#buku-tamu' || hash === '#buku_tamu') {
            var btn = document.getElementById('tab-pelaporan-btn');
            if (btn) btn.click();
            var subBtn = document.getElementById('sub-visitor-tab');
            if (subBtn) subBtn.click();
        } else if (hash === '#peminjaman' || hash === '#sub-room' || hash === '#peminjaman-ruangan' || hash === '#ruangan') {
            var btn = document.getElementById('tab-peminjaman-btn');
            if (btn) btn.click();
            var subBtn = document.getElementById('sub-ruangan-tab');
            if (subBtn) subBtn.click();
        } else if (hash === '#peminjaman-kendaraan' || hash === '#sub-kendaraan' || hash === '#kendaraan') {
            var btn = document.getElementById('tab-peminjaman-btn');
            if (btn) btn.click();
            var subBtn = document.getElementById('sub-kendaraan-tab');
            if (subBtn) subBtn.click();
        } else if (hash === '#request' || hash === '#sub-maint' || hash === '#request-maintenance' || hash === '#maintenance') {
            var btn = document.getElementById('tab-request-btn');
            if (btn) btn.click();
            var subBtn = document.getElementById('sub-maint-tab');
            if (subBtn) subBtn.click();
        } else if (hash === '#request-supplies' || hash === '#sub-supp' || hash === '#supplies-request' || hash === '#atk') {
            var btn = document.getElementById('tab-request-btn');
            if (btn) btn.click();
            var subBtn = document.getElementById('sub-supp-tab');
            if (subBtn) subBtn.click();
        } else if (hash === '#supplies') {
            var btn = document.getElementById('tab-supplies-btn');
            if (btn) btn.click();
        } else if (hash === '#users') {
            var btn = document.getElementById('tab-users-btn');
            if (btn) btn.click();
        } else if (hash === '#master-sarpras') {
            var btn = document.getElementById('tab-master-sarpras-btn');
            if (btn) btn.click();
        } else if (hash === '#biodata') {
            var btn = document.getElementById('tab-biodata-btn') || document.getElementById('tab-biodata-user-btn');
            if (btn) btn.click();
        } else if (hash === '#verifikasi') {
            var btn = document.getElementById('tab-verifikasi-btn');
            if (btn) btn.click();
        } else if (hash === '#myrooms') {
            var btn = document.getElementById('tab-myrooms-btn');
            if (btn) btn.click();
        } else if (hash === '#myvehicles') {
            var btn = document.getElementById('tab-myvehicles-btn');
            if (btn) btn.click();
        } else if (hash === '#mymaintenance') {
            var btn = document.getElementById('tab-mymaintenance-btn');
            if (btn) btn.click();
        } else if (hash === '#mysupplies') {
            var btn = document.getElementById('tab-mysupplies-btn');
            if (btn) btn.click();
        } else if (hash === '#myrequests') {
            var btn = document.getElementById('tab-myrequests-btn');
            if (btn) btn.click();
        }
    }

    // Perbarui URL hash secara halus tanpa reload saat user berpindah tab atau sub-tab
    document.addEventListener('shown.bs.tab', function(event) {
        var target = event.target;
        var hashTarget = target.getAttribute('data-bs-target') || target.getAttribute('href');
        if (hashTarget && hashTarget.startsWith('#')) {
            history.replaceState(null, null, hashTarget);
        }
    });
});
</script>

<!-- Library Chart.js untuk Visualisasi Grafik Bulanan -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var chartCanvas = document.getElementById('monthlyTrendsChart');
    if (chartCanvas) {
        var monthlyData = <?= json_encode($monthlyStats ?? []) ?>;
        var labels = monthlyData.labels || ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        var peminjaman = monthlyData.peminjaman || [0,0,0,0,0,0,0,0,0,0,0,0];
        var supplies = monthlyData.supplies || [0,0,0,0,0,0,0,0,0,0,0,0];
        var maintenance = monthlyData.maintenance || [0,0,0,0,0,0,0,0,0,0,0,0];

        var ctx = chartCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Peminjaman Fasilitas',
                        data: peminjaman,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Request ATK (Supplies)',
                        data: supplies,
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#dc2626',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Request Maintenance',
                        data: maintenance,
                        borderColor: '#d97706',
                        backgroundColor: 'rgba(217, 119, 6, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#d97706',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13, weight: '700' },
                        bodyFont: { size: 12 },
                        cornerRadius: 8,
                        boxPadding: 4,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            font: { size: 11, weight: '500' },
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            font: { size: 11 },
                            color: '#64748b'
                        },
                        grid: {
                            color: '#f1f5f9',
                        }
                    }
                }
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
