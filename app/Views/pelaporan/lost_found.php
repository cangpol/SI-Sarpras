<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2>Laporan Lost & Found</h2>
<div class="card"><div class="card-body">
<form method="post" action="/pelaporan/lost-found">
    <div class="mb-3"><label>Nama Barang</label><input type="text" name="item_name" class="form-control" required></div>
    <div class="mb-3"><label>Lokasi Ditemukan</label><input type="text" name="location_found" class="form-control" required></div>
    <div class="mb-3"><label>Nama Penemu</label><input type="text" name="finder_name" class="form-control" required></div>
    <div class="mb-3"><label>Kontak Penemu (No HP)</label><input type="text" name="contact" class="form-control" required></div>
    <div class="mb-3"><label>Deskripsi Tambahan</label><textarea name="description" class="form-control"></textarea></div>
    <button type="submit" class="btn btn-primary">Submit Laporan</button>
</form>
</div></div>
<?= $this->endSection() ?>
