<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2>Peminjaman Kendaraan</h2>
<div class="card"><div class="card-body">
<form method="post" action="/peminjaman/kendaraan">
    <div class="mb-3"><label>Nama Peminjam</label><input type="text" name="booker_name" class="form-control" required></div>
    <div class="mb-3"><label>Tujuan</label><input type="text" name="destination" class="form-control" required></div>
    <div class="mb-3"><label>Pilih Kendaraan</label>
        <select name="vehicle_id" class="form-control">
            <?php foreach($vehicles as $v): ?>
                <option value="<?= $v['id'] ?>"><?= $v['vehicle_name'] ?> (<?= $v['plate_number'] ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Waktu Keberangkatan</label><input type="datetime-local" name="start_time" class="form-control" required></div>
    <div class="mb-3"><label>Waktu Kepulangan</label><input type="datetime-local" name="end_time" class="form-control" required></div>
    <button type="submit" class="btn btn-success">Ajukan Peminjaman</button>
</form>
</div></div>
<?= $this->endSection() ?>
