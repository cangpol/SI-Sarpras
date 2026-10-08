# 🔄 Delta Updates & Enhancements: SIM Sarpras (CodeIgniter 4)

> **Catatan**: File ini khusus berisi daftar tugas pembaruan & fitur tambahan (Delta) setelah eksekusi `tasks.md` awal. Gunakan file ini pada Antigravity VS Code untuk mengeksekusi fitur lanjutan.

---

### 📌 Delta Update 1: Algoritma & Modul Anti-Double Booking (Ruangan & Mobil)
- [ ] **D1.1 Validation Helper / Trait Anti Overlap**
  - Buat fungsi helper/trait `isSlotBooked($resourceId, $startTime, $endTime, $type)` untuk validasi ketersediaan jadwal.
  - Implementasikan klausa SQL Overlap:
    `WHERE resource_id = :id AND status != 'Rejected' AND (start_time < :end_time) AND (end_time > :start_time)`
- [ ] **D1.2 Notifikasi & Intersepsi Form User**
  - Pasang validasi pada `RoomBookingController::store()` dan `VehicleBookingController::store()`.
  - Jika bentrok, kembalikan respon error flash message:
    *"Jadwal untuk tanggal dan jam tersebut sudah penuh, silahkan cari tanggal atau jam lainnya."*

---

### 📌 Delta Update 2: Embed Kalender Ketersediaan di Form Peminjaman User
- [ ] **D2.1 API Endpoint Slot Terisi (AJAX Fetcher)**
  - Buat API `/api/booked-slots` yang menerima parameter `room_id` atau `vehicle_id` dan mengembalikan JSON jadwal terisi.
- [ ] **D2.2 Frontend Integration (FullCalendar Embed)**
  - Pasang widget **FullCalendar.js** di sebelah/atas form peminjaman ruangan dan mobil.
  - Hubungkan perubahan dropdown pilihan ruangan/mobil dengan event AJAX fetcher agar slot kosong/terisi tampil real-time sebelum user mengisi jam.

---

### 📌 Delta Update 3: Filter Bulan Berjalan Pada Dashboard Admin
- [ ] **D3.1 Query Table Dashboard (Current Month Filtering)**
  - Set default query tabel peminjaman ruangan & mobil ter-filter otomatis berdasarkan bulan & tahun berjalan:
    `WHERE MONTH(start_time) = MONTH(CURRENT_DATE()) AND YEAR(start_time) = YEAR(CURRENT_DATE())`
- [ ] **D3.2 Filter Selector Periode**
  - Tambahkan dropdown pilihan Bulan & Tahun pada header tabel dashboard Admin agar Admin tetap dapat membuka arsip data bulan sebelumnya.

---

### 📌 Delta Update 4: Fitur Export Data (Excel & PDF)
- [ ] **D4.1 Export Excel Engine (PhpSpreadsheet)**
  - Install `phpoffice/phpspreadsheet`.
  - Buat controller & service generator file `.xlsx` untuk tabel Peminjaman Ruangan, Peminjaman Mobil, Maintenance, dan Supplies.
- [ ] **D4.2 Export PDF Engine (Dompdf)**
  - Install `dompdf/dompdf`.
  - Buat view template PDF ber-kop resmi dan controller generator download file `.pdf` per tabel.

---

### 📌 Delta Update 5: Integrasi Lengkap CRUD Admin Tanpa Kendala
- [ ] **D5.1 Master Data CRUD Admin**
  - Pastikan Admin memiliki akses penuh Create, Read (Datatable), Update, & Delete pada Master Ruangan, Master Mobil, Master Driver, dan Master Supplies.
- [ ] **D5.2 Transactional CRUD & Approval Workflow**
  - Admin dapat mengubah status (`Approve` / `Reject`), mengedit jadwal/ruangan alternatif, serta membatalkan/menghapus transaksi secara aman.
