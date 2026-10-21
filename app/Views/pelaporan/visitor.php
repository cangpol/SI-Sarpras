<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Registrasi Visitor ID Pass (Buku Tamu Digital)</h2>
        <p class="text-muted mb-0">Layanan check-in mandiri pengunjung / tamu dinas di lingkungan kampus Universitas Pignatelli Triputra.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="/tracking" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">
            <i class="bi bi-search me-1"></i> Verifikasi Pass
        </a>
        <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
            &larr; Beranda
        </a>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL KARTU VISITOR PASS DIGITAL (POP-UP PASCA CHECK-IN) -->
<!-- ============================================== -->
<?php $visitorPass = session()->getFlashdata('visitor_pass'); ?>
<?php if ($visitorPass): ?>
<div class="modal fade show d-block" id="modalVisitorPass" tabindex="-1" style="background-color: rgba(0,0,0,0.65); z-index: 1055;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Header Kartu Pass -->
            <div class="p-4 text-white text-center position-relative" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%);">
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                    <img src="/logo.png" alt="UPITRA" style="height: 32px; width: auto;" class="bg-white rounded p-1">
                    <span class="fw-bold tracking-wide">UNIVERSITAS PIGNATELLI TRIPUTRA</span>
                </div>
                <h5 class="fw-bold mb-0 text-white text-uppercase tracking-wider">VISITOR DIGITAL PASS</h5>
                <small class="text-white-50">Tanda Pengenal Tamu Kampus Resmi</small>
            </div>

            <!-- Body Pass & QR -->
            <div class="card-body p-4 text-center bg-white" id="printableVisitorPass">
                <div class="mb-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 font-monospace fw-bold fs-6 border border-primary border-opacity-25">
                        ID: <?= esc($visitorPass['pass_code']) ?>
                    </span>
                </div>

                <!-- QR Code Dinamis -->
                <div class="p-3 d-inline-block bg-white rounded-3 border shadow-sm mb-3">
                    <img src="https://quickchart.io/qr?text=<?= urlencode($visitorPass['verify_url']) ?>&size=160&margin=1" alt="QR Visitor Pass" class="img-fluid" style="width: 160px; height: 160px;">
                </div>

                <div class="text-start p-3 rounded-3 bg-light border mb-3 small">
                    <div class="row g-2">
                        <div class="col-5 text-muted">Nama Pengunjung:</div>
                        <div class="col-7 fw-bold text-dark"><?= esc($visitorPass['visitor_name']) ?></div>

                        <div class="col-5 text-muted">Asal Instansi:</div>
                        <div class="col-7 text-dark"><?= esc($visitorPass['institution']) ?></div>

                        <div class="col-5 text-muted">Keperluan:</div>
                        <div class="col-7 text-dark fw-semibold"><?= esc($visitorPass['purpose']) ?></div>

                        <div class="col-5 text-muted">Host yang Dituju:</div>
                        <div class="col-7 text-primary fw-bold"><?= esc($visitorPass['host_name']) ?></div>

                        <div class="col-5 text-muted">Waktu Check-In:</div>
                        <div class="col-7 text-dark"><?= esc($visitorPass['check_in']) ?></div>
                    </div>
                </div>

                <div class="p-2.5 rounded-3 bg-warning bg-opacity-10 text-warning-emphasis text-start small mb-2 border border-warning border-opacity-25">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    <strong>Petunjuk Tamu:</strong> Tunjukkan kartu / QR Pass ini kepada petugas keamanan di Pos Jaga Utama untuk verifikasi akses gedung.
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3" onclick="closePassModal()">
                    Tutup
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" onclick="window.print()">
                    <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan Pass
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Formulir Registrasi Pengunjung -->
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5 fw-semibold small mb-2 d-inline-block">
                        <i class="bi bi-person-badge me-1"></i> BUKU TAMU DIGITAL
                    </span>
                    <h4 class="fw-bold text-dark mb-1">Registrasi Check-In Pengunjung</h4>
                    <p class="text-muted small mb-0">Silakan lengkapi identitas kunjungan Anda untuk memperoleh QR Visitor Pass.</p>
                </div>

                <form method="post" action="/pelaporan/visitor">
                    <?= csrf_field() ?>

                    <!-- Honeypot anti-bot -->
                    <div style="display:none !important;" aria-hidden="true">
                        <input type="text" name="website_url_hp" tabindex="-1" autocomplete="off">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap Pengunjung <span class="text-danger">*</span></label>
                        <input type="text" name="visitor_name" class="form-control" placeholder="Masukkan nama lengkap Anda" value="<?= old('visitor_name') ?: esc(session()->get('user_name')) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Asal Institusi / Perusahaan / Instansi <span class="text-danger">*</span></label>
                        <input type="text" name="institution" class="form-control" placeholder="Contoh: PT. Telkom Indonesia, SMA N di Surakarta, Pribadi" value="<?= old('institution') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">No. HP / WhatsApp Aktif <span class="text-danger">*</span></label>
                        <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" value="<?= old('contact') ?>" required>
                        <small class="text-muted d-block mt-1"><i class="bi bi-shield-check text-success me-1"></i>Data nomor telepon Anda dienkripsi dan terlindungi aman sesuai UU PDP (tidak pernah dipublikasikan).</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Keperluan Kunjungan <span class="text-danger">*</span></label>
                            <select name="purpose" id="purposeStatus" class="form-select" onchange="toggleOtherPurpose()" required>
                                <option value="">-- Pilih Keperluan --</option>
                                <option value="Meeting / Rapat Dinas">Meeting / Rapat Dinas</option>
                                <option value="Kunjungan Kerjasama">Kunjungan Kerjasama</option>
                                <option value="Antar Dokumen / Paket">Antar Dokumen / Paket</option>
                                <option value="Pemeliharaan / Vendor Teknis">Pemeliharaan / Vendor Teknis</option>
                                <option value="Konsultasi Admisi & Beasiswa">Konsultasi Admisi &amp; Beasiswa</option>
                                <option value="Others">Keperluan Lainnya (Others)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pejabat / Host yang Dituju <span class="text-danger">*</span></label>
                            <input type="text" name="host_name" class="form-control" placeholder="Sebutkan nama dosen/staf/unit tujuan" value="<?= old('host_name') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3" id="otherPurposeDiv" style="display: none;">
                        <label class="form-label fw-bold">Sebutkan Keperluan Anda</label>
                        <input type="text" name="purpose_other" id="otherPurposeInput" class="form-control" placeholder="Ketik tujuan spesifik Anda di sini">
                    </div>

                    <!-- Captcha Aritmatika -->
                    <div class="p-3 rounded-3 bg-light border mb-4">
                        <label class="form-label fw-bold small text-muted mb-1">
                            <i class="bi bi-shield-check text-primary me-1"></i> Verifikasi Keamanan Anti-Spam (Captcha) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white fw-bold font-monospace text-primary" id="captchaQuestion">
                                <?= esc($captcha['question'] ?? '4 + 5 = ?') ?>
                            </span>
                            <input type="number" name="captcha_answer" class="form-control" placeholder="Jawaban angka" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="refreshCaptcha()" title="Muat Ulang Soal">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm py-3">
                            <i class="bi bi-qr-code-scan me-1"></i> Check-In &amp; Terbitkan QR Visitor Pass
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Catatan Kebijakan Privasi Tamu Kampus -->
        <div class="p-3.5 rounded-4 bg-white border shadow-sm mt-4 text-muted small">
            <div class="d-flex gap-2.5">
                <i class="bi bi-shield-lock-fill text-primary fs-4 flex-shrink-0"></i>
                <div>
                    <strong class="d-block text-dark mb-1">Perlindungan Privasi Tamu Kampus (UU PDP No. 27/2022):</strong>
                    Sesuai dengan regulasi perlindungan data pribadi, seluruh arsip riwayat tamu kampus dipindahkan secara eksklusif ke area internal administrator &amp; petugas pos keamanan. Tidak ada riwayat tamu yang diekspos secara terbuka di halaman publik.
                </div>
            </div>
        </div>
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

function closePassModal() {
    const modal = document.getElementById('modalVisitorPass');
    if (modal) {
        modal.classList.remove('d-block');
        modal.classList.add('d-none');
    }
}
</script>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printableVisitorPass, #printableVisitorPass * {
        visibility: visible;
    }
    #printableVisitorPass {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>

<?= $this->endSection() ?>
