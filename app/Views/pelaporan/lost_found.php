<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Layanan Pelaporan Barang Hilang &amp; Ditemukan</h2>
        <p class="text-muted mb-0">Portal resmi pelaporan barang hilang / tertinggal serta penyerahan barang temuan (Lost &amp; Found) Kampus UPITRA.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="/tracking" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">
            <i class="bi bi-search me-1"></i> Lacak Tiket
        </a>
        <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
            &larr; Beranda
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
            <div class="p-4 bg-white border-bottom">
                <!-- Toggle Jenis Laporan: Hilang vs Ditemukan -->
                <div class="d-flex justify-content-center mb-2">
                    <div class="btn-group p-1 bg-light rounded-pill border" role="group">
                        <input type="radio" class="btn-check" name="report_type_toggle" id="typeLost" autocomplete="off" checked onchange="switchReportType('lost')">
                        <label class="btn btn-outline-primary rounded-pill px-4 fw-bold py-2 border-0" for="typeLost">
                            <i class="bi bi-question-circle me-1"></i> Saya Kehilangan Barang
                        </label>

                        <input type="radio" class="btn-check" name="report_type_toggle" id="typeFound" autocomplete="off" onchange="switchReportType('found')">
                        <label class="btn btn-outline-success rounded-pill px-4 fw-bold py-2 border-0" for="typeFound">
                            <i class="bi bi-check2-circle me-1"></i> Saya Menemukan Barang
                        </label>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form method="post" action="/pelaporan/lost-found">
                    <?= csrf_field() ?>
                    <input type="hidden" name="report_type" id="reportTypeInput" value="lost">

                    <!-- Honeypot anti-spam bot (hidden) -->
                    <div style="display:none !important;" aria-hidden="true">
                        <input type="text" name="website_url_hp" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pelapor / Penemu <span class="text-danger">*</span></label>
                        <input type="text" name="reporter_name" class="form-control" placeholder="Masukkan nama lengkap Anda" value="<?= old('reporter_name') ?: esc(session()->get('user_name')) ?>" required>
                        <small class="text-muted"><i class="bi bi-shield-check text-success me-1"></i>Sesuai UU PDP, nama Anda akan dimask (inisial) pada daftar publik.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status Pelapor <span class="text-danger">*</span></label>
                            <select name="reporter_status" id="reporterStatus" class="form-select" onchange="toggleOtherStatus()" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Dosen">Dosen</option>
                                <option value="Tendik">Tendik</option>
                                <option value="Tamu">Tamu Pengunjung</option>
                                <option value="Others">Lainnya (Others)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" id="otherStatusDiv" style="display: none;">
                            <label class="form-label fw-bold">Sebutkan Status Anda</label>
                            <input type="text" name="reporter_status_other" id="otherStatusInput" class="form-control" placeholder="Ketik status Anda di sini">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" id="itemLabel">Deskripsi Barang yang Hilang <span class="text-danger">*</span></label>
                        <input type="text" name="lost_item" class="form-control" placeholder="Contoh: Dompet coklat merek X, Kunci motor Honda gantungan merah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">No. HP / WhatsApp Pelapor <span class="text-danger">*</span></label>
                        <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" required>
                        <div class="p-2.5 rounded-3 bg-light border mt-2 small text-muted">
                            <i class="bi bi-lock-fill text-primary me-1"></i>
                            <strong>Jaminan Perlindungan Data Pribadi:</strong> Nomor kontak Anda <strong>TIDAK PERNAH dipublikasikan</strong> ke halaman publik. Nomor kontak disimpan aman hanya untuk verifikasi fisik di Loket Sarpras Gedung 4 Lt. 1.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" id="dateLabel">Tanggal Kejadian <span class="text-danger">*</span></label>
                            <input type="date" name="incident_date" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold" id="timeLabel">Perkiraan Waktu <span class="text-danger">*</span></label>
                            <input type="time" name="incident_time" class="form-control" required value="<?= date('H:i') ?>">
                        </div>
                    </div>

                    <!-- Captcha Aritmatika -->
                    <div class="p-3 rounded-3 bg-light border mb-4">
                        <label class="form-label fw-bold small text-muted mb-1">
                            <i class="bi bi-shield-check text-primary me-1"></i> Verifikasi Keamanan Anti-Spam (Captcha) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white fw-bold font-monospace text-primary" id="captchaQuestion">
                                <?= esc($captcha['question'] ?? '5 + 3 = ?') ?>
                            </span>
                            <input type="number" name="captcha_answer" class="form-control" placeholder="Jawaban angka" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="refreshCaptcha()" title="Muat Ulang Soal">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm py-3" id="submitBtn">
                            <i class="bi bi-send-fill me-1"></i> Kirim Laporan Kehilangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- DAFTAR LAPORAN TERKINI (PUBLIK AMAN: MASKED)   -->
