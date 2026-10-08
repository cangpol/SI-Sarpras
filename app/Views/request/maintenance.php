<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2>Request Maintenance / Perbaikan</h2>
<div class="card"><div class="card-body">
<form method="post" action="/request/maintenance">
    <div class="mb-3"><label>Nama Pelapor</label><input type="text" name="requester_name" class="form-control" required></div>
    <div class="mb-3"><label>Nama Barang/Aset yang Rusak</label><input type="text" name="asset_name" class="form-control" required></div>
    <div class="mb-3"><label>Lokasi</label><input type="text" name="location" class="form-control" required></div>
    <div class="mb-3"><label>Deskripsi Kerusakan</label><textarea name="description" class="form-control" required></textarea></div>
    <button type="submit" class="btn btn-warning">Kirim Request</button>
</form>
</div></div>
<?= $this->endSection() ?>
