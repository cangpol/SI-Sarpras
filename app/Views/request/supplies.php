<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2>Request Supplies (ATK)</h2>
<div class="card"><div class="card-body">
<form method="post" action="/request/supplies">
    <div class="mb-3"><label>Nama Peminta</label><input type="text" name="requester_name" class="form-control" required></div>
    <div class="mb-3"><label>Pilih Barang / ATK</label>
        <select name="supply_id" class="form-control">
            <?php foreach($supplies as $s): ?>
                <option value="<?= $s['id'] ?>"><?= $s['item_name'] ?> (Stok: <?= $s['stock'] ?> <?= $s['unit'] ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Jumlah yang Diminta</label><input type="number" name="quantity" class="form-control" min="1" required></div>
    <div class="mb-3"><label>Alasan Keperluan</label><textarea name="reason" class="form-control" required></textarea></div>
    <button type="submit" class="btn btn-warning">Kirim Request</button>
</form>
</div></div>
<?= $this->endSection() ?>
