<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2>Peminjaman Ruangan</h2>
<div class="card"><div class="card-body">
<form method="post" action="/peminjaman/ruangan">
    <div class="mb-3"><label>Nama Peminjam</label><input type="text" name="booker_name" class="form-control" required></div>
    <div class="mb-3"><label>Nama Acara</label><input type="text" name="event_name" class="form-control" required></div>
    <div class="mb-3"><label>Pilih Ruangan</label>
        <select name="room_id" class="form-control">
            <?php foreach($rooms as $r): ?>
                <option value="<?= $r['id'] ?>"><?= $r['room_name'] ?> (Kapasitas: <?= $r['capacity'] ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Waktu Mulai</label><input type="datetime-local" name="start_time" class="form-control" required></div>
    <div class="mb-3"><label>Waktu Selesai</label><input type="datetime-local" name="end_time" class="form-control" required></div>
    <button type="submit" class="btn btn-success">Ajukan Peminjaman</button>
</form>
</div></div>
<?= $this->endSection() ?>
