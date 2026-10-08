# 🚀 Backend Roadmap: SIM Sarpras (CodeIgniter 4)

### 📌 Fase 1: Setup Project & Konfigurasi Environment
- [ ] **1.1 Inisialisasi CI 4 Project**
  - Install CodeIgniter 4 via Composer atau App Starter.
  - Atur struktur folder dan pastikan `.gitignore` mencakup `.env` dan folder `writable/`.
- [ ] **1.2 Konfigurasi Environment (`.env`)**
  - Set `CI_ENVIRONMENT = development`.
  - Konfigurasi `app.baseURL` dan timezone (`Asia/Jakarta`).
  - Set koneksi database MariaDB/MySQL Synology NAS (Host, Port, Username, Password, Database Name).
  - Atur `session.driver = DatabaseHandler` atau `FileHandler`.

---

### 📌 Fase 2: Database Migrations & Seeders
- [ ] **2.1 Buat Migration Tabel Otentikasi & Pengguna**
  - Tabel `roles` (`id`, `role_name`).
  - Tabel `departments` (`id`, `department_name`).
  - Tabel `users` (`id`, `role_id`, `department_id`, `name`, `email`, `password_hash`, `status`).
- [ ] **2.2 Buat Migration Modul Security**
  - Tabel `visitors` (`id`, `visitor_code`, `name`, `company`, `phone`, `purpose`, `host_person`, `check_in`, `check_out`, `status`).
  - Tabel `lost_found` (`id`, `item_name`, `category`, `location_found`, `photo`, `status`, `finder_name`, `claimed_by`, `claimed_at`).
- [ ] **2.3 Buat Migration Modul Peminjaman Ruangan**
  - Tabel `rooms` (`id`, `room_code`, `room_name`, `capacity`, `location`, `facilities`, `status`).
  - Tabel `room_bookings` (`id`, `booking_code`, `user_id`, `room_id`, `event_name`, `start_time`, `end_time`, `total_attendees`, `notes`, `status`, `approved_by`).
- [ ] **2.4 Buat Migration Modul Maintenance Request**
  - Tabel `maintenance_requests` (`id`, `ticket_code`, `user_id`, `location`, `asset_name`, `description`, `photo`, `priority`, `technician_id`, `status`, `cost`, `created_at`).
- [ ] **2.5 Buat Migration Modul Peminjaman Mobil**
  - Tabel `vehicles` (`id`, `vehicle_name`, `plate_number`, `capacity`, `status`).
  - Tabel `drivers` (`id`, `driver_name`, `phone`, `status`).
  - Tabel `vehicle_bookings` (`id`, `booking_code`, `user_id`, `vehicle_id`, `driver_id`, `destination`, `departure_time`, `return_time`, `start_km`, `end_km`, `status`, `approved_by`).
- [ ] **2.6 Buat Migration Modul Supplies Request**
  - Tabel `supplies` (`id`, `item_code`, `item_name`, `category`, `stock`, `unit`, `min_stock`).
  - Tabel `supply_requests` (`id`, `request_code`, `user_id`, `status`, `approved_by`, `created_at`).
  - Tabel `supply_request_items` (`id`, `request_id`, `supply_id`, `quantity`).
- [ ] **2.7 Buat Database Seeders**
  - Seeder default roles (`Super Admin`, `Admin Sarpras`, `Petugas Security`, `Dosen`, `Mahasiswa`, `Teknisi`).
  - Seeder akun awal (1 Super Admin, 1 Dosen, 1 Mahasiswa, 1 Security).
  - Seeder master ruangan (**Excellence**, **Compassion**, **Integrity**, **Auditorium**, **Multi Function Hall**).

---

### 📌 Fase 3: Autentikasi & Middleware (RBAC & Isolasi Data)
- [ ] **3.1 Auth Controller & Models**
  - Buat `UserModel` dan `AuthControler` (Fungsi `login`, `authenticate`, `logout`).
  - Implementasi hashing password menggunakan `password_hash()`.
- [ ] **3.2 Filter Autentikasi & Otorisasi**
  - `AuthFilter.php`: Cek session user, cegah akses jika belum login.
  - `RoleFilter.php`: Cek peran user (`admin`, `dosen`, `mahasiswa`, `security`).
- [ ] **3.3 Base Controller / Service Scoping Data**
  - Buat helper/trait untuk mengecek role:
    - Jika **User (Dosen/Mahasiswa)**: Otomatis tambahkan `.where('user_id', session('user_id'))` pada query pembacaan data.
    - Jika **Admin**: Query dibuka penuh tanpa restriction `user_id`.
    - Proteksi metode `update()` dan `delete()` di controller agar hanya dapat diproses jika role adalah **Admin**.

---

### 📌 Fase 4: Business Logic & Controllers Modul
- [ ] **4.1 Modul Security API / Backend Logic**
  - API Visitor Pass: Check-in, Check-out, List Tamu Aktif.
  - API Lost & Found: Pencatatan barang, Upload foto, Klaim barang.
- [ ] **4.2 Modul Peminjaman Ruangan API / Backend Logic**
  - Validasi bentrok jadwal (Cek overlapping `start_time` & `end_time` pada ruangan yang sama).
  - Workflow Pengajuan oleh User & Approval/Rejection oleh Admin.
- [ ] **4.3 Modul Maintenance Request API / Backend Logic**
  - Form pengajuan tiket perbaikan + upload foto bukti kerusakan.
  - Penugasan teknisi & update status perbaikan oleh Admin/Teknisi.
- [ ] **4.4 Modul Peminjaman Mobil API / Backend Logic**
  - Validasi ketersediaan armada dan driver.
  - Pengajuan trip, approval, dan pencatatan logbook (KM awal/akhir).
- [ ] **4.5 Modul Supplies Request API / Backend Logic**
  - Katalog barang + pengecekan ketersediaan stok (`stock >= requested_qty`).
  - Pengajuan barang + pengurangan stok otomatis saat status disetujui (*Approved*).

---

### 📌 Fase 5: API Dashboard & Feed Kalender Admin
- [ ] **5.1 Feed Event Kalender (FullCalendar Endpoint)**
  - Buat `DashboardController::getCalendarEvents()`.
  - Gabungkan data `room_bookings` dan `vehicle_bookings` ke dalam format JSON standard FullCalendar (`id`, `title`, `start`, `end`, `color`, `type`).
- [ ] **5.2 API Ringkasan Statistik Dashboard**
  - Total pending approvals ruangan & mobil.
  - Total pengunjung aktif hari ini.
  - Total tiket maintenance status *In Progress*.
  - Warning stok supplies yang di bawah `min_stock`.

---

### 📌 Fase 6: Testing & Preparasi Deploy Synology NAS
- [ ] **6.1 Unit & Integration Testing**
  - Uji alur pencegahan *double booking* pada ruangan.
  - Uji isolasi akses: pastikan Mahasiswa A tidak dapat melihat/mengubah data Dosen A melalui direct URL.
- [ ] **6.2 Deployment di Synology NAS**
  - Import seluruh schema database via phpMyAdmin.
  - Upload source code ke Synology NAS (`/volume1/web/sim-sarpras`).
  - Arahkan Virtual Host di **Web Station** ke folder `/volume1/web/sim-sarpras/public`.
  - Set hak akses folder `writable/` agar PHP Web Station memiliki akses *write/permission*.
