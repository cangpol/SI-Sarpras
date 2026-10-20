<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Registrasi Visitor ID Pass</h2>
        <p class="text-muted mb-0">Formulir check-in pengunjung / tamu kampus Universitas Pignatelli Triputra.</p>
    </div>
    <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; Kembali ke Beranda
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="/pelaporan/visitor">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Penginput / Tamu Pengunjung <span class="text-danger">*</span></label>
                        <input type="text" name="visitor_name" class="form-control" placeholder="Nama pengunjung" value="<?= old('visitor_name') ?: esc(session()->get('user_name')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Asal Institusi / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="institution" class="form-control" placeholder="Contoh: PT ABC, Universitas XYZ, atau Pribadi" value="<?= old('institution') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">No. HP (Aktif/WA) <span class="text-danger">*</span></label>
                        <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" value="<?= old('contact') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keperluan <span class="text-danger">*</span></label>
                        <select name="purpose" id="purposeStatus" class="form-select" onchange="toggleOtherPurpose()" required>
                            <option value="">-- Pilih Keperluan --</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Kunjungan">Kunjungan</option>
                            <option value="Antar Dokumen">Antar Dokumen</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-3" id="otherPurposeDiv" style="display: none;">
                        <label class="form-label fw-bold">Sebutkan Keperluan Anda</label>
                        <input type="text" name="purpose_other" id="otherPurposeInput" class="form-control" placeholder="Ketik tujuan spesifik Anda di sini">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama yang Dituju (Host) <span class="text-danger">*</span></label>
                        <input type="text" name="host_name" class="form-control" placeholder="Sebutkan nama dosen/staf yang akan ditemui" value="<?= old('host_name') ?>" required>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm">Check-In Pengunjung</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- DAFTAR PENGUNJUNG TERKINI (LIST SUBMIT) -->
<!-- ============================================== -->
<div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-header bg-white border-0 pt-4 px-4 px-md-5 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="fw-bold mb-1 text-primary">
                <i class="bi bi-card-checklist me-2"></i>Daftar Registrasi Visitor ID Pass Terkini (List Submit)
            </h5>
            <small class="text-muted">Data buku tamu pengunjung kampus yang telah disubmit beserta nama user/pengunjung yang menginput.</small>
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
                    <th>Nama Penginput / Tamu</th>
                    <th>Institusi</th>
                    <th>Kontak</th>
                    <th>Keperluan</th>
                    <th>Host (Dituju)</th>
                    <th>Check In</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentVisitors)): ?>
                    <?php $no = 1; foreach ($recentVisitors as $vt): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong class="text-dark"><i class="bi bi-person-fill text-primary me-1"></i><?= esc($vt['visitor_name']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= esc($vt['institution']) ?></span>
                            </td>
                            <td><?= esc($vt['contact']) ?></td>
                            <td>
                                <strong><?= esc($vt['purpose']) ?></strong>
                            </td>
                            <td><?= esc($vt['host_name']) ?></td>
                            <td>
                                <small class="text-success"><i class="bi bi-clock me-1"></i><?= esc($vt['check_in'] ?? '-') ?></small>
                            </td>
                            <td>
                                <?php if ($vt['status'] === 'checked_out'): ?>
                                    <span class="badge bg-secondary">Checked Out</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Checked In</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>
                            Belum ada riwayat registrasi pengunjung yang disubmit.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleOtherPurpose() {
    const purposeSelect = document.getElementById('purposeStatus');
    const otherDiv = document.getElementById('otherPurposeDiv');
    const otherInput = document.getElementById('otherPurposeInput');
    
    if (purposeSelect.value === 'Others') {
        otherDiv.style.display = 'block';
        otherInput.required = true;
    } else {
        otherDiv.style.display = 'none';
        otherInput.required = false;
        otherInput.value = '';
    }
}
</script>
<?= $this->endSection() ?>
