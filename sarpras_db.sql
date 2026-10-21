-- phpMyAdmin SQL Dump
-- Host: localhost
-- Generation Time: Oct 09, 2026

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `lost_found` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reporter_name` varchar(150) NOT NULL,
  `reporter_status` varchar(100) NOT NULL,
  `lost_item` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `incident_date` date NOT NULL,
  `incident_time` time NOT NULL,
  `status` enum('reported','found','claimed') NOT NULL DEFAULT 'reported',
  `admin_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `visitor_name` varchar(150) NOT NULL,
  `institution` varchar(150) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `host_name` varchar(150) NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `status` enum('checked_in','checked_out') NOT NULL DEFAULT 'checked_in',
  `admin_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(150) DEFAULT 'Gedung Utama',
  `status` enum('active','maintenance') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rooms` (`id`, `room_name`, `capacity`, `location`, `status`) VALUES
(1, 'Excellent Meeting Room', 50, 'Gedung A Lantai 2', 'active'),
(2, 'Compassion Meeting Room', 40, 'Gedung A Lantai 2', 'active'),
(3, 'Integrity Meeting Room', 40, 'Gedung B Lantai 1', 'active'),
(4, 'Auditorium', 200, 'Gedung Utama Lantai 3', 'active'),
(5, 'Multi Function Hall', 150, 'Gedung C Lantai Dasar', 'active');

CREATE TABLE IF NOT EXISTS `room_bookings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `room_id` int(11) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `booker_name` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `setup` varchar(255) NOT NULL,
  `material_needed` text DEFAULT NULL,
  `special_request` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_name` varchar(100) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 7,
  `status` enum('available','maintenance') NOT NULL DEFAULT 'available',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `vehicles` (`id`, `vehicle_name`, `plate_number`, `capacity`, `status`) VALUES
(1, 'Toyota Avanza', 'B 1234 ABC', 7, 'available'),
(2, 'Toyota Innova Reborn', 'B 5678 DEF', 8, 'available'),
(3, 'Isuzu Elf Microbus', 'B 9101 GHI', 16, 'available'),
(4, 'Toyota Hiace Commuter', 'AD 8899 UP', 14, 'available');

CREATE TABLE IF NOT EXISTS `vehicle_bookings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `vehicle_id` int(11) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `booking_day` varchar(50) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `booker_name` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `driver_name` varchar(150) NOT NULL,
  `km_in` int(11) DEFAULT NULL,
  `km_out` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `maintenance_requests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `requester_name` varchar(150) NOT NULL,
  `department` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `facility` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `supplies` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `supplies` (`id`, `item_name`, `quantity`, `unit`, `stock`, `min_stock`, `created_at`, `updated_at`) VALUES
(1, 'Kertas A4', 50, 'Rim', 50, 10, NOW(), NOW()),
(2, 'Tinta Printer Hitam', 20, 'Botol', 20, 5, NOW(), NOW()),
(3, 'Spidol Papan Tulis', 100, 'Pcs', 100, 20, NOW(), NOW());

