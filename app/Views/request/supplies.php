<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- CDN Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--single {
    height: 42px !important;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 40px;
    color: #212529;
    padding-left: 12px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px;
    right: 8px;
}
.select2-dropdown {
    border-radius: 8px;
    border: 1px solid #ced4da;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.item-card {
    transition: all 0.2s ease;
    border: 1px solid #e9ecef;
}
.item-card:hover {
    border-color: #b6d4fe;
    background-color: #f8fbff !important;
}
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Permohonan Supplies (ATK)</h2>
        <p class="text-muted mb-0">Formulir pengajuan permintaan alat tulis kantor dan barang operasional unit/bagian.</p>
    </div>
    <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; Kembali ke Beranda
    </a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div><?= session()->getFlashdata('message') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <form method="post" action="/request/supplies" id="formSupplies">
            <?= csrf_field() ?>
            
            <h5 class="fw-bold mb-3 text-primary">
                <i class="bi bi-person-lines-fill me-2"></i>Informasi Pemohon
            </h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email Pemohon</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@pignatelli.ac.id" value="<?= old('email') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="requester_name" class="form-control" placeholder="Nama Lengkap Peminta" value="<?= old('requester_name') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Unit Kerja / Department</label>
                    <input type="text" name="department" class="form-control" placeholder="Contoh: IT, SDM, LPPM, Dosen" value="<?= old('department') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Date Requested (Tanggal Pengajuan)</label>
                    <input type="date" name="date_requested" class="form-control" required value="<?= old('date_requested') ?: date('Y-m-d') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Date Needed (Dibutuhkan Tanggal)</label>
                    <input type="date" name="date_needed" class="form-control" required value="<?= old('date_needed') ?>">
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <!-- BAGIAN DAFTAR MULTI-ITEM -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div>
                    <h5 class="fw-bold mb-1 text-primary">
                        <i class="bi bi-boxes me-2"></i>Daftar Barang (Bisa Lebih dari 1 Item)
                    </h5>
                    <small class="text-muted">Pilih satu atau lebih barang yang ingin diajukan sekaligus dalam satu formulir.</small>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" id="btnAddRowTop">
                    + Tambah Barang Lagi
                </button>
            </div>

            <!-- CONTAINER LIST ITEM -->
            <div id="itemsList">
                <!-- Baris 1 (Default) -->
                <div class="card p-3 mb-3 rounded-3 item-card bg-light bg-opacity-25" id="itemRow_0">
                    <div class="row align-items-end g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold small mb-1">
                                <span class="badge bg-primary me-1 item-badge">Item #1</span> Pilih Barang
                            </label>
                            <select name="items[0][supply_id]" class="form-control select2-item w-100" required>
                                <option value="" disabled selected>-- Cari dan Pilih Barang --</option>
                                <?php foreach($supplies as $s): ?>
                                    <option value="<?= $s['id'] ?>">
                                        <?= esc($s['item_name']) ?> (Stok: <?= esc($s['stock']) ?> <?= esc($s['unit']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-8">
                            <label class="form-label fw-semibold small mb-1">Jumlah (Qty)</label>
                            <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required placeholder="Jml">
                        </div>
                        <div class="col-md-2 col-4 text-end">
                            <button type="button" class="btn btn-outline-danger w-100 btn-remove-row disabled" onclick="removeRow(0)" title="Hapus baris ini">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Tambah Barang Baris Bawah -->
            <div class="mb-4">
                <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-semibold" id="btnAddRowBottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    + Tambah Item Barang Lain
                </button>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i> Pastikan seluruh barang dan jumlah kebutuhan telah sesuai sebelum mengirim.
                </span>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill" style="font-size: 1.05rem;">
                    Kirim Permohonan Supplies
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Template options supplies untuk dipakai di baris baru -->
<script>
var suppliesOptionsHtml = `
    <option value="" disabled selected>-- Cari dan Pilih Barang --</option>
    <?php foreach($supplies as $s): ?>
        <option value="<?= $s['id'] ?>">
            <?= esc(addslashes($s['item_name'])) ?> (Stok: <?= esc($s['stock']) ?> <?= esc($s['unit']) ?>)
        </option>
    <?php endforeach; ?>
`;

var rowIndex = 1;

function initSelect2(selector) {
    $(selector).select2({
        placeholder: '-- Cari dan Pilih Barang --',
        allowClear: true,
        width: '100%'
    });
}

function updateBadgesAndButtons() {
    var rows = $('#itemsList .item-card');
    rows.each(function(index) {
        $(this).find('.item-badge').text('Item #' + (index + 1));
        var removeBtn = $(this).find('.btn-remove-row');
        if (rows.length === 1) {
            removeBtn.addClass('disabled').css('opacity', '0.5');
        } else {
            removeBtn.removeClass('disabled').css('opacity', '1');
        }
    });
}

function addNewRow() {
    var newRowHtml = `
        <div class="card p-3 mb-3 rounded-3 item-card bg-light bg-opacity-25" id="itemRow_${rowIndex}">
            <div class="row align-items-end g-3">
                <div class="col-md-7">
                    <label class="form-label fw-semibold small mb-1">
                        <span class="badge bg-primary me-1 item-badge">Item</span> Pilih Barang
                    </label>
                    <select name="items[${rowIndex}][supply_id]" class="form-control select2-item w-100" required>
                        ${suppliesOptionsHtml}
                    </select>
                </div>
                <div class="col-md-3 col-8">
                    <label class="form-label fw-semibold small mb-1">Jumlah (Qty)</label>
                    <input type="number" name="items[${rowIndex}][quantity]" class="form-control" min="1" value="1" required placeholder="Jml">
                </div>
                <div class="col-md-2 col-4 text-end">
                    <button type="button" class="btn btn-outline-danger w-100 btn-remove-row" onclick="removeRow(${rowIndex})" title="Hapus baris ini">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    `;

    $('#itemsList').append(newRowHtml);
    initSelect2('#itemRow_' + rowIndex + ' .select2-item');
    rowIndex++;
    updateBadgesAndButtons();
}

function removeRow(id) {
    if ($('#itemsList .item-card').length > 1) {
        $('#itemRow_' + id).remove();
        updateBadgesAndButtons();
    }
}

$(document).ready(function() {
    initSelect2('#itemRow_0 .select2-item');
    updateBadgesAndButtons();

    $('#btnAddRowTop, #btnAddRowBottom').on('click', function(e) {
        e.preventDefault();
        addNewRow();
    });
});
</script>

<?= $this->endSection() ?>
