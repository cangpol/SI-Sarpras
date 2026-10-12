<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Registrasi Visitor ID Pass</h2>
        <p class="text-muted mb-0">Formulir check-in pengunjung / tamu kampus Universitas Pignatelli Triputra.</p>
    </div>
    <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; Kembali ke Beranda
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="/pelaporan/visitor">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="visitor_name" class="form-control" placeholder="Nama pengunjung" required>
                    </div>

                    <div class="mb-3">
                        <label>Asal Institusi / Perusahaan</label>
                        <input type="text" name="institution" class="form-control" placeholder="Contoh: PT ABC, Universitas XYZ, atau Pribadi" required>
                    </div>

                    <div class="mb-3">
                        <label>No. HP (Aktif/WA)</label>
                        <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <div class="mb-3">
                        <label>Keperluan</label>
                        <select name="purpose" id="purposeStatus" class="form-select" onchange="toggleOtherPurpose()" required>
                            <option value="">-- Pilih Keperluan --</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Kunjungan">Kunjungan</option>
                            <option value="Antar Dokumen">Antar Dokumen</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-3" id="otherPurposeDiv" style="display: none;">
                        <label>Sebutkan Keperluan Anda</label>
                        <input type="text" name="purpose_other" id="otherPurposeInput" class="form-control" placeholder="Ketik tujuan spesifik Anda di sini">
                    </div>

                    <div class="mb-3">
                        <label>Nama yang Dituju (Host)</label>
                        <input type="text" name="host_name" class="form-control" placeholder="Sebutkan nama dosen/staf yang akan ditemui" required>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Check-In Pengunjung</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleOtherPurpose() {
    const purposeSelect = document.getElementById('purposeStatus');
    const otherDiv = document.getElementById('otherPurposeDiv');
    const otherInput = document.getElementById('otherPurposeInput');
    
    if (purposeSelect.value === 'Others') {
        otherDiv.style.display = 'block';
        otherInput.required = true;
    } else {
        otherDiv.style.display = 'none';
        otherInput.required = false;
        otherInput.value = '';
    }
}
</script>
<?= $this->endSection() ?>
