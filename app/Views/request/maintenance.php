<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Request Maintenance</h2>
        <p class="text-muted mb-0">Formulir pelaporan dan permohonan perbaikan fasilitas kampus yang mengalami kerusakan.</p>
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
        <form method="post" action="/request/maintenance">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Pemohon / Pelapor <span class="text-danger">*</span></label>
                    <input type="text" name="requester_name" class="form-control" placeholder="Nama Lengkap" value="<?= old('requester_name') ?: esc(session()->get('user_name')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Department / Unit <span class="text-danger">*</span></label>
                    <select name="department" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Department --</option>
                        <?php 
                        $departments = ['Finance', 'SDM', 'LPPM', 'LPM', 'Kerjasama', 'IT', 'Kemahasiswaan', 'BAA', 'Marketing', 'Rektorat', 'Sekretariat', 'FEB', 'FSH', 'FST', 'Yayasan & Ten', 'Sarpras', 'Mahasiswa', 'Security', 'CS'];
                        $userDept = session()->get('department');
                        foreach($departments as $dept): ?>
                            <option value="<?= $dept ?>" <?= (old('department') == $dept || $userDept == $dept) ? 'selected' : '' ?>><?= $dept ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Lokasi Kerusakan <span class="text-danger">*</span></label>
                    <input type="text" name="location" class="form-control" placeholder="Contoh: Gedung A Lt. 2 Ruang 201, Toilet Lantai 1" value="<?= old('location') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Fasilitas yang Rusak <span class="text-danger">*</span></label>
                    <select name="facility" id="facilitySelect" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Fasilitas --</option>
                        <option value="Lampu" <?= old('facility') == 'Lampu' ? 'selected' : '' ?>>Lampu</option>
                        <option value="AC" <?= old('facility') == 'AC' ? 'selected' : '' ?>>AC</option>
                        <option value="Air" <?= old('facility') == 'Air' ? 'selected' : '' ?>>Air</option>
                        <option value="Others" <?= old('facility') == 'Others' ? 'selected' : '' ?>>Others (Lainnya)</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3" id="facilityOtherDiv" style="display: none;">
                <label class="form-label fw-bold">Tulis Fasilitas Lainnya <span class="text-danger">*</span></label>
                <input type="text" name="facility_other" id="facilityOtherInput" class="form-control" placeholder="Sebutkan fasilitas yang rusak (misal: Pintu, Jendela, Kursi, Proyektor)">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Keterangan Kerusakan <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail kerusakan yang terjadi agar teknisi dapat menyiapkan peralatan dengan tepat" required><?= old('description') ?></textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i> Teknisi Sarpras akan menindaklanjuti laporan perbaikan ini.
                </span>
                <button type="submit" class="btn btn-warning px-5 py-2 fw-bold shadow-sm rounded-pill text-white">
                    Submit Request Maintenance
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('facilitySelect').addEventListener('change', function() {
    var otherDiv = document.getElementById('facilityOtherDiv');
    var otherInput = document.getElementById('facilityOtherInput');
    if (this.value === 'Others') {
        otherDiv.style.display = 'block';
        otherInput.setAttribute('required', 'required');
    } else {
        otherDiv.style.display = 'none';
        otherInput.removeAttribute('required');
    }
});
</script>
<?= $this->endSection() ?>
