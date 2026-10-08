<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Tambahkan CDN Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Tambahkan sedikit kustomisasi untuk Select2 Bootstrap 5 Theme -->
<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    color: #212529;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
</style>

<h2 class="mb-4">Request Supplies (ATK)</h2>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form method="post" action="/request/supplies">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email aktif" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="requester_name" class="form-control" placeholder="Nama peminta" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Unit Kerja / Department</label>
                    <input type="text" name="department" class="form-control" placeholder="Contoh: IT, SDM, dll" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Date Requested</label>
                    <input type="date" name="date_requested" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Date Needed</label>
                    <input type="date" name="date_needed" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-bold">Items (Pilih Barang)</label>
                    <select name="supply_id" id="itemSelect" class="form-control w-100" required>
                        <option value="" disabled selected>-- Cari dan Pilih Barang --</option>
                        <?php foreach($supplies as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['item_name'] ?> (Stok: <?= $s['stock'] ?> <?= $s['unit'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Jumlah (Quantity)</label>
                    <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Submit Request Supplies</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#itemSelect').select2({
        placeholder: '-- Cari dan Pilih Barang --',
        allowClear: true,
        width: '100%'
    });
});
</script>
<?= $this->endSection() ?>
