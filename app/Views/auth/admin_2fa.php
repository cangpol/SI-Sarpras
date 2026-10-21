<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center py-5">
    <div class="col-md-7 col-lg-5 col-xl-4">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 100%);">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 64px; height: 64px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-key-fill text-white" viewBox="0 0 16 16">
                        <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                    </svg>
                </div>
                <h4 class="fw-bold mb-1 text-white">Verifikasi Dua Langkah (2FA)</h4>
                <p class="mb-0 text-white-50 small">Autentikasi Keamanan Administrator</p>
            </div>

            <!-- Body -->
            <div class="card-body p-4 p-md-4 bg-white">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2.5 flex-shrink-0"></i>
                        <div class="small"><?= session()->getFlashdata('error') ?></div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('otp_notice')): ?>
                    <div class="alert alert-info border-0 shadow-sm mb-4" style="border-radius: 12px;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check fs-4 text-primary"></i>
                            <div>
                                <small class="text-muted d-block fw-semibold">Kode OTP Verifikasi Keamanan Anda:</small>
                                <strong class="fs-4 font-monospace text-primary letter-spacing-2"><?= session()->getFlashdata('otp_notice') ?></strong>
                                <small class="text-muted d-block" style="font-size: 0.72rem;">(Berlaku 5 menit untuk sesi autentikasi ini)</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="text-center mb-4">
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-1 mb-2">
                        <?= esc($pending['name'] ?? 'Administrator') ?> (<?= esc($pending['role']) ?>)
                    </span>
                    <p class="text-muted small mb-0">
                        Masukkan <strong>6 digit kode verifikasi</strong> untuk mengonfirmasi identitas Anda sebelum masuk ke Dashboard.
                    </p>
                </div>

                <form method="post" action="/login/admin/verify-2fa">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-center w-100 text-muted small text-uppercase">Kode OTP 2FA (6 Digit)</label>
                        <input type="text" name="two_factor_code" class="form-control form-control-lg text-center font-monospace fw-bold fs-3 border-2 rounded-4" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autofocus style="letter-spacing: 6px;">
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2.5 fw-bold rounded-4 shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Verifikasi &amp; Masuk Dashboard
                        </button>
                    </div>
                </form>

                <div class="text-center pt-3 border-top">
                    <a href="/login/admin" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1.5 hover-primary">
                        <i class="bi bi-arrow-left"></i>
                        <span>Batal &amp; Kembali ke Login Admin</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

