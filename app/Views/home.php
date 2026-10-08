<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-4 mt-2">
    <div class="col-lg-4 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="mb-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-2">Keamanan</span>
                    <h4 class="card-title mt-2">Pelaporan</h4>
                </div>
                <p class="card-text text-muted mb-4">Layanan pelaporan barang hilang (Lost & Found) dan registrasi Visitor ID Pass untuk tamu kampus.</p>
                <div class="mt-auto d-grid gap-2">
                    <a href="/pelaporan/lost-found" class="btn btn-primary">Form Lost & Found</a>
                    <a href="/pelaporan/visitor" class="btn btn-outline-primary" style="font-weight: 600; border-radius: 8px;">Visitor ID Pass</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="mb-3">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-2">Fasilitas</span>
                    <h4 class="card-title mt-2" style="color: #0E9F6E;">Peminjaman</h4>
                </div>
                <p class="card-text text-muted mb-4">Sistem booking untuk peminjaman ruangan pertemuan dan kendaraan operasional Universitas.</p>
                <div class="mt-auto d-grid gap-2">
                    <a href="/peminjaman/ruangan" class="btn btn-success">Pinjam Ruangan</a>
                    <a href="/peminjaman/kendaraan" class="btn btn-outline-success" style="font-weight: 600; border-radius: 8px; color: #0E9F6E; border-color: #0E9F6E;">Pinjam Kendaraan</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="mb-3">
                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill mb-2">Operasional</span>
                    <h4 class="card-title mt-2" style="color: #FF8A4C;">Request</h4>
                </div>
                <p class="card-text text-muted mb-4">Pengajuan perbaikan fasilitas (Maintenance) dan permintaan alat tulis kantor (Supplies).</p>
                <div class="mt-auto d-grid gap-2">
                    <a href="/request/maintenance" class="btn btn-warning">Request Maintenance</a>
                    <a href="/request/supplies" class="btn btn-outline-warning" style="font-weight: 600; border-radius: 8px; color: #FF8A4C; border-color: #FF8A4C;">Request ATK</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
