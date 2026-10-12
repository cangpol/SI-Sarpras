<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-4 mt-2">
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex flex-column">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Keamanan</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill" style="font-size: 0.75rem;"><i class="bi bi-globe me-1"></i> Umum & Tamu</span>
                </div>
                <h4 class="card-title mt-1">Pelaporan</h4>
                <p class="card-text text-muted mb-4">Layanan pelaporan barang hilang (Lost & Found) dan registrasi Visitor ID Pass untuk tamu kampus. Terbuka untuk umum tanpa perlu login.</p>
                <div class="mt-auto d-grid gap-2">
                    <a href="/pelaporan/lost-found" class="btn btn-primary">Form Lost & Found</a>
                    <a href="/pelaporan/visitor" class="btn btn-outline-primary" style="font-weight: 600; border-radius: 8px;">Visitor ID Pass</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex flex-column">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Fasilitas</span>
                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill" style="font-size: 0.75rem;"><i class="bi bi-person-badge me-1"></i> Mahasiswa & Dosen</span>
                </div>
                <h4 class="card-title mt-1" style="color: #0E9F6E;">Peminjaman</h4>
                <p class="card-text text-muted mb-4">Sistem booking peminjaman ruangan pertemuan dan kendaraan operasional Universitas. Wajib login dengan akun Mahasiswa / Dosen.</p>
                <div class="mt-auto d-grid gap-2">
                    <a href="/peminjaman/ruangan" class="btn btn-success">Pinjam Ruangan</a>
                    <a href="/peminjaman/kendaraan" class="btn btn-outline-success" style="font-weight: 600; border-radius: 8px; color: #0E9F6E; border-color: #0E9F6E;">Pinjam Kendaraan</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex flex-column">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-1">
                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Operasional</span>
                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 rounded-pill" style="font-size: 0.75rem;"><i class="bi bi-person-badge me-1"></i> Mahasiswa & Dosen</span>
                </div>
                <h4 class="card-title mt-1" style="color: #FF8A4C;">Request</h4>
                <p class="card-text text-muted mb-4">Pengajuan perbaikan fasilitas (Maintenance) dan permintaan alat tulis kantor (Supplies). Wajib login dengan akun Mahasiswa / Dosen.</p>
                <div class="mt-auto d-grid gap-2">
                    <a href="/request/maintenance" class="btn btn-warning">Request Maintenance</a>
                    <a href="/request/supplies" class="btn btn-outline-warning" style="font-weight: 600; border-radius: 8px; color: #FF8A4C; border-color: #FF8A4C;">Request ATK</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
