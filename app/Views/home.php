<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Pelaporan</h5>
                <p class="card-text">Layanan pelaporan barang hilang dan registrasi Visitor ID Pass.</p>
                <a href="/pelaporan/lost-found" class="btn btn-primary mb-2">Lost & Found</a>
                <a href="/pelaporan/visitor" class="btn btn-primary mb-2">Visitor ID Pass</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Peminjaman</h5>
                <p class="card-text">Booking peminjaman ruangan dan kendaraan operasional kampus.</p>
                <a href="/peminjaman/ruangan" class="btn btn-success mb-2">Peminjaman Ruangan</a>
                <a href="/peminjaman/kendaraan" class="btn btn-success mb-2">Peminjaman Kendaraan</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Request</h5>
                <p class="card-text">Pengajuan perbaikan (maintenance) dan permintaan alat tulis kantor.</p>
                <a href="/request/maintenance" class="btn btn-warning mb-2">Request Maintenance</a>
                <a href="/request/supplies" class="btn btn-warning mb-2">Request ATK/Supplies</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
