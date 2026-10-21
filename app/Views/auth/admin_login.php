<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center py-5">
    <div class="col-md-7 col-lg-5 col-xl-4">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 64px; height: 64px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-shield-lock-fill text-white" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.78 11.78 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.78 11.78 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5"/>
                    </svg>
                </div>
                <h4 class="fw-bold mb-1 text-white">Akses Darurat Admin</h4>
                <p class="mb-0 text-white-50 small">Biro IT &amp; Sarpras &bull; Local 2FA Break-Glass</p>
            </div>

            <!-- Body -->
            <div class="card-body p-4 p-md-4 bg-white">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2.5 flex-shrink-0"></i>
                        <div class="small"><?= session()->getFlashdata('error') ?></div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                        <i class="bi bi-check-circle-fill fs-5 me-2.5 flex-shrink-0"></i>
                        <div class="small"><?= session()->getFlashdata('message') ?></div>
                    </div>
                <?php endif; ?>

                <div class="alert alert-warning border-0 small mb-4 text-dark" style="background-color: #fffbeb; border-radius: 12px;">
                    <div class="d-flex gap-2">
                        <i class="bi bi-shield-exclamation text-warning fs-5 flex-shrink-0"></i>
                        <div>
                            <strong>Pemberitahuan Otoritas:</strong>
                            Halaman ini KHUSUS untuk Administrator berwenang. Civitas akademika (Mahasiswa &amp; Dosen) <strong>wajib menggunakan Single Sign-On (SSO)</strong>.
                        </div>
                    </div>
                </div>

                <form method="post" action="/login/admin">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">Username / Email Administrator</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" name="username" class="form-control border-start-0" placeholder="admin / it@upitra.ac.id" value="<?= old('username') ?>" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">Password Kredensial</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan password admin" required>
                        </div>
                    </div>

                    <!-- Captcha Keamanan -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-muted">Verifikasi Keamanan (Captcha)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary bg-opacity-10 text-primary fw-bold border-end-0 font-monospace">
                                <?= esc($captcha_question) ?>
                            </span>
                            <input type="number" name="captcha_answer" class="form-control border-start-0" placeholder="Jawaban angka" required>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-danger py-2.5 fw-bold rounded-4 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <span>Lanjut ke Verifikasi 2FA</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <div class="text-center pt-3 border-top">
                    <a href="/login" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1.5 hover-primary">
                        <i class="bi bi-box-arrow-in-left"></i>
                        <span>Kembali ke Portal SSO Civitas</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
