<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h2 class="fw-bold mb-0" style="color: var(--primary-blue);">Dashboard Portal Sarpras</h2>
            <?php if ($role === 'super_admin'): ?>
                <span class="badge bg-danger px-3 py-2 rounded-pill fs-6 shadow-sm">Super Admin (Biro IT)</span>
            <?php elseif ($role === 'admin'): ?>
                <span class="badge bg-primary px-3 py-2 rounded-pill fs-6 shadow-sm">Admin (Sarpras)</span>
            <?php else: ?>
                <span class="badge bg-success px-3 py-2 rounded-pill fs-6 shadow-sm">User (Mahasiswa & Dosen)</span>
            <?php endif; ?>
        </div>
        <p class="text-muted mb-0">
            Selamat datang, <strong><?= esc(session()->get('user_name') ?? 'Pengguna') ?></strong> 
            (<?= esc(session()->get('department') ?? 'Universitas Pignatelli Triputra') ?>)
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="/" class="btn btn-outline-primary fw-semibold rounded-pill px-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house me-1" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
            </svg>
            Halaman Utama
        </a>
        <a href="/logout" class="btn btn-outline-danger fw-semibold rounded-pill px-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right me-1" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 10 1H2a1.5 1.5 0 0 0-1.5 1.5v9A1.5 1.5 0 0 0 2 15h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-1.647 1.646a.5.5 0 0 0 .708.708z"/>
            </svg>
            Logout
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <span><?= session()->getFlashdata('message') ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ========================================== -->
<!-- 1. TAMPILAN ROLE: SUPER ADMIN (BIRO IT) -->
<!-- ========================================== -->
<?php if ($role === 'super_admin'): ?>
    <div class="alert alert-primary bg-primary bg-opacity-10 border-primary border-opacity-25 rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="p-2 bg-primary text-white rounded-3 me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cpu" viewBox="0 0 16 16">
                    <path d="M5 0a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2A2.5 2.5 0 0 1 14 4.5h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14A2.5 2.5 0 0 1 11.5 14v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14A2.5 2.5 0 0 1 2 11.5H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2A2.5 2.5 0 0 1 4.5 2V.5A.5.5 0 0 1 5 0m-.5 3A1.5 1.5 0 0 0 3 4.5v7A1.5 1.5 0 0 0 4.5 13h7a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 11.5 3zM5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5zM6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                </svg>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-primary">Konsol Manajemen Biro IT (Super Administrator)</h6>
                <small class="text-muted">Akses penuh terhadap kontrol akun, database, infrastruktur sistem, dan seluruh transaksi Sarpras.</small>
            </div>
        </div>
        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-shield-check me-1"></i>Sistem Berjalan Normal</span>
    </div>

    <!-- Ringkasan Statistik Global -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-danger">
                <div class="card-body">
                    <div class="text-muted small fw-semibold text-uppercase">Pengguna Terdaftar</div>
                    <h3 class="fw-bold my-1 text-danger"><?= esc($stats['users_count'] ?? 0) ?></h3>
                    <small class="text-muted">Akun Super Admin, Admin, & User</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <div class="text-muted small fw-semibold text-uppercase">Total Peminjaman</div>
                    <h3 class="fw-bold my-1 text-primary"><?= (int)($stats['room_bookings'] + $stats['vehicle_bookings']) ?></h3>
                    <small class="text-muted"><?= $stats['room_bookings'] ?> Ruang | <?= $stats['vehicle_bookings'] ?> Kendaraan</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <div class="text-muted small fw-semibold text-uppercase">Total Permintaan</div>
                    <h3 class="fw-bold my-1 text-warning"><?= (int)($stats['maintenance'] + $stats['supplies']) ?></h3>
                    <small class="text-muted"><?= $stats['maintenance'] ?> Maintenance | <?= $stats['supplies'] ?> ATK</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-info">
                <div class="card-body">
                    <div class="text-muted small fw-semibold text-uppercase">Laporan & Visitor</div>
                    <h3 class="fw-bold my-1 text-info"><?= (int)($stats['lost_found'] + $stats['visitors']) ?></h3>
                    <small class="text-muted"><?= $stats['lost_found'] ?> Barang Hilang | <?= $stats['visitors'] ?> Tamu</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Manajemen Akun Pengguna Sistem -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-people me-2"></i>Daftar Pengguna Sistem (Biro IT Auth)</h5>
            <span class="badge bg-secondary px-3 py-2 rounded-pill"><?= count($allUsers) ?> Pengguna</span>
        </div>
        <div class="card-body pt-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Role / Level</th>
                        <th>Department</th>
                        <th>Terdaftar</th>
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
                                        <span class="badge bg-success">User (Dosen / Mahasiswa)</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($u['department'] ?? '-') ?></td>
                                <td class="text-muted small"><?= esc($u['created_at'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Data pengguna belum termuat atau menggunakan akun fallback.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<!-- ========================================== -->
<!-- 2. TAMPILAN ROLE: ADMIN (SARPRAS) & SUPER ADMIN -->
<!-- ========================================== -->
<?php if (in_array($role, ['super_admin', 'admin'])): ?>
    <?php if ($role === 'admin'): ?>
        <!-- Ringkasan Statistik Sarpras -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm border-start border-4 border-success">
                    <div class="card-body">
                        <div class="text-muted small fw-semibold text-uppercase">Peminjaman Ruangan</div>
                        <h3 class="fw-bold my-1 text-success"><?= esc($stats['room_bookings'] ?? 0) ?></h3>
                        <small class="text-muted">Total Pengajuan Ruangan</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm border-start border-4 border-primary">
                    <div class="card-body">
                        <div class="text-muted small fw-semibold text-uppercase">Peminjaman Kendaraan</div>
                        <h3 class="fw-bold my-1 text-primary"><?= esc($stats['vehicle_bookings'] ?? 0) ?></h3>
                        <small class="text-muted">Total Pengajuan Kendaraan</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm border-start border-4 border-warning">
                    <div class="card-body">
                        <div class="text-muted small fw-semibold text-uppercase">Request Maintenance</div>
                        <h3 class="fw-bold my-1 text-warning"><?= esc($stats['maintenance'] ?? 0) ?></h3>
                        <small class="text-muted">Laporan Kerusakan Fasilitas</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm border-start border-4 border-danger">
                    <div class="card-body">
                        <div class="text-muted small fw-semibold text-uppercase">Request Supplies (ATK)</div>
                        <h3 class="fw-bold my-1 text-danger"><?= esc($stats['supplies'] ?? 0) ?></h3>
                        <small class="text-muted">Permintaan Barang & ATK</small>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <h4 class="fw-bold mb-3" style="color: var(--primary-blue);">Verifikasi & Persetujuan Pengajuan (Workflow Sarpras)</h4>

    <!-- Peminjaman Ruangan Table -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-success"><i class="bi bi-door-open me-2"></i>Pengajuan Peminjaman Ruangan</h5>
            <a href="/peminjaman/ruangan" class="btn btn-sm btn-outline-success rounded-pill">+ Form Ruangan</a>
        </div>
        <div class="card-body pt-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Acara</th>
                        <th>Tanggal & Jam</th>
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
                                            <button type="submit" class="btn btn-outline-success" title="Setujui">Setujui</button>
                                        </form>
                                        <form method="post" action="/dashboard/update-status" class="d-inline ms-1">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="table" value="room_bookings">
                                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-outline-danger" title="Tolak">Tolak</button>
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

    <!-- Peminjaman Kendaraan Table -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-car-front me-2"></i>Pengajuan Peminjaman Kendaraan</h5>
            <a href="/peminjaman/kendaraan" class="btn btn-sm btn-outline-primary rounded-pill">+ Form Kendaraan</a>
        </div>
        <div class="card-body pt-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Peminjam</th>
                        <th>Kendaraan</th>
                        <th>Tujuan</th>
                        <th>Tanggal & Jam</th>
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

    <!-- Maintenance & Supplies Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-warning"><i class="bi bi-tools me-2"></i>Request Maintenance Terbaru</h5>
                    <a href="/request/maintenance" class="btn btn-sm btn-outline-warning rounded-pill">+ Form</a>
                </div>
                <div class="card-body pt-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pelapor</th>
                                <th>Fasilitas & Lokasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pendingMaintenance)): ?>
                                <?php foreach ($pendingMaintenance as $m): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($m['requester_name']) ?></strong><br>
                                            <small class="text-muted"><?= esc($m['department']) ?></small>
                                        </td>
                                        <td>
                                            <strong><?= esc($m['facility']) ?></strong><br>
                                            <small class="text-muted"><?= esc($m['location']) ?></small>
                                        </td>
                                        <td>
                                            <?php if ($m['status'] === 'resolved'): ?>
                                                <span class="badge bg-success">Selesai</span>
                                            <?php elseif ($m['status'] === 'in_progress'): ?>
                                                <span class="badge bg-info text-dark">Proses</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form method="post" action="/dashboard/update-status" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="table" value="maintenance_requests">
                                                <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                                <input type="hidden" name="status" value="resolved">
                                                <button type="submit" class="btn btn-sm btn-outline-success">Selesaikan</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada request maintenance.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-box-seam me-2"></i>Request Supplies (ATK)</h5>
                    <a href="/request/supplies" class="btn btn-sm btn-outline-danger rounded-pill">+ Form</a>
                </div>
                <div class="card-body pt-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Peminta</th>
                                <th>Barang & Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pendingSupplies)): ?>
                                <?php foreach ($pendingSupplies as $s): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($s['requester_name']) ?></strong><br>
                                            <small class="text-muted"><?= esc($s['department']) ?></small>
                                        </td>
                                        <td>
                                            <strong><?= esc($s['item_name'] ?? 'Barang #' . $s['supply_id']) ?></strong><br>
                                            <small class="text-muted"><?= esc($s['quantity']) ?> <?= esc($s['unit'] ?? 'Pcs') ?></small>
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
                                            <form method="post" action="/dashboard/update-status" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="table" value="supply_requests">
                                                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-outline-success">Setujui</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada request ATK.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ========================================== -->
