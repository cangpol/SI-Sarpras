<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Header -->
            <div class="text-center mb-5">
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 fw-semibold small mb-2 d-inline-block">
                    <i class="bi bi-shield-check me-1"></i> KEPATUHAN REGULASI UU PDP NO. 27 TAHUN 2022
                </span>
                <h2 class="fw-bold display-6 mb-2" style="color: var(--primary-blue);">Kebijakan Privasi &amp; Perlindungan Data Pribadi</h2>
                <p class="text-muted">Biro Sarana dan Prasarana &bull; Universitas Pignatelli Triputra Surakarta</p>
                <small class="text-secondary">Pembaruan Terakhir: 21 Oktober 2026</small>
            </div>

            <!-- Card Konten Kebijakan Privasi -->
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <div class="privacy-content lh-lg text-dark">
                    <!-- 1. Pendahuluan -->
                    <div class="mb-5">
                        <h4 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-lock2 fs-4"></i>
                            <span>1. Komitmen &amp; Landasan Hukum</span>
                        </h4>
                        <p class="text-muted">
                            Universitas Pignatelli Triputra (UPITRA), melalui Biro Sarana dan Prasarana (Sarpras) serta Biro Information Technology (IT), berkomitmen penuh untuk melindungi hak privasi dan keamanan data pribadi seluruh civitas akademika (dosen, mahasiswa, tenaga kependidikan) serta para pengunjung (tamu dinas, rekanan industri, masyarakat umum) sesuai dengan amanat <strong>Undang-Undang Republik Indonesia Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP)</strong>.
                        </p>
                    </div>

                    <!-- 2. Data yang Dikumpulkan -->
                    <div class="mb-5">
                        <h4 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-person-lines-fill fs-4"></i>
                            <span>2. Data Pribadi yang Kami Kumpulkan</span>
                        </h4>
                        <p class="text-muted mb-3">
                            Kami hanya mengumpulkan data pribadi yang relevan, spesifik, dan terbatas sesuai dengan kebutuhan operasional pelayanan kampus (prinsip minimalisasi data), meliputi:
                        </p>
                        <ul class="text-muted ps-3">
                            <li class="mb-2"><strong>Registrasi Visitor ID Pass (Buku Tamu):</strong> Nama pengunjung, nama institusi/perusahaan, nomor kontak/WhatsApp (untuk verifikasi keamanan di pos jaga), tujuan kunjungan, serta pejabat/host kampus yang dituju.</li>
                            <li class="mb-2"><strong>Layanan Lost &amp; Found (Barang Hilang / Ditemukan):</strong> Nama pelapor/penemu, status civitas/tamu, deskripsi barang, waktu dan lokasi kejadian, serta nomor kontak aktif untuk verifikasi serah terima barang di loket fisik Sarpras.</li>
                            <li class="mb-2"><strong>Peminjaman Fasilitas &amp; Permohonan Sarpras:</strong> Nama pemohon, Nomor Induk Mahasiswa/NIDN/NIP, email resmi institusi, fakultas/departemen, rincian kegiatan, dan tanda bukti digital.</li>
                            <li class="mb-2"><strong>Autentikasi Single Sign-On (SSO):</strong> Nama lengkap, email institusi (@upitra.ac.id / @student.upitra.ac.id), dan atribut akun terverifikasi dari Microsoft Entra ID.</li>
                        </ul>
                    </div>

                    <!-- 3. Prinsip Masking & Perlindungan Data Publik -->
                    <div class="mb-5 p-4 rounded-3 bg-light border border-primary border-opacity-25">
                        <h4 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-eye-slash-fill fs-4"></i>
                            <span>3. Kebijakan Privasi Tampilan Publik (Data Masking)</span>
                        </h4>
                        <p class="text-muted mb-2">
                            Untuk mencegah penyalahgunaan nomor kontak, kebocoran data pribadi (*doxxing*), atau pengiriman pesan spam oleh pihak ketiga:
                        </p>
                        <ul class="text-muted mb-0 ps-3">
                            <li class="mb-2"><strong>Nomor Kontak / WhatsApp TIDAK PERNAH Ditampilkan di Publik:</strong> Seluruh nomor telepon dan kontak yang diinputkan dalam formulir pelaporan tidak diekspos di web terbuka dan hanya dapat diakses oleh petugas verifikasi Sarpras yang berwenang.</li>
                            <li class="mb-2"><strong>Penyamaran Nama (Inisial):</strong> Daftar publik barang hilang hanya menampilkan inisial pelapor (contoh: <em>B. S.</em>) demi menjaga kerahasiaan identitas.</li>
                            <li class="mb-0"><strong>Buku Tamu Terisolasi di Area Admin:</strong> Daftar lengkap pengunjung kampus tidak dapat diakses oleh publik dan dipindahkan sepenuhnya ke dalam portal otorisasi petugas internal demi keamanan keamanan fisik kampus.</li>
                        </ul>
                    </div>

                    <!-- 4. Keamanan Sistem & Enkripsi -->
                    <div class="mb-5">
                        <h4 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill fs-4"></i>
                            <span>4. Keamanan Penyimpanan &amp; Retensi Data</span>
                        </h4>
                        <p class="text-muted">
                            Data pribadi Anda disimpan pada basis data terenkripsi dengan proteksi firewall ketat, rate limiting anti-brute force, dan pemantauan log audit keamanan (*Security Audit Log*). Kredensial akun dikelola dengan enkripsi hash Bcrypt standar industri. Data kunjungan dan tiket disortir secara berkala dan hanya disimpan selama diperlukan untuk audit operasional universitas.
                        </p>
                    </div>

                    <!-- 5. Hak Subjek Data -->
                    <div class="mb-5">
                        <h4 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-award fs-4"></i>
                            <span>5. Hak-Hak Anda sebagai Pemilik Data</span>
                        </h4>
                        <p class="text-muted mb-3">
                            Sesuai dengan UU PDP, Anda memiliki hak untuk:
                        </p>
                        <ul class="text-muted ps-3">
                            <li class="mb-2">Memperoleh informasi mengenai kejelasan identitas, dasar kepentingan hukum, dan tujuan permintaan data pribadi Anda.</li>
                            <li class="mb-2">Mengakses dan memperoleh salinan data pribadi Anda yang terdaftar pada sistem SI-Sarpras.</li>
                            <li class="mb-2">Meminta pembaruan atau perbaikan data jika terdapat ketidakakuratan data.</li>
                            <li class="mb-0">Mengajukan penghapusan atau pemusnahan data kunjungan jika masa kunjungan dinas telah selesai dan tidak ada kewajiban hukum yang mengikat.</li>
                        </ul>
                    </div>

                    <!-- 6. Narahubung DPO / Biro IT -->
                    <div class="pt-4 border-top">
                        <h4 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-check-fill fs-4"></i>
                            <span>6. Narahubung Perlindungan Data</span>
                        </h4>
                        <p class="text-muted mb-3">
                            Jika Anda memiliki pertanyaan, pengaduan, atau ingin menggunakan hak-hak perlindungan data pribadi Anda, silakan hubungi tim pengelola resmi kami:
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <strong class="d-block text-dark">Biro Information Technology (IT)</strong>
                                    <small class="text-muted d-block">Pengelola Keamanan Sistem &amp; Infrastruktur</small>
                                    <div class="mt-2 text-primary small">
                                        <i class="bi bi-envelope-at me-1"></i> it@upitra.ac.id
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3 bg-light border">
                                    <strong class="d-block text-dark">Biro Sarana dan Prasarana (Sarpras)</strong>
                                    <small class="text-muted d-block">Loket Fisik: Gedung 4, Lantai 1 (Samping Auditorium)</small>
                                    <div class="mt-2 text-primary small">
                                        <i class="bi bi-envelope-at me-1"></i> sarpras@upitra.ac.id
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center pt-5 mt-4 border-top">
                    <a href="/" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
