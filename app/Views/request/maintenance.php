<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h2 class="mb-4">Request Maintenance</h2>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form method="post" action="/request/maintenance">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Peminjam / Pelapor</label>
                    <input type="text" name="requester_name" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Department</label>
                    <select name="department" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Department --</option>
                        <?php 
                        $departments = ['Finance', 'SDM', 'LPPM', 'LPM', 'Kerjasama', 'IT', 'Kemahasiswaan', 'BAA', 'Marketing', 'Rektorat', 'Sekretariat', 'FEB', 'FSH', 'FST', 'Yayasan & Ten', 'Sarpras', 'Mahasiswa', 'Security', 'CS'];
                        foreach($departments as $dept): ?>
                            <option value="<?= $dept ?>"><?= $dept ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Lokasi Kerusakan</label>
                    <input type="text" name="location" class="form-control" placeholder="Contoh: Ruang Kelas 101, Gedung A" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Fasilitas</label>
                    <select name="facility" id="facilitySelect" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Fasilitas --</option>
                        <option value="Lampu">Lampu</option>
                        <option value="AC">AC</option>
                        <option value="Air">Air</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3" id="facilityOtherDiv" style="display: none;">
                <label class="form-label fw-bold">Tulis Fasilitas Lainnya</label>
                <input type="text" name="facility_other" id="facilityOtherInput" class="form-control" placeholder="Sebutkan fasilitas yang rusak">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Keterangan Kerusakan</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail kerusakan" required></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Submit Request Maintenance</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('facilitySelect').addEventListener('change', function() {
    var otherDiv = document.getElementById('facilityOtherDiv');
    var otherInput = document.getElementById('facilityOtherInput');
    if (this.value === 'Others') {
        otherDiv.style.display = 'block';
        otherInput.setAttribute('required', 'required');
    } else {
        otherDiv.style.display = 'none';
        otherInput.removeAttribute('required');
    }
});
</script>
<?= $this->endSection() ?>