<!-- 3. TAMPILAN ROLE: USER (MAHASISWA & DOSEN) -->
<!-- ========================================== -->
<?php if ($role === 'user'): ?>
    <div class="row g-4 mb-4">
        <!-- Banner Layanan Pengguna -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3">Portal Sivitas Akademika</span>
                            <h3 class="fw-bold mb-2">Layanan Terpadu Sarana & Prasarana Kampus</h3>
                            <p class="mb-0 text-white-50 lead" style="font-size: 1.05rem;">
                                Ajukan peminjaman ruang kelas/auditorium, kendaraan dinas, perbaikan sarana, dan laporkan barang hilang secara mudah dan transparan.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <a href="#menu-layanan" class="btn btn-light fw-bold px-4 py-2 rounded-pill shadow-sm text-primary">Lihat Menu Layanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Cepat Pengajuan -->
        <div class="col-12" id="menu-layanan">
            <h4 class="fw-bold mb-3" style="color: var(--primary-blue);">Menu Pengajuan Cepat</h4>
            <div class="row g-3">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-3 hover-card">
                        <div class="card-body">
                            <div class="d-inline-flex p-3 bg-success bg-opacity-10 text-success rounded-circle mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                                    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                                    <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Pinjam Ruangan</h5>
                            <p class="text-muted small mb-3">Booking ruang meeting, auditorium, atau hall kampus.</p>
                            <a href="/peminjaman/ruangan" class="btn btn-outline-success rounded-pill w-100 fw-semibold">Ajukan Sekarang</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-3 hover-card">
                        <div class="card-body">
                            <div class="d-inline-flex p-3 bg-primary bg-opacity-10 text-primary rounded-circle mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                                    <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.315.38.396.904.43 1.348 1.444 1.348 2.457v5.612A1.5 1.5 0 0 1 14.5 15h-1a1.5 1.5 0 0 1-1.5-1.5V13H4v.5A1.5 1.5 0 0 1 2.5 15h-1A1.5 1.5 0 0 1 0 13.515V7.9c0-1.013.444-2.027 1.348-2.457.17-.081.305-.221.38-.396zM4.82 3a1.5 1.5 0 0 0-1.38 1.09l-.792 1.849a1.8 1.8 0 0 0-.148.675v5.612c0 .276.224.5.5.5h1a.5.5 0 0 0 .5-.5V12h8v.226a.5.5 0 0 0 .5.5h1c.276 0 .5-.224.5-.5V6.614c0-.233-.052-.464-.148-.675l-.792-1.849A1.5 1.5 0 0 0 11.18 3z"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Pinjam Kendaraan</h5>
                            <p class="text-muted small mb-3">Peminjaman mobil operasional untuk keperluan kampus.</p>
                            <a href="/peminjaman/kendaraan" class="btn btn-outline-primary rounded-pill w-100 fw-semibold">Ajukan Sekarang</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-3 hover-card">
                        <div class="card-body">
                            <div class="d-inline-flex p-3 bg-warning bg-opacity-10 text-warning rounded-circle mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                                    <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.969-.969L12.206 5.857a3.003 3.003 0 0 0 .851-5.878A3 3 0 0 0 10.153 3.824L7.5 6.478l-2.675-2.675a1 1 0 0 1-.293-.707V3.025a1 1 0 0 0-.419-.815zm1.5 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Request Maintenance</h5>
                            <p class="text-muted small mb-3">Laporkan fasilitas AC, lampu, atau kelistrikan yang rusak.</p>
                            <a href="/request/maintenance" class="btn btn-outline-warning rounded-pill w-100 fw-semibold">Lapor Kerusakan</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-3 hover-card">
                        <div class="card-body">
                            <div class="d-inline-flex p-3 bg-info bg-opacity-10 text-info rounded-circle mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold">Barang Hilang</h5>
                            <p class="text-muted small mb-3">Laporkan barang tertinggal atau hilang di kampus.</p>
                            <a href="/pelaporan/lost-found" class="btn btn-outline-info rounded-pill w-100 fw-semibold">Laporkan Barang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pengajuan Saya -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Status & Riwayat Pengajuan Anda</h5>
                </div>
                <div class="card-body pt-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Layanan</th>
                                <th>Keterangan / Detail</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status Terkini</th>
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
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Anda belum memiliki riwayat pengajuan peminjaman atau perbaikan.<br>
                                        <small>Gunakan tombol di atas untuk mengajukan permohonan baru ke Biro Sarpras.</small>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
.hover-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
}
</style>

<?= $this->endSection() ?>