CREATE TABLE IF NOT EXISTS `supply_requests` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `requester_name` varchar(150) NOT NULL,
  `department` varchar(150) NOT NULL,
  `date_requested` date NOT NULL,
  `date_needed` date NOT NULL,
  `supply_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`supply_id`) REFERENCES `supplies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `auth_logs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `method` varchar(30) NOT NULL,
  `status` enum('success','failed','blocked') NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `role` enum('super_admin','admin','user') NOT NULL DEFAULT 'user',
  `department` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `identity_number` varchar(50) DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT 0,
  `suspend_reason` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `role`, `department`, `phone`, `identity_number`, `two_factor_code`, `two_factor_expires`, `is_suspended`, `suspend_reason`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$10$SP32G34JGDtmfVTxdynQX.9A4jheDlETjuKsBw1jxD38gHXcVhN3K', 'Tim Biro IT', 'it@upitra.ac.id', 'super_admin', 'Biro IT', '081200000001', 'IT-001', NULL, NULL, 0, NULL, NOW(), NOW()),
(2, 'admin', '$2y$10$abL4LoXziTs5XxYCWsDBfOSTNVuMBiHSITfu3m/OCicUVRYl1357G', 'Biro Sarana dan Prasarana', 'sarpras@upitra.ac.id', 'admin', 'Sarpras', '081200000002', 'SP-002', NULL, NULL, 0, NULL, NOW(), NOW()),
(3, 'mahasiswa', '$2y$10$.9WMX.9K0ClnPh5kYxLSEuztQSx3bqekN.Nutp9itzNS/XmvgCa6K', 'Budi Santoso', 'budi@student.upitra.ac.id', 'user', 'Mahasiswa Informatika', '081234567890', '2023010045', NULL, NULL, 0, NULL, NOW(), NOW()),
(4, 'dosen', '$2y$10$KBLldOiFpfCon11kewVV4eK20Xu0ugeEgJotT8OM82uErGJBtb1iS', 'Dr. Siti Rahmawati, M.Kom.', 'siti.rahma@upitra.ac.id', 'user', 'Dosen Fakultas Sains & Teknologi', '081298765432', '0412058001', NULL, NULL, 0, NULL, NOW(), NOW()),
(5, 'user', '$2y$10$XLSxMNqlixuv3WPDKCjoBuRSm.IxHz1IdEYr8wPIkGrbeKQDa1Sxi', 'Budi Santoso', 'budi@student.upitra.ac.id', 'user', 'Mahasiswa Informatika', '081234567890', '2023010045', NULL, NULL, 0, NULL, NOW(), NOW());

-- =========================================================
-- DUMMY DATA: room_bookings
-- =========================================================
INSERT INTO `room_bookings` (`user_id`, `room_id`, `booking_date`, `start_time`, `end_time`, `booker_name`, `department`, `event_name`, `setup`, `material_needed`, `special_request`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
-- APPROVED records (will show on calendar)
(4, 1, '2026-10-14', '08:00:00', '10:00:00', 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', 'Rapat Koordinasi Dosen FST', 'Teater', 'Proyektor, Whiteboard', 'Mohon siapkan AC 2 jam sebelum acara', 'approved', 'Jadwal telah dikonfirmasi. Ruangan siap digunakan.', '2026-10-10 09:15:00', '2026-10-11 08:00:00'),
(3, 2, '2026-10-15', '13:00:00', '16:00:00', 'Budi Santoso', 'Mahasiswa Informatika', 'Presentasi Tugas Akhir Kelompok', 'Kelas', 'Proyektor, Laptop Stand', NULL, 'approved', 'Disetujui. Harap menjaga kebersihan ruangan.', '2026-10-11 10:30:00', '2026-10-12 09:00:00'),
(2, 4, '2026-10-16', '09:00:00', '12:00:00', 'Biro Sarana dan Prasarana', 'Sarpras', 'Seminar Nasional Teknologi Informasi 2026', 'Konferensi', 'Mic, Layar Besar, Sound System', 'Dibutuhkan 2 mic wireless', 'approved', 'Disetujui. Koordinasi dengan tim teknis untuk sound system.', '2026-10-09 14:00:00', '2026-10-10 07:30:00'),
(5, 3, '2026-10-20', '14:00:00', '17:00:00', 'Budi Santoso', 'Dosen / Mahasiswa', 'Workshop Desain UI/UX', 'Kelas', 'Proyektor, Whiteboard, Marker', 'Mohon siapkan colokan listrik yang cukup', 'approved', 'Disetujui. Pastikan colokan tersedia.', '2026-10-13 08:00:00', '2026-10-13 10:00:00'),
(4, 5, '2026-10-22', '08:00:00', '11:00:00', 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', 'Wisuda Angkatan XIV Universitas Pignatelli Triputra', 'Theater', 'Backdrop, Mic, Sound System, Layar', 'Dekorasi wisuda standar', 'approved', 'Disetujui. Koordinasi dekorasi dengan panitia wisuda.', '2026-10-08 10:00:00', '2026-10-09 08:00:00'),
-- PENDING records
(3, 1, '2026-10-28', '10:00:00', '12:00:00', 'Budi Santoso', 'Mahasiswa Informatika', 'Diskusi Kelompok Skripsi', 'Kelas', 'Whiteboard, Marker', NULL, 'pending', NULL, '2026-10-13 11:00:00', '2026-10-13 11:00:00'),
(5, 2, '2026-10-30', '09:00:00', '11:00:00', 'Budi Santoso', 'Dosen / Mahasiswa', 'Pertemuan Tim Penelitian LPPM', 'Konferensi', 'Proyektor, Laptop', NULL, 'pending', NULL, '2026-10-13 12:30:00', '2026-10-13 12:30:00'),
(4, 3, '2026-11-03', '13:00:00', '15:00:00', 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', 'Rapat Evaluasi Kurikulum FST', 'Konferensi', 'Proyektor, Whiteboard', 'Mohon siapkan konsumsi untuk 15 orang', 'pending', NULL, '2026-10-13 14:00:00', '2026-10-13 14:00:00'),
-- REJECTED records
(3, 4, '2026-10-16', '13:00:00', '17:00:00', 'Budi Santoso', 'Mahasiswa Informatika', 'Pentas Seni Mahasiswa', 'Theater', 'Sound System, Panggung', 'Dibutuhkan dekorasi panggung', 'rejected', 'Maaf, Auditorium telah digunakan untuk Seminar Nasional pada waktu yang berdekatan. Silakan ajukan ulang di tanggal lain.', '2026-10-10 16:00:00', '2026-10-11 09:00:00'),
(5, 1, '2026-10-14', '09:00:00', '11:00:00', 'Budi Santoso', 'Dosen / Mahasiswa', 'Rapat Kecil Tim Marketing', 'Konferensi', 'Proyektor', NULL, 'rejected', 'Ruangan sudah dipesan oleh Dr. Siti Rahmawati pada waktu yang bersamaan.', '2026-10-10 11:00:00', '2026-10-11 08:30:00');

-- =========================================================
-- DUMMY DATA: vehicle_bookings
-- =========================================================
INSERT INTO `vehicle_bookings` (`user_id`, `vehicle_id`, `booking_date`, `booking_day`, `start_time`, `end_time`, `booker_name`, `department`, `destination`, `description`, `driver_name`, `km_in`, `km_out`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
-- APPROVED records
(4, 1, '2026-10-14', 'Rabu', '07:00:00', '12:00:00', 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', 'Universitas Indonesia, Depok', 'Menghadiri undangan kerjasama antar universitas', 'Pak Joko Susilo', 45200, 45280, 'approved', 'Disetujui. Harap kembali tepat waktu.', '2026-10-11 08:00:00', '2026-10-12 09:00:00'),
(2, 2, '2026-10-15', 'Kamis', '08:00:00', '17:00:00', 'Biro Sarana dan Prasarana', 'Sarpras', 'Kantor Kopertis Wilayah III, Jakarta', 'Pengiriman dokumen akreditasi kampus', 'Pak Hendra Wijaya', 32100, 32210, 'approved', 'Disetujui. Dokumen penting, harap hati-hati.', '2026-10-10 14:30:00', '2026-10-11 10:00:00'),
(3, 3, '2026-10-20', 'Selasa', '06:30:00', '14:00:00', 'Budi Santoso', 'Mahasiswa Informatika', 'Balai Kota Jakarta, Jakarta Pusat', 'Transport mahasiswa untuk kegiatan KKN perdana', 'Pak Agus Wibowo', 18700, 18850, 'approved', 'Disetujui. Pastikan mahasiswa membawa surat izin.', '2026-10-13 09:00:00', '2026-10-13 10:30:00'),
-- PENDING records
(5, 1, '2026-10-28', 'Rabu', '08:00:00', '16:00:00', 'Budi Santoso', 'Dosen / Mahasiswa', 'Perpustakaan Nasional RI, Jakarta Pusat', 'Penelitian kepustakaan untuk skripsi', 'Pak Joko Susilo', NULL, NULL, 'pending', NULL, '2026-10-13 13:00:00', '2026-10-13 13:00:00'),
(4, 2, '2026-11-04', 'Rabu', '09:00:00', '13:00:00', 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', 'Kemendikbud, Jakarta Selatan', 'Rapat koordinasi kurikulum Merdeka Belajar', 'Pak Hendra Wijaya', NULL, NULL, 'pending', NULL, '2026-10-13 14:30:00', '2026-10-13 14:30:00'),
-- REJECTED record
(3, 2, '2026-10-15', 'Kamis', '10:00:00', '14:00:00', 'Budi Santoso', 'Mahasiswa Informatika', 'Mall Kelapa Gading, Jakarta Utara', 'Acara pameran mahasiswa non-akademik', 'Pak Hendra Wijaya', NULL, NULL, 'rejected', 'Mohon maaf, kendaraan sudah dipesan untuk keperluan dinas resmi pada tanggal tersebut. Kegiatan non-akademik tidak diprioritaskan.', '2026-10-10 16:30:00', '2026-10-11 08:00:00');

-- =========================================================
-- DUMMY DATA: maintenance_requests
-- =========================================================
INSERT INTO `maintenance_requests` (`user_id`, `requester_name`, `department`, `location`, `facility`, `description`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
(4, 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', 'Ruang Kuliah A3 Lantai 2', 'AC (Air Conditioner)', 'AC di ruang A3 tidak dingin dan mengeluarkan suara berisik sejak seminggu lalu. Mengganggu kenyamanan proses belajar mengajar.', 'in_progress', 'Tim teknisi sudah ditugaskan. Perbaikan estimasi selesai 2 hari kerja.', '2026-10-08 10:00:00', '2026-10-09 09:00:00'),
(3, 'Budi Santoso', 'Mahasiswa Informatika', 'Laboratorium Komputer Lt. 3', 'Proyektor', 'Proyektor di Lab Komputer menampilkan gambar buram dan tidak fokus. Sudah tidak bisa digunakan untuk presentasi.', 'resolved', 'Proyektor telah diperbaiki dan kini berfungsi normal. Terima kasih atas laporannya.', '2026-10-05 14:00:00', '2026-10-10 16:00:00'),
(5, 'Budi Santoso', 'Dosen / Mahasiswa', 'Toilet Wanita Lantai 2 Gedung B', 'Toilet / Sanitasi', 'Kran air di wastafel toilet wanita lantai 2 bocor dan air terus mengalir. Sudah berlangsung 3 hari.', 'pending', NULL, '2026-10-12 08:30:00', '2026-10-12 08:30:00'),
(4, 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', 'Ruang Dosen FST Lt. 1', 'Lampu / Penerangan', 'Dua lampu di ruang dosen mati dan suasana ruangan menjadi gelap. Mohon segera diganti.', 'approved', 'Lampu pengganti sudah tersedia. Tim akan memasang dalam 1-2 hari kerja.', '2026-10-11 09:00:00', '2026-10-12 10:00:00'),
(3, 'Budi Santoso', 'Mahasiswa Informatika', 'Koridor Gedung A Lantai 1', 'Pintu / Akses', 'Handle pintu koridor utama Gedung A rusak dan sulit dibuka dari dalam. Berpotensi membahayakan jika terjadi darurat.', 'pending', NULL, '2026-10-13 10:00:00', '2026-10-13 10:00:00'),
(2, 'Biro Sarana dan Prasarana', 'Sarpras', 'Ruang Server IT Lt. 4', 'Komputer / Perangkat IT', 'Server utama mengalami gangguan koneksi jaringan. Menyebabkan sistem informasi kampus terganggu sejak pukul 07.00.', 'resolved', 'Masalah jaringan telah diatasi. Server kembali online pukul 10.30. Penyebab: kabel LAN core putus.', '2026-10-07 07:30:00', '2026-10-07 11:00:00');

-- =========================================================
-- DUMMY DATA: supply_requests
-- =========================================================
INSERT INTO `supply_requests` (`user_id`, `email`, `requester_name`, `department`, `date_requested`, `date_needed`, `supply_id`, `quantity`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
(4, 'siti.rahma@upitra.ac.id', 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', '2026-10-10', '2026-10-15', 1, 10, 'approved', 'Disetujui. Kertas A4 dapat diambil di gudang Sarpras mulai Senin pagi.', '2026-10-10 09:00:00', '2026-10-11 10:00:00'),
(3, 'budi@student.upitra.ac.id', 'Budi Santoso', 'Mahasiswa Informatika', '2026-10-11', '2026-10-14', 2, 3, 'approved', 'Disetujui. Tinta printer dapat diambil hari ini di ruang Sarpras.', '2026-10-11 11:00:00', '2026-10-12 09:30:00'),
(5, 'budi@student.upitra.ac.id', 'Budi Santoso', 'Dosen / Mahasiswa', '2026-10-12', '2026-10-16', 3, 20, 'pending', NULL, '2026-10-12 14:00:00', '2026-10-12 14:00:00'),
(4, 'siti.rahma@upitra.ac.id', 'Dr. Siti Rahmawati, M.Kom.', 'Dosen Fakultas Sains & Teknologi', '2026-10-13', '2026-10-20', 1, 5, 'pending', NULL, '2026-10-13 08:00:00', '2026-10-13 08:00:00'),
(3, 'budi@student.upitra.ac.id', 'Budi Santoso', 'Mahasiswa Informatika', '2026-10-08', '2026-10-10', 2, 2, 'rejected', 'Stok tinta printer saat ini tidak mencukupi. Mohon menunggu pengadaan barang berikutnya atau hubungi Sarpras langsung.', '2026-10-08 10:00:00', '2026-10-09 09:00:00');

-- =========================================================
-- DUMMY DATA: lost_found
-- =========================================================
INSERT INTO `lost_found` (`ticket_code`, `report_type`, `reporter_name`, `reporter_status`, `lost_item`, `contact`, `incident_date`, `incident_time`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
('LF-202610-001', 'lost', 'Budi Santoso', 'Mahasiswa', 'Dompet coklat kulit', '0812****7890', '2026-10-10', '11:30:00', 'found', 'Dompet telah diamankan di Pos Satpam Gedung Utama. Pemilik silakan verifikasi identitas ke loket Sarpras Gedung 4 Lt. 1.', '2026-10-10 13:00:00', '2026-10-11 09:00:00'),
('LF-202610-002', 'lost', 'Nadia Permatasari', 'Mahasiswa', 'Tas ransel laptop warna hitam', '0821****5432', '2026-10-11', '14:00:00', 'claimed', 'Barang telah berhasil diserahkan kepada pemilik resmi.', '2026-10-11 15:30:00', '2026-10-12 10:00:00'),
('LF-202610-003', 'lost', 'Reza Firmansyah', 'Dosen', 'Kunci motor Honda dengan gantungan merah', '0856****0987', '2026-10-12', '09:00:00', 'reported', NULL, '2026-10-12 10:00:00', '2026-10-12 10:00:00'),
('LF-202610-004', 'found', 'Petugas Kebersihan', 'Tendik', 'Handphone Samsung Galaxy di Ruang A2', '0898****3210', '2026-10-13', '08:30:00', 'found', 'Barang dititipkan di loket Sarpras Gedung 4 Lt. 1.', '2026-10-13 09:00:00', '2026-10-13 09:00:00'),
('LF-202610-005', 'found', 'Ahmad Fauzi', 'Mahasiswa', 'Jaket hoodie abu-abu bertuliskan UPITRA', '0813****4321', '2026-10-09', '16:00:00', 'found', 'Ditemukan di Auditorium setelah seminar. Disimpan di Pos Satpam.', '2026-10-09 17:00:00', '2026-10-10 08:00:00');

-- =========================================================
-- DUMMY DATA: visitors
-- =========================================================
INSERT INTO `visitors` (`pass_code`, `visitor_name`, `institution`, `contact`, `purpose`, `host_name`, `check_in`, `check_out`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
('VP-202610-001', 'Drs. Bambang Setiawan, M.M.', 'Universitas Mitra Akademik', '0812****1234', 'Kunjungan studi banding kurikulum Program Studi Manajemen', 'Dr. Siti Rahmawati, M.Kom.', '2026-10-13 09:00:00', '2026-10-13 12:30:00', 'checked_out', 'Kunjungan berlangsung baik. Tamu telah check out sesuai jadwal.', '2026-10-13 08:50:00', '2026-10-13 12:35:00'),
('VP-202610-002', 'Ir. Hendra Gunawan, M.T.', 'Mitra Industri Teknologi Solo', '0821****7000', 'Presentasi program magang dan kerjasama industri dengan kampus', 'Biro Sarana dan Prasarana', '2026-10-12 10:00:00', '2026-10-12 13:00:00', 'checked_out', NULL, '2026-10-12 09:55:00', '2026-10-12 13:05:00'),
('VP-202610-003', 'Sari Indah Lestari, S.Pd.', 'SMA Negeri di Surakarta', '0856****9012', 'Konsultasi pendaftaran mahasiswa baru dan informasi beasiswa', 'Biro Humas & Admisi', '2026-10-13 13:00:00', NULL, 'checked_in', NULL, '2026-10-13 12:55:00', '2026-10-13 13:00:00'),
('VP-202610-004', 'Prof. Dr. Ahmad Yusuf, M.Si.', 'Badan Riset & Inovasi', '0813****0000', 'Diskusi kolaborasi penelitian dan hibah riset bersama LPPM', 'Dr. Siti Rahmawati, M.Kom.', '2026-10-14 09:00:00', NULL, 'checked_in', NULL, '2026-10-13 16:00:00', '2026-10-13 16:00:00'),
('VP-202610-005', 'Mega Putri Utami', 'Bank Mitra Pembayaran Kampus', '0878****4000', 'Sosialisasi program beasiswa dan tabungan mahasiswa bersama FEB', 'Biro Sarana dan Prasarana', '2026-10-10 14:00:00', '2026-10-10 16:30:00', 'checked_out', NULL, '2026-10-10 13:50:00', '2026-10-10 16:35:00');

-- =========================================================
-- DUMMY DATA: auth_logs (Security Audit Log)
-- =========================================================
INSERT INTO `auth_logs` (`user_id`, `email`, `action`, `method`, `status`, `ip_address`, `user_agent`, `details`, `created_at`) VALUES
(1, 'it@upitra.ac.id', 'login_sso', 'microsoft_oauth2', 'success', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'Login SSO Microsoft 365 berhasil (Super Admin)', NOW()),
(2, 'sarpras@upitra.ac.id', 'login_sso', 'microsoft_oauth2', 'success', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'Login SSO Microsoft 365 berhasil (Admin Sarpras)', NOW());

COMMIT;
