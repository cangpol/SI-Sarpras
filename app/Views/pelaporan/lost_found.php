<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Form Pelaporan Kehilangan Barang</h2>
        <p class="text-muted mb-0">Layanan pelaporan barang hilang / tertinggal (Lost & Found) di lingkungan kampus.</p>
    </div>
    <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; Kembali ke Beranda
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="/pelaporan/lost-found">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Penginput / Pelapor <span class="text-danger">*</span></label>
                        <input type="text" name="reporter_name" class="form-control" placeholder="Masukkan nama lengkap Anda" value="<?= old('reporter_name') ?: esc(session()->get('user_name')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Status Pelapor</label>
                        <select name="reporter_status" id="reporterStatus" class="form-select" onchange="toggleOtherStatus()" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Tendik">Tendik</option>
                            <option value="Tamu">Tamu</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-3" id="otherStatusDiv" style="display: none;">
                        <label>Sebutkan Status Anda</label>
                        <input type="text" name="reporter_status_other" id="otherStatusInput" class="form-control" placeholder="Ketik status Anda di sini">
                    </div>

                    <div class="mb-3">
                        <label>Barang yang Hilang</label>
                        <input type="text" name="lost_item" class="form-control" placeholder="Deskripsikan barang yang hilang secara singkat" required>
                    </div>

                    <div class="mb-3">
                        <label>No. HP Pelapor (Aktif/WA)</label>
                        <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Kejadian</label>
                            <input type="date" name="incident_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Waktu Kejadian</label>
                            <input type="time" name="incident_time" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Kirim Laporan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- DAFTAR LAPORAN TERKINI (LIST SUBMIT) -->
<!-- ============================================== -->
<div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-header bg-white border-0 pt-4 px-4 px-md-5 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="fw-bold mb-1 text-primary">
                <i class="bi bi-card-checklist me-2"></i>Daftar Laporan Lost & Found Terkini (List Submit)
            </h5>
            <small class="text-muted">Daftar laporan kehilangan barang yang telah disubmit beserta nama user/pelapor yang menginput.</small>
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
                    <th>Nama Penginput / Pelapor</th>
                    <th>Barang yang Hilang</th>
                    <th>Kontak</th>
                    <th>Waktu Kejadian</th>
                    <th>Status</th>
                    <th>Waktu Lapor</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentLostFound)): ?>
                    <?php $no = 1; foreach ($recentLostFound as $lf): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong class="text-dark"><i class="bi bi-person-fill text-primary me-1"></i><?= esc($lf['reporter_name']) ?></strong><br>
                                <span class="badge bg-light text-dark border"><?= esc($lf['reporter_status']) ?></span>
                            </td>
                            <td>
                                <strong class="text-danger"><?= esc($lf['lost_item']) ?></strong>
                            </td>
                            <td><?= esc($lf['contact']) ?></td>
                            <td>
                                <span><?= esc($lf['incident_date']) ?></span><br>
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
                            <td>
                                <small class="text-muted"><?= esc($lf['created_at'] ?? '-') ?></small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>
                            Belum ada laporan barang hilang yang disubmit.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleOtherStatus() {
    const statusSelect = document.getElementById('reporterStatus');
    const otherDiv = document.getElementById('otherStatusDiv');
    const otherInput = document.getElementById('otherStatusInput');
    
    if (statusSelect.value === 'Others') {
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
