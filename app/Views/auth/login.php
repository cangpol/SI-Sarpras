<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center py-4">
    <div class="col-md-7 col-lg-5">
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 64px; height: 64px; background: rgba(255, 255, 255, 0.25); border: 1px solid rgba(255, 255, 255, 0.35);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-shield-lock text-white" viewBox="0 0 16 16">
                        <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.546-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                        <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 1 1 9.5 6.5"/>
                    </svg>
                </div>
                <h3 class="fw-bold mb-1">Login Portal Sarpras</h3>
                <p class="mb-0 text-white-50 small">Universitas Pignatelli Triputra</p>
            </div>

            <!-- Form Body -->
            <div class="card-body p-4 p-md-5">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="border-radius: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                        <div><?= session()->getFlashdata('error') ?></div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="border-radius: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <div><?= session()->getFlashdata('message') ?></div>
                    </div>
                <?php endif; ?>

                <!-- Tombol Single Sign-On (SSO) Microsoft 365 Resmi -->
                <?php $msConfig = config('Microsoft'); ?>
                <?php if ($msConfig && $msConfig->enabled): ?>
                    <a href="/auth/microsoft" class="btn btn-outline-dark w-100 py-2.5 mb-2 fw-bold d-flex align-items-center justify-content-center gap-2.5 rounded-3 shadow-sm btn-ms-login">
                        <svg width="20" height="20" viewBox="0 0 21 21" class="flex-shrink-0">
                            <rect x="1" y="1" width="9" height="9" fill="#f25022"/>
                            <rect x="11" y="1" width="9" height="9" fill="#7fba00"/>
                            <rect x="1" y="11" width="9" height="9" fill="#00a4ef"/>
                            <rect x="11" y="11" width="9" height="9" fill="#ffb900"/>
                        </svg>
                        <span>Masuk dengan Microsoft 365</span>
                    </a>
                    <div class="text-center mb-3">
                        <small class="text-muted" style="font-size: 0.78rem;">Khusus Mahasiswa &amp; Dosen (@upitra.ac.id)</small>
                    </div>

                    <!-- Pembatas Elegan -->
                    <div class="d-flex align-items-center mb-4">
                        <hr class="flex-grow-1 text-muted opacity-25 m-0">
                        <span class="px-3 small text-muted text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px;">atau login akun lokal</span>
                        <hr class="flex-grow-1 text-muted opacity-25 m-0">
                    </div>
                <?php endif; ?>

                <form method="post" action="/login">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username atau Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" id="username" name="username" value="<?= old('username') ?>" placeholder="Masukkan username" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                                </svg>
                            </span>
                            <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password" name="password" placeholder="Masukkan password" required>
                            <button class="btn btn-outline-secondary border-start-0 bg-light text-muted" type="button" id="togglePasswordBtn" style="border-color: #e0e0e0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" id="toggleEyeIcon" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm" style="font-size: 1.05rem; letter-spacing: 0.3px;">
                            Masuk ke Sistem
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="/" class="text-decoration-none text-muted small d-inline-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                            </svg>
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.btn-ms-login {
    background-color: #ffffff;
    border: 1.5px solid #cbd5e1 !important;
    color: #1e293b;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}
.btn-ms-login:hover {
    background-color: #f8fafc;
    border-color: #94a3b8 !important;
    color: #0f172a;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        });
    }
});
</script>

<?= $this->endSection() ?>