<!-- ============================================== -->
<div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-header bg-white border-0 pt-4 px-4 px-md-5 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="fw-bold mb-1 text-primary">
                <i class="bi bi-card-checklist me-2"></i>Daftar Laporan Lost &amp; Found Terkini
            </h5>
            <small class="text-muted"><i class="bi bi-shield-lock text-success me-1"></i>Data publik terlindungi sesuai UU PDP (Inisial pelapor &amp; nomor telepon dirahasiakan).</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="/tracking" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-search me-1"></i> Lacak Tiket Saya &rarr;
            </a>
            <?php if (session()->get('isLoggedIn')): ?>
                <a href="/dashboard" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-4 p-md-5 pt-3 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Tiket</th>
                    <th>Jenis Laporan</th>
                    <th>Nama Pelapor (Inisial)</th>
                    <th>Deskripsi Barang</th>
                    <th>Waktu Kejadian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentLostFound)): ?>
                    <?php $no = 1; foreach ($recentLostFound as $lf): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace fw-bold">
                                    <?= esc($lf['ticket_code'] ?: ('LF-' . str_pad($lf['id'], 6, '0', STR_PAD_LEFT))) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (($lf['report_type'] ?? 'lost') === 'found'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1">
                                        <i class="bi bi-check-circle me-1"></i>Ditemukan
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2.5 py-1">
                                        <i class="bi bi-question-circle me-1"></i>Kehilangan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong class="text-dark"><i class="bi bi-person-fill text-secondary me-1"></i><?= esc($lf['reporter_masked_name'] ?? 'Civitas') ?></strong><br>
                                <small class="text-muted"><?= esc($lf['reporter_status']) ?></small>
                            </td>
                            <td>
                                <strong class="text-dark"><?= esc($lf['lost_item']) ?></strong>
                            </td>
                            <td>
                                <span><?= esc($lf['incident_date']) ?></span><br>
                                <small class="text-muted"><?= esc($lf['incident_time']) ?></small>
                            </td>
                            <td>
                                <?php if ($lf['status'] === 'claimed'): ?>
                                    <span class="badge bg-success">Claimed (Diambil)</span>
                                <?php elseif ($lf['status'] === 'found'): ?>
                                    <span class="badge bg-info text-dark">Found (Ada di Sarpras)</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Reported (Dalam Proses)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/tracking?code=<?= urlencode($lf['ticket_code'] ?: ('LF-' . $lf['id'])) ?>" class="btn btn-outline-primary btn-sm rounded-pill px-2.5 py-1" title="Lacak Progres">
                                    <i class="bi bi-search"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>
                            Belum ada laporan barang hilang atau ditemukan yang disubmit.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function switchReportType(type) {
    const input = document.getElementById('reportTypeInput');
    const itemLabel = document.getElementById('itemLabel');
    const submitBtn = document.getElementById('submitBtn');
    
    if (type === 'found') {
        input.value = 'found';
        itemLabel.innerHTML = 'Deskripsi Barang yang Ditemukan <span class="text-danger">*</span>';
        submitBtn.className = 'btn btn-success btn-lg fw-bold rounded-pill shadow-sm py-3';
        submitBtn.innerHTML = '<i class="bi bi-check2-circle me-1"></i> Kirim Laporan Penemuan Barang';
    } else {
        input.value = 'lost';
        itemLabel.innerHTML = 'Deskripsi Barang yang Hilang <span class="text-danger">*</span>';
        submitBtn.className = 'btn btn-primary btn-lg fw-bold rounded-pill shadow-sm py-3';
        submitBtn.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim Laporan Kehilangan';
    }
}

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

function refreshCaptcha() {
    fetch('/captcha/refresh')
        .then(response => response.json())
        .then(data => {
            if (data && data.question) {
                document.getElementById('captchaQuestion').innerText = data.question;
            }
        })
        .catch(err => console.error(err));
}
</script>

<?= $this->endSection() ?>
