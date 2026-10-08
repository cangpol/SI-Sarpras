# 🔄 Delta Update 3: Admin CRUD Integration, Conflict Prevention & Report Exports

> **Catatan**: File ini khusus berisi daftar tugas pembaruan Delta 3 untuk dieksekusi di VS Code menggunakan Antigravity. File ini berasumsi tugas pada `tasks.md` dan `tasks-2.md` sebelumnya telah selesai dieksekusi.

---

### 📌 Delta 3.1: Complete Admin Master Data CRUD
- [ ] **M3.1 Master Ruangan CRUD (`Admin\RoomsController`)**
  - Implementasi fungsi `create`, `store`, `edit`, `update`, `delete` (atau soft-delete) master ruangan.
  - Form pendataan kapasitas, fasilitas (sound system, proyektor, dll), dan toggle status ketersediaan.
- [ ] **M3.2 Master Kendaraan & Driver CRUD (`Admin\VehiclesController` & `Admin\DriversController`)**
  - Implementasi CRUD lengkap armada mobil (plat nomor, jenis, kapasitas) dan data driver.
- [ ] **M3.3 Master Supplies CRUD (`Admin\SuppliesController`)**
  - Implementasi CRUD katalog ATK/Supplies, penyesuaian stok manual, dan alert batas stok minimum (`min_stock`).

---

### 📌 Delta 3.2: Transactional CRUD & Approval Workflow di Dashboard Admin
- [ ] **T3.1 Approval & Edit Jadwal Peminjaman Ruangan (`Admin\RoomBookingsController`)**
  - Aksi `Approve` / `Reject` pengajuan ruangan dengan input catatan/alasan dari Admin.
  - Aksi `Edit` detail peminjaman (ruangan alternatif, ubah jam/tanggal) dengan proteksi anti-bentrok.
  - Aksi `Delete` / Pembatalan transaksi peminjaman.
- [ ] **T3.2 Approval & Penugasan Driver Peminjaman Mobil (`Admin\VehicleBookingsController`)**
  - Aksi `Approve` + Penugasan Driver, atau `Reject` pengajuan mobil.
  - Fitur penutupan trip: Input KM Awal & KM Akhir setelah kendaraan kembali.
  - Aksi `Delete` / Pembatalan transaksi mobil.
- [ ] **T3.3 Resolution Ticket Maintenance & Security Logging (`Admin\MaintenanceController` & `SecurityController`)**
  - Update status tiket perbaikan (*In Progress* ➔ *Resolved*), alokasi teknisi, & penambahan biaya.
  - Log Visitor ID Pass (Check-in / Check-out) & Verifikasi Berita Acara Klaim Lost and Found.

---

### 📌 Delta 3.3: Scope Tabel Dashboard Bulan Berjalan & Selector Historis
- [ ] **S3.1 Default Query Current Month Filtering**
  - Terapkan scope query default pada semua tabel transaksi dashboard Admin agar hanya menampilkan data bulan berjalan:
    `WHERE MONTH(start_time) = MONTH(CURRENT_DATE()) AND YEAR(start_time) = YEAR(CURRENT_DATE())`
- [ ] **S3.2 Dropdown Selector Periode Historis**
  - Sediakan UI filter Bulan & Tahun di atas tabel dashboard untuk beralih dan melihat arsip laporan bulan sebelumnya.

---

### 📌 Delta 3.4: Engine Anti-Double Booking (Support User Input & Admin Edit)
- [ ] **E3.1 Conflict Detection Query (Include/Exclude Current Record ID)**
  - Sempurnakan logika `isSlotBooked()` agar mendukung pemeriksaan bentrok saat **Admin melakukan Edit**:
    `WHERE asset_id = :asset_id AND id != :current_booking_id AND status != 'Rejected' AND (start_time < :end_time) AND (end_time > :start_time)`
- [ ] **E3.2 Unified Notification Handling**
  - Tangkap exception / error bentrok dan kembalikan pesan seragam:
    *"Jadwal untuk tanggal dan jam tersebut sudah penuh, silahkan cari tanggal atau jam lainnya."*

---

### 📌 Delta 3.5: FullCalendar Engine (User Form Embed & Admin Dashboard Feed)
- [ ] **C3.1 Universal Calendar API Feed (`/api/calendar-events`)**
  - Endpoint JSON yang menggabungkan event peminjaman ruangan dan mobil dalam format standar FullCalendar.
- [ ] **C3.2 Frontend Calendar Embed**
  - Embed FullCalendar interaktif pada Form Peminjaman User (melihat slot kosong secara real-time) dan Dashboard Utama Admin.

---

### 📌 Delta 3.6: Export Data Engine (Excel & PDF)
- [ ] **X3.1 Export Excel Engine (`PhpSpreadsheet`)**
  - Modul download file `.xlsx` untuk tabel Peminjaman Ruangan, Mobil, Maintenance, dan Supplies ter-filter sesuai bulan/tahun yang dipilih.
- [ ] **X3.2 Export PDF Engine (`Dompdf`)**
  - Modul download file `.pdf` ber-kop resmi lembaga untuk laporan rekapitulasi bulanan dan lembar konfirmasi peminjaman.
