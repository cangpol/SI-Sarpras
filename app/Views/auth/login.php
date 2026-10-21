<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center py-5">
    <div class="col-md-7 col-lg-5 col-xl-4">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Header Card -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%);">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 64px; height: 64px; background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-shield-lock text-white" viewBox="0 0 16 16">
                        <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.546-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                        <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 1 1 9.5 6.5"/>
                    </svg>
                </div>
                <h4 class="fw-bold mb-1 text-white">Portal Single Sign-On</h4>
                <p class="mb-0 text-white-50 small">Biro Sarpras &bull; Universitas Pignatelli Triputra</p>
            </div>

            <!-- Body -->
            <div class="card-body p-4 p-md-4">
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

                <div class="text-center mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5 fw-semibold small mb-2 d-inline-block">
                        <i class="bi bi-shield-check me-1"></i> AUTENTIKASI RESMI TERPADU
                    </span>
                    <h5 class="fw-bold text-dark mb-1">Masuk dengan Akun Kampus</h5>
                    <p class="text-muted small mb-0">
                        Akses khusus Civitas Akademika (Dosen, Tenaga Kependidikan, dan Mahasiswa) menggunakan akun Microsoft 365 resmi.
                    </p>
                </div>

                <!-- Tombol Single Sign-On (SSO) Microsoft 365 Resmi (SATU-SATUNYA METODE LOGIN) -->
                <a href="/auth/microsoft" class="btn btn-outline-dark w-100 py-3 mb-3 fw-bold d-flex align-items-center justify-content-center gap-3 rounded-4 shadow-sm btn-ms-login">
                    <svg width="24" height="24" viewBox="0 0 21 21" class="flex-shrink-0">
                        <rect x="1" y="1" width="9" height="9" fill="#f25022"/>
                        <rect x="11" y="1" width="9" height="9" fill="#7fba00"/>
                        <rect x="1" y="11" width="9" height="9" fill="#00a4ef"/>
                        <rect x="11" y="11" width="9" height="9" fill="#ffb900"/>
                    </svg>
                    <span class="fs-6">Masuk dengan Microsoft 365</span>
                </a>

                <div class="text-center mb-4">
                    <span class="badge bg-light text-secondary border rounded-pill px-3 py-1 small">
                        @upitra.ac.id &bull; @student.upitra.ac.id
                    </span>
                </div>

                <!-- Informasi Kebijakan Keamanan SSO Only -->
                <div class="p-3 rounded-3 bg-light border text-muted small mb-4">
                    <div class="d-flex gap-2">
                        <i class="bi bi-info-circle-fill text-primary fs-5 flex-shrink-0"></i>
                        <div>
                            <strong class="d-block text-dark mb-1">Kebijakan Autentikasi:</strong>
                            Login akun lokal (username &amp; password manual) telah <strong>dinonaktifkan</strong>. Seluruh hak akses pengguna (Super Admin, Admin, Dosen, Mahasiswa) dikelola secara aman dan terpusat melalui SSO Microsoft 365.
                        </div>
                    </div>
                </div>

                <div class="text-center pt-2 border-top">
                    <a href="/" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1.5 hover-primary">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali ke Halaman Utama</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-ms-login {
    background-color: #ffffff;
    border: 1.5px solid #cbd5e1 !important;
    color: #1e293b;
    font-size: 0.98rem;
    transition: all 0.2s ease;
}
.btn-ms-login:hover {
    background-color: #f8fafc;
    border-color: #0A3A66 !important;
    color: #0A3A66;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(10, 58, 102, 0.12) !important;
}
.hover-primary:hover {
    color: var(--primary-blue) !important;
}
</style>

<?= $this->endSection() ?>
