<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2 class="mb-4">Peminjaman Kendaraan</h2>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form method="post" action="/peminjaman/kendaraan">
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Tanggal Peminjaman</label>
                    <input type="date" name="booking_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Hari Peminjaman</label>
                    <input type="text" name="booking_day" class="form-control" placeholder="Contoh: Senin" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Pilih Kendaraan</label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Kendaraan --</option>
                        <?php foreach($vehicles as $v): ?>
                            <option value="<?= $v['id'] ?>"><?= $v['vehicle_name'] ?> (<?= $v['plate_number'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Keluar</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Masuk</label>
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
                <label class="form-label fw-bold">Tujuan</label>
                <input type="text" name="destination" class="form-control" placeholder="Tujuan Perjalanan" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Keterangan</label>
                <textarea name="description" class="form-control" rows="2" placeholder="Keterangan keperluan (Opsional)"></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Nama Driver</label>
                    <input type="text" name="driver_name" class="form-control" placeholder="Nama Supir" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Km Out (Awal)</label>
                    <input type="number" name="km_out" class="form-control" placeholder="Kilometer saat keluar">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Km In (Akhir)</label>
                    <input type="number" name="km_in" class="form-control" placeholder="Kilometer saat kembali">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Submit Peminjaman Kendaraan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
