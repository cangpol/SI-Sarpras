<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Form Pelaporan Kehilangan Barang</h2>
        <p class="text-muted mb-0">Layanan pelaporan barang hilang / tertinggal (Lost & Found) di lingkungan kampus.</p>
    </div>
    <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; Kembali ke Beranda
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="/pelaporan/lost-found">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label>Nama Pelapor</label>
                        <input type="text" name="reporter_name" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
                    </div>

                    <div class="mb-3">
                        <label>Status Pelapor</label>
                        <select name="reporter_status" id="reporterStatus" class="form-select" onchange="toggleOtherStatus()" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Tendik">Tendik</option>
                            <option value="Tamu">Tamu</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-3" id="otherStatusDiv" style="display: none;">
                        <label>Sebutkan Status Anda</label>
                        <input type="text" name="reporter_status_other" id="otherStatusInput" class="form-control" placeholder="Ketik status Anda di sini">
                    </div>

                    <div class="mb-3">
                        <label>Barang yang Hilang</label>
                        <input type="text" name="lost_item" class="form-control" placeholder="Deskripsikan barang yang hilang secara singkat" required>
                    </div>

                    <div class="mb-3">
                        <label>No. HP Pelapor (Aktif/WA)</label>
                        <input type="text" name="contact" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Kejadian</label>
                            <input type="date" name="incident_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Waktu Kejadian</label>
                            <input type="time" name="incident_time" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Kirim Laporan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleOtherStatus() {
    const statusSelect = document.getElementById('reporterStatus');
    const otherDiv = document.getElementById('otherStatusDiv');
    const otherInput = document.getElementById('otherStatusInput');
    
    if (statusSelect.value === 'Others') {
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
