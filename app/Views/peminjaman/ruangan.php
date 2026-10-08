<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2 class="mb-4">Peminjaman Ruangan</h2>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form method="post" action="/peminjaman/ruangan">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Peminjaman</label>
                    <input type="date" name="booking_date" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pilih Ruangan</label>
                    <select name="room_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Ruangan --</option>
                        <?php foreach($rooms as $r): ?>
                            <option value="<?= $r['id'] ?>"><?= $r['room_name'] ?> (Kapasitas: <?= $r['capacity'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Waktu Masuk</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Waktu Keluar</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Peminjam</label>
                    <input type="text" name="booker_name" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Department</label>
                    <input type="text" name="department" class="form-control" placeholder="Department / Bagian" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Event</label>
                <input type="text" name="event_name" class="form-control" placeholder="Nama / Judul Acara" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Set UP (Bentuk Ruangan)</label>
                <input type="text" name="setup" class="form-control" placeholder="Contoh: Class Room, U-Shape, Theater" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Material Needed</label>
                <textarea name="material_needed" class="form-control" rows="2" placeholder="Barang yang dibutuhkan (Opsional)"></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Special Request</label>
                <textarea name="special_request" class="form-control" rows="2" placeholder="Permintaan khusus lainnya (Opsional)"></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Submit Peminjaman Ruangan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
