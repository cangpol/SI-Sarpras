<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Peminjaman Kendaraan</h2>
        <p class="text-muted mb-0">Formulir reservasi kendaraan dinas operasional untuk keperluan kedinasan/kegiatan universitas.</p>
    </div>
    <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; Kembali ke Beranda
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
        <form method="post" action="/peminjaman/kendaraan">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Tanggal Peminjaman <span class="text-danger">*</span></label>
                    <input type="date" name="booking_date" class="form-control" value="<?= old('booking_date') ?: date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Hari Peminjaman <span class="text-danger">*</span></label>
                    <input type="text" name="booking_day" class="form-control" placeholder="Contoh: Senin, Selasa" value="<?= old('booking_day') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Pilih Kendaraan <span class="text-danger">*</span></label>
                    <select name="vehicle_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Kendaraan Dinas --</option>
                        <?php foreach($vehicles as $v): ?>
                            <option value="<?= $v['id'] ?>" <?= old('vehicle_id') == $v['id'] ? 'selected' : '' ?>>
                                <?= esc($v['vehicle_name']) ?> (<?= esc($v['plate_number']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Masuk (Berangkat) <span class="text-danger">*</span></label>
                    <input type="time" name="start_time" class="form-control" value="<?= old('start_time') ?: '08:00' ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Keluar (Kembali) <span class="text-danger">*</span></label>
                    <input type="time" name="end_time" class="form-control" value="<?= old('end_time') ?: '17:00' ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Peminjam <span class="text-danger">*</span></label>
                    <input type="text" name="booker_name" class="form-control" placeholder="Nama Lengkap" value="<?= old('booker_name') ?: esc(session()->get('user_name')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Department / Bagian <span class="text-danger">*</span></label>
                    <input type="text" name="department" class="form-control" placeholder="Department / Bagian" value="<?= old('department') ?: esc(session()->get('department')) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Tujuan Perjalanan <span class="text-danger">*</span></label>
                <input type="text" name="destination" class="form-control" placeholder="Tujuan perjalanan dinas" value="<?= old('destination') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Keterangan / Keperluan</label>
                <textarea name="description" class="form-control" rows="2" placeholder="Keterangan keperluan perjalanan dinas (Opsional)"><?= old('description') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Nama Driver <span class="text-danger">*</span></label>
                    <input type="text" name="driver_name" class="form-control" placeholder="Nama Supir" value="<?= old('driver_name') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Km Out (Kilometer Berangkat)</label>
                    <input type="number" name="km_out" class="form-control" placeholder="Odometer saat keluar" value="<?= old('km_out') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Km In (Kilometer Kembali)</label>
                    <input type="number" name="km_in" class="form-control" placeholder="Odometer saat kembali" value="<?= old('km_in') ?>">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i> Form permohonan akan diverifikasi oleh Tim Sarpras.
                </span>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill">
                    Submit Peminjaman Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
