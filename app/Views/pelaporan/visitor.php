<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2>Registrasi Visitor ID Pass</h2>
<div class="card"><div class="card-body">
<form method="post" action="/pelaporan/visitor">
    <div class="mb-3"><label>Nama Pengunjung</label><input type="text" name="visitor_name" class="form-control" required></div>
    <div class="mb-3"><label>Jenis Identitas</label>
        <select name="id_type" class="form-control"><option>KTP</option><option>SIM</option></select>
    </div>
    <div class="mb-3"><label>Nomor Identitas</label><input type="text" name="id_number" class="form-control" required></div>
    <div class="mb-3"><label>Tujuan / Keperluan</label><textarea name="purpose" class="form-control" required></textarea></div>
    <div class="mb-3"><label>Tuan Rumah (Host)</label><input type="text" name="host_name" class="form-control" required></div>
    <button type="submit" class="btn btn-primary">Check-In Pengunjung</button>
</form>
</div></div>
<?= $this->endSection() ?>
