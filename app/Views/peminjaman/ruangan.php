<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Peminjaman Ruangan</h2>
        <p class="text-muted mb-0">Formulir reservasi ruang rapat dan aula pertemuan untuk kegiatan akademik/kemahasiswaan.</p>
    </div>
    <a href="<?= session()->get('isLoggedIn') ? '/dashboard' : '/' ?>" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; <?= session()->get('isLoggedIn') ? 'Kembali ke Dashboard' : 'Kembali ke Beranda' ?>
    </a>
</div>

<!-- Informasi Akun Terotentikasi -->
<div class="alert alert-primary bg-primary bg-opacity-10 border-0 rounded-3 d-flex align-items-center mb-4 shadow-sm" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-check text-primary me-2 flex-shrink-0" viewBox="0 0 16 16">
        <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.134a.47.47 0 0 0 .155.038.47.47 0 0 0 .155-.038q.113-.049.293-.134c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
        <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
    </svg>
    <div>
        Terotentikasi sebagai: <strong><?= esc(session()->get('user_name')) ?></strong> 
        <span class="badge bg-primary rounded-pill ms-2">Akun <?= esc(session()->get('role') === 'user' ? 'Mahasiswa / Dosen' : 'Civitas Akademika') ?></span>
    </div>
</div>

<?php if(session()->getFlashdata('message')): ?>
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

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <form method="post" action="/peminjaman/ruangan">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Tanggal Peminjaman <span class="text-danger">*</span></label>
                    <input type="date" name="booking_date" class="form-control" value="<?= old('booking_date') ?: date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Waktu Masuk <span class="text-danger">*</span></label>
                    <input type="time" name="start_time" class="form-control" value="<?= old('start_time') ?: '08:00' ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Waktu Keluar <span class="text-danger">*</span></label>
                    <input type="time" name="end_time" class="form-control" value="<?= old('end_time') ?: '12:00' ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Peminjam <span class="text-danger">*</span></label>
                    <input type="text" name="booker_name" class="form-control" placeholder="Nama Lengkap" value="<?= old('booker_name') ?: esc(session()->get('user_name')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Department / Program Studi <span class="text-danger">*</span></label>
                    <input type="text" name="department" class="form-control" placeholder="Contoh: IT, SDM, Mahasiswa Informatika" value="<?= old('department') ?: esc(session()->get('department')) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Ruangan <span class="text-danger">*</span></label>
                <select name="room_id" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Ruangan --</option>
                    <?php foreach($rooms as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= old('room_id') == $r['id'] ? 'selected' : '' ?>>
                            <?= esc($r['room_name']) ?> (Kapasitas: <?= esc($r['capacity']) ?> orang)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Event / Acara <span class="text-danger">*</span></label>
                <input type="text" name="event_name" class="form-control" placeholder="Nama / Judul Kegiatan" value="<?= old('event_name') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Set UP (Bentuk Ruangan) <span class="text-danger">*</span></label>
                <input type="text" name="setup" class="form-control" placeholder="Contoh: Class Room, U-Shape, Theater, Round Table" value="<?= old('setup') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Material Needed</label>
                <textarea name="material_needed" class="form-control" rows="2" placeholder="Barang yang dibutuhkan (contoh: Proyektor, Mic Wireless, Sound, Whiteboard)"><?= old('material_needed') ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Special Request</label>
                <textarea name="special_request" class="form-control" rows="2" placeholder="Permintaan khusus lainnya jika ada (Opsional)"><?= old('special_request') ?></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i> Permohonan akan diverifikasi oleh Tim Sarpras.
                </span>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill">
                    Submit Peminjaman Ruangan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- DAFTAR PENGAJUAN TERKINI (LIST SUBMIT) -->
<!-- ============================================== -->
<div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-header bg-white border-0 pt-4 px-4 px-md-5 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="fw-bold mb-1 text-primary">
                <i class="bi bi-card-checklist me-2"></i>Daftar Pengajuan Peminjaman Ruangan (List Submit)
            </h5>
            <small class="text-muted">Data reservasi ruangan yang telah Anda kirimkan lengkap dengan nama user yang menginput.</small>
        </div>
        <?php if (session()->get('isLoggedIn')): ?>
            <a href="/dashboard" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard Saya &rarr;
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body p-4 p-md-5 pt-3 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Penginput / Peminjam</th>
                    <th>Ruangan</th>
                    <th>Tanggal & Waktu</th>
                    <th>Nama Kegiatan</th>
                    <th>Status</th>
                    <th>Waktu Submit</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mySubmissions)): ?>
                    <?php $no = 1; foreach ($mySubmissions as $sub): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong class="text-dark"><i class="bi bi-person-fill text-primary me-1"></i><?= esc($sub['booker_name']) ?></strong><br>
                                <span class="badge bg-light text-dark border"><i class="bi bi-building me-1"></i><?= esc($sub['department']) ?></span>
                            </td>
                            <td>
                                <strong class="text-success"><?= esc($sub['room_name'] ?? 'Ruang #' . $sub['room_id']) ?></strong>
                            </td>
                            <td>
                                <span class="fw-semibold"><?= esc($sub['booking_date']) ?></span><br>
                                <small class="text-muted"><?= esc($sub['start_time']) ?> - <?= esc($sub['end_time']) ?></small>
                            </td>
                            <td>
                                <strong><?= esc($sub['event_name']) ?></strong><br>
                                <small class="text-muted">Setup: <?= esc($sub['setup'] ?: 'Standar') ?></small>
                            </td>
                            <td>
                                <?php if ($sub['status'] === 'approved'): ?>
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Disetujui</span>
                                <?php elseif ($sub['status'] === 'rejected'): ?>
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu Konfirmasi</span>
                                <?php endif; ?>
                                <?php if (!empty($sub['admin_note'])): ?>
                                    <div class="mt-1 small <?= $sub['status'] === 'rejected' ? 'text-danger' : 'text-success' ?> p-1 px-2 rounded <?= $sub['status'] === 'rejected' ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 border border-<?= $sub['status'] === 'rejected' ? 'danger' : 'success' ?> border-opacity-25" style="max-width: 250px;">
                                        <i class="bi <?= $sub['status'] === 'rejected' ? 'bi-exclamation-circle' : 'bi-chat-left-dots' ?> me-1"></i><strong><?= $sub['status'] === 'rejected' ? 'Alasan Ditolak' : 'Catatan Admin' ?>:</strong> <?= esc($sub['admin_note']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted"><?= esc($sub['created_at'] ?? '-') ?></small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>
                            Belum ada riwayat permohonan ruangan yang disubmit.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
