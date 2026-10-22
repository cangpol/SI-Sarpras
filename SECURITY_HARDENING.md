# Panduan Pengerasan Keamanan (Security Hardening) SI-Sarpras

Dokumen ini berisi standar keamanan server dan PHP runtime untuk aplikasi **SI-Sarpras (Universitas Pembangunan Indonesia Veteran / UPITRA)**, khususnya yang berjalan pada lingkungan **Synology NAS (Web Station)** di domain `https://sarpras.upitra.ac.id`.

---

## 1. Penonaktifan Fungsi Eksekusi Sistem (`disable_functions`)

Aplikasi SI-Sarpras dibangun menggunakan PHP native dan CodeIgniter 4 yang **tidak membutuhkan pemanggilan shell OS (Command Line)** sama sekali pada lingkungan web. Seluruh fitur (SSO Microsoft 365, Captcha GD, Export PDF via browser, Upload Berkas) berjalan menggunakan ekstensi internal PHP.

Untuk mencegah serangan eksekusi kode liar (*Remote Code Execution / RCE*), wajib menonaktifkan fungsi-fungsi berikut pada konfigurasi PHP server:

```ini
disable_functions = exec,system,shell_exec,passthru,popen,proc_open,pcntl_exec,python_eval,dl
```

---

## 2. Penerapan pada Synology NAS (Web Station)

Jika aplikasi di-host di Synology NAS (`sarpras.upitra.ac.id`), ikuti langkah konfigurasi berikut melalui antarmuka web DSM:

### A. Untuk Synology DSM 7.x
1. Buka browser dan login ke **Synology DSM** sebagai Administrator.
2. Buka menu aplikasi dan klik **Web Station**.
3. Klik menu **Web Service** (atau **Web Portal**) di bilah kiri, lalu cek profil PHP yang digunakan oleh domain `sarpras.upitra.ac.id` (misal: `PHP 8.1` atau `PHP 8.2`).
4. Klik menu **Script Language Settings** (*Pengaturan Bahasa Skrip*) di bilah kiri.
5. Pilih profil PHP tersebut, lalu klik tombol **Edit** (*Sunting*).
6. Masuk ke tab **Core** (*Inti*).
7. Pada kolom pencarian di pojok kanan atas, ketik: `disable_functions`.
8. Masukkan nilai:
   ```text
   exec,system,shell_exec,passthru,popen,proc_open,pcntl_exec,python_eval,dl
   ```
9. Klik **Save** (*Simpan*). Web Station akan langsung me-reload PHP-FPM secara otomatis.

### B. Untuk Synology DSM 6.x
1. Buka **Web Station** -> menu **PHP Settings** (*Pengaturan PHP*).
2. Pilih profil PHP yang aktif untuk Virtual Host `sarpras.upitra.ac.id`, lalu klik **Edit**.
3. Masuk ke tab **Advanced Settings** -> tab **Core**.
4. Cari `disable_functions` dan isikan daftar fungsi di atas.
5. Klik **OK** / **Apply**.

---

## 3. Izin Akses Folder (Permissions) di Synology NAS

Web Station di Synology NAS berjalan di bawah akun sistem **`http`** (grup `http`).

Pastikan folder penyimpanan sementara dan log dapat ditulis oleh user `http`:
- `writable/cache/`
- `writable/logs/`
- `writable/session/`
- `writable/uploads/`

> [!TIP]
> Jika mengatur izin via **File Station** di DSM:
> 1. Klik kanan pada folder `writable`, pilih **Properties** -> tab **Permission**.
> 2. Berikan izin **Read & Write** untuk user/grup **`http`**.
> 3. Centang opsi *"Apply to this folder, sub-folders and files"* lalu simpan.

---

## 4. Keamanan Lingkungan & Konfigurasi (.env)

1. Pastikan file `.env` di server memiliki pengaturan:
   ```ini
   CI_ENVIRONMENT = production
   app.baseURL = 'https://sarpras.upitra.ac.id'
   ```
2. Pastikan virtual host / web portal di Synology Web Station menunjuk dokumen root langsung ke folder **`public/`** (BUKAN root repositori), sehingga file sensitif seperti `.env`, `composer.json`, `app/`, dan `writable/` tidak dapat diakses langsung oleh pengunjung melalui browser.

---

## 5. Reverse Proxy & SSL (HTTPS)

Pastikan sertifikat SSL (misalnya Let's Encrypt via DSM Control Panel -> Security -> Certificate) telah dipasang dan dialokasikan untuk domain `sarpras.upitra.ac.id`.
Aplikasi secara otomatis mendeteksi header HTTPS dan mengenkripsi seluruh sesi login SSO Microsoft 365.
