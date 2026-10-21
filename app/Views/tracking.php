<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5 fw-semibold small mb-2 d-inline-block">
            <i class="bi bi-search me-1"></i> LAYANAN PELACAKAN TERPADU
        </span>
        <h2 class="fw-bold display-6 mb-2" style="color: var(--primary-blue);">Lacak Status Tiket &amp; Permohonan</h2>
        <p class="text-muted mx-auto" style="max-width: 650px;">
            Pantau status pemrosesan permohonan sarana prasarana, pelaporan barang hilang/ditemukan (Lost &amp; Found), serta verifikasi Visitor ID Pass Anda secara real-time.
        </p>
    </div>

    <!-- Search Form Card -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
                <form method="post" action="/tracking">
                    <?= csrf_field() ?>
                    <label class="form-label fw-bold text-dark mb-2">
                        <i class="bi bi-upc-scan text-primary me-1"></i> Masukkan Kode Tiket / Nomor Registrasi
                    </label>
                    <div class="input-group input-group-lg">
                        <input type="text" name="code" class="form-control rounded-start-pill ps-4 font-monospace" placeholder="Contoh: LF-202610-001, VP-202610-001, RB-1, MNT-1" value="<?= esc($searchedCode ?? '') ?>" required autofocus>
                        <button class="btn btn-primary rounded-end-pill px-4 fw-bold d-flex align-items-center gap-2" type="submit">
                            <i class="bi bi-search"></i>
                            <span>Lacak</span>
                        </button>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-1 text-muted small">
                        <span class="fw-semibold">Contoh Kode:</span>
                        <a href="/tracking?code=LF-202610-001" class="badge bg-light text-secondary border text-decoration-none hover-primary">LF-202610-001 (Lost &amp; Found)</a>
                        <a href="/tracking?code=VP-202610-001" class="badge bg-light text-secondary border text-decoration-none hover-primary">VP-202610-001 (Visitor Pass)</a>
                        <a href="/tracking?code=MNT-1" class="badge bg-light text-secondary border text-decoration-none hover-primary">MNT-1 (Maintenance)</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hasil Pelacakan -->
    <?php if (!empty($searchedCode)): ?>
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <?php if (!empty($ticket)): ?>
                    <div class="card border-0 shadow rounded-4 overflow-hidden mb-4">
                        <!-- Header Kartu Tiket -->
                        <div class="p-4 text-white d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%);">
                            <div>
                                <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-1 mb-2 fw-semibold small">
                                    <?= esc($ticket['type_label']) ?>
                                </span>
                                <h4 class="fw-bold mb-0 text-white font-monospace"><?= esc($ticket['ticket_code']) ?></h4>
                            </div>
                            <div>
                                <?php
                                $status = strtolower($ticket['status']);
                                $badgeBg = 'bg-warning text-dark';
                                $statusIcon = 'bi-clock-history';
                                if (in_array($status, ['approved', 'resolved', 'found', 'checked_out', 'claimed'])) {
                                    $badgeBg = 'bg-success text-white';
                                    $statusIcon = 'bi-check-circle-fill';
                                } elseif (in_array($status, ['rejected'])) {
                                    $badgeBg = 'bg-danger text-white';
                                    $statusIcon = 'bi-x-circle-fill';
                                } elseif (in_array($status, ['in_progress', 'checked_in'])) {
                                    $badgeBg = 'bg-info text-dark';
                                    $statusIcon = 'bi-gear-wide-connected';
                                }
                                ?>
                                <span class="badge <?= $badgeBg ?> rounded-pill px-3.5 py-2 fs-6 fw-bold shadow-sm d-inline-flex align-items-center gap-1.5">
                                    <i class="bi <?= $statusIcon ?>"></i>
                                    <span><?= esc($ticket['status_label']) ?></span>
                                </span>
                            </div>
                        </div>

                        <!-- Body Detail Tiket -->
                        <div class="card-body p-4 p-md-4 bg-white">
                            <div class="row g-3 mb-4">
                                <div class="col-md-7">
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem;">Deskripsi / Objek Tiket</small>
                                    <h5 class="fw-bold text-dark mt-1 mb-0"><?= esc($ticket['title']) ?></h5>
                                </div>
                                <div class="col-md-5">
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem;">Nama Pelapor / Tamu (Privasi Terlindungi)</small>
                                    <div class="fw-bold text-primary mt-1">
                                        <i class="bi bi-person-fill me-1"></i><?= esc($ticket['reporter']) ?>
                                    </div>
                                </div>
                                <?php if (!empty($ticket['host'])): ?>
                                <div class="col-md-6">
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem;">Pejabat / Host yang Dituju</small>
                                    <div class="fw-bold text-dark mt-1"><?= esc($ticket['host']) ?></div>
                                </div>
                                <?php endif; ?>
                                <div class="col-md-6">
                                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem;">Waktu / Tanggal Terdaftar</small>
                                    <div class="text-dark mt-1">
                                        <i class="bi bi-calendar-event me-1 text-muted"></i><?= esc($ticket['date'] ?? $ticket['created_at']) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Petugas Sarpras -->
                            <div class="p-3.5 rounded-3 bg-light border mb-4">
                                <div class="d-flex align-items-start gap-2.5">
                                    <i class="bi bi-chat-left-text-fill text-primary fs-5 mt-0.5"></i>
                                    <div>
                                        <strong class="d-block text-dark small mb-1">Catatan &amp; Tindak Lanjut Petugas Biro Sarpras:</strong>
                                        <p class="mb-0 text-muted small"><?= esc($ticket['admin_note']) ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Jaminan Privasi UU PDP -->
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top text-muted small">
                                <span><i class="bi bi-shield-check text-success me-1"></i>Privasi Terlindungi (UU PDP No. 27/2022)</span>
                                <a href="/tracking" class="text-decoration-none text-muted hover-primary">
                                    <i class="bi bi-arrow-repeat me-1"></i>Lacak Tiket Lain
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                        <div class="mb-3 text-secondary">
                            <i class="bi bi-exclamation-circle fs-1 text-warning"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Tiket Tidak Ditemukan</h5>
                        <p class="text-muted small mx-auto mb-4" style="max-width: 480px;">
                            Tidak ditemukan permohonan atau laporan dengan kode <strong>"<?= esc($searchedCode) ?>"</strong>. Pastikan Anda memasukkan kode tiket dengan benar atau hubungi Biro Sarpras jika Anda memerlukan bantuan.
                        </p>
                        <div>
                            <a href="/tracking" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                                Coba Kode Lain
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

