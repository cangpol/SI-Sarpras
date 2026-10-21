<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biro Sarana dan Prasarana - Universitas Pignatelli Triputra</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/logo.png">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 Modern Modal Notification -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-blue: #0A3A66;
            --secondary-blue: #0D62AC;
            --accent-blue: #2A85D0;
            --light-blue: #EBF3FA;
            --card-border: #E1EDF7;
            --light-bg: #F4F8FC;
            --text-dark: #0F2238;
            --text-muted: #5A7184;
            --white: #FFFFFF;
        }
        html, body {
            height: 100%;
        }
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: var(--light-bg);
            color: #334155;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content-wrapper {
            flex: 1 0 auto;
            width: 100%;
        }
        footer {
            flex-shrink: 0;
            width: 100%;
            margin-top: auto;
        }
        /* Utility Opacity Support for Bootstrap & Glass Badges */
        .bg-opacity-10 { --bs-bg-opacity: 0.10 !important; }
        .bg-opacity-15 { --bs-bg-opacity: 0.15 !important; }
        .bg-opacity-20 { --bs-bg-opacity: 0.20 !important; }
        .bg-opacity-25 { --bs-bg-opacity: 0.25 !important; }
        
        /* Direct background-color overrides for bg-white with opacity (prevents solid #fff fallback) */
        .bg-white.bg-opacity-10 { background-color: rgba(255, 255, 255, 0.10) !important; }
        .bg-white.bg-opacity-15 { background-color: rgba(255, 255, 255, 0.15) !important; }
        .bg-white.bg-opacity-20 { background-color: rgba(255, 255, 255, 0.20) !important; }
        .bg-white.bg-opacity-25 { background-color: rgba(255, 255, 255, 0.25) !important; }
        .bg-white.bg-opacity-50 { background-color: rgba(255, 255, 255, 0.50) !important; }

        /* Navbar Modern */
        .navbar {
            background: linear-gradient(135deg, #072B4D 0%, #0A3A66 60%, #0D62AC 100%) !important;
            box-shadow: 0 4px 18px rgba(10, 58, 102, 0.18);
            padding: 9px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }
        .navbar-brand { 
            font-weight: 700; 
            letter-spacing: 0.5px;
            font-size: 1.25rem;
            padding: 0;
        }
        .navbar-brand img {
            transition: transform 0.25s ease;
        }
        .navbar-brand:hover img {
            transform: scale(1.04);
        }
        /* Navbar Links */
        .navbar .nav-link {
            font-size: 0.885rem;
            font-weight: 500;
            padding: 6px 12px !important;
            border-radius: 8px;
            letter-spacing: 0.2px;
            transition: all 0.2s ease;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        .navbar .nav-link:hover, 
        .navbar .nav-item.dropdown:hover > .navbar .nav-link,
        .navbar .nav-item.dropdown.show > .navbar .nav-link {
            color: #FFFFFF !important;
            background-color: rgba(255, 255, 255, 0.15);
        }
        .navbar .btn-login-nav {
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 20px;
            padding: 5px 12px !important;
            transition: all 0.2s ease;
        }
        .navbar .btn-login-nav:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #FFFFFF !important;
        }

        /* General Nav Pills (Dashboard tabs, Sub-tabs, etc.) */
        .nav-pills .nav-link {
            color: #1e293b !important;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .nav-pills .nav-link:hover {
            color: var(--secondary-blue) !important;
            background-color: #f1f5f9 !important;
        }
        .nav-pills .nav-link.active {
            background-color: var(--primary-blue) !important;
            color: #FFFFFF !important;
            box-shadow: 0 4px 10px rgba(10, 58, 102, 0.2);
        }
        .dropdown-menu {
            border: 1px solid var(--card-border);
            box-shadow: 0 15px 35px rgba(10, 58, 102, 0.12);
            border-radius: 14px;
            padding: 8px;
            background: #FFFFFF;
        }
        .dropdown-item {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            transition: 0.2s ease;
            color: var(--text-dark);
        }
        .dropdown-item:hover {
            background-color: var(--light-blue);
            color: var(--secondary-blue);
            transform: translateX(3px);
        }
        
        /* Subpage Header Banner */
        .subpage-header {
            background: linear-gradient(135deg, #072B4D 0%, #0A3A66 60%, #0D62AC 100%);
            color: white;
            padding: 32px 0;
            border-bottom-left-radius: 28px;
            border-bottom-right-radius: 28px;
            margin-bottom: 35px;
            box-shadow: 0 10px 25px rgba(10, 58, 102, 0.12);
            position: relative;
            overflow: hidden;
        }
        .subpage-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Card Styling */
        .card {
            border: 1px solid var(--card-border);
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(10, 58, 102, 0.05);
            transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease, border-color 0.3s ease;
            background: #FFFFFF;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 36px rgba(10, 58, 102, 0.1);
            border-color: rgba(13, 98, 172, 0.3);
        }
        /* Anti-Blink & Anti-Jitter untuk Bootstrap Modal */
        body.modal-open .card,
        body.modal-open .card:hover,
        body.modal-open .table-responsive,
        body.modal-open .table-responsive-scroll {
            transform: none !important;
            transition: none !important;
        }
        .modal {
            transform: none !important;
        }

        /* Tabel Dashboard Responsif Mengikuti Tinggi Layar & Anti-Tenggelam (Super Admin, Admin, User) */
        .table-responsive-scroll {
            max-height: calc(100vh - 290px);
            min-height: 280px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 0.75rem;
            margin-bottom: 0.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #94a3b8 #f1f5f9;
        }
        @media (max-height: 720px) {
            .table-responsive-scroll {
                max-height: calc(100vh - 210px);
                min-height: 220px;
            }
        }
        /* Custom WebKit Scrollbar (Chrome, Edge, Safari, Opera) */
        .table-responsive-scroll::-webkit-scrollbar {
            height: 10px;
            width: 8px;
        }
        .table-responsive-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 6px;
        }
        .table-responsive-scroll::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 6px;
            border: 2px solid #f1f5f9;
        }
        .table-responsive-scroll::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        .card-body {
            padding: 28px;
        }
        .card-title {
            color: var(--primary-blue);
            font-weight: 700;
        }

        /* Buttons Modern */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(10, 58, 102, 0.2);
            transition: all 0.25s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #072B4D 0%, var(--primary-blue) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(10, 58, 102, 0.3);
            color: white;
        }
        .btn-outline-primary {
            color: var(--secondary-blue);
            border-color: var(--secondary-blue);
            border-width: 1.5px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.25s ease;
        }
        .btn-outline-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(13, 98, 172, 0.25);
        }
        
        .btn-success {
            background-color: #0E9F6E;
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            transition: all 0.25s ease;
        }
        .btn-success:hover {
            background-color: #046C4E;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(14, 159, 110, 0.25);
        }

        .btn-warning {
            background-color: #FF8A4C;
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            transition: all 0.25s ease;
        }
        .btn-warning:hover {
            background-color: #E06C2C;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 138, 76, 0.25);
        }

        /* Form Inputs */
        .form-control, .form-select {
            border-radius: 10px;
            padding: 11px 16px;
            border: 1px solid #D5E2EE;
            background-color: #FBFDFE;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(13, 98, 172, 0.15);
            border-color: var(--secondary-blue);
            background-color: #FFFFFF;
        }
        label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .hover-white:hover {
            color: #FFFFFF !important;
            transition: color 0.2s;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="/">
        <!-- Pastikan Anda menyimpan file logo.png di dalam folder public -->
        <img src="/logo.png" alt="Logo UPT" style="height: 44px; width: auto; margin-right: 12px; border-radius: 8px;">
        <div style="line-height: 1.15;">
            <div style="font-weight: 800; font-size: 1.2rem; letter-spacing: 0.8px; color: #ffffff;">SARPRAS</div>
            <div style="font-size: 0.76rem; font-weight: 400; opacity: 0.9; letter-spacing: 0.3px; color: #E0E7FF;">Universitas Pignatelli Triputra</div>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/#jadwal-kalender"><i class="bi bi-calendar3 me-1"></i>Kalender Jadwal</a></li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Pelaporan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/pelaporan/lost-found">Lost & Found</a></li>
            <li><a class="dropdown-item" href="/pelaporan/visitor">Visitor ID Pass</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Peminjaman</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/peminjaman/ruangan">Ruangan</a></li>
            <li><a class="dropdown-item" href="/peminjaman/kendaraan">Kendaraan (Vehicle)</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Request</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/request/maintenance">Maintenance</a></li>
            <li><a class="dropdown-item" href="/request/supplies">Supplies (ATK)</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/tracking"><i class="bi bi-search me-1"></i>Lacak Tiket</a>
        </li>

        <?php if(session()->get('isLoggedIn')): ?>
        <li class="nav-item dropdown ms-lg-3 my-auto">
          <a class="nav-link dropdown-toggle btn-login-nav text-white px-3 py-1 d-inline-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
            <span><?= esc(session()->get('user_name') ?? 'Admin') ?></span>
            <?php 
              $role = session()->get('role');
              $roleLabel = 'User';
              $badgeClass = 'bg-light text-dark';
              if ($role === 'super_admin') { $roleLabel = 'Biro IT'; $badgeClass = 'bg-warning text-dark'; }
              elseif ($role === 'admin') { $roleLabel = 'Sarpras'; $badgeClass = 'bg-info text-dark'; }
            ?>
            <span class="badge <?= $badgeClass ?> ms-2 px-2 py-1" style="font-size: 0.7rem; font-weight: 700;"><?= $roleLabel ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
            <li><a class="dropdown-item py-2" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item py-2 text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>
        <?php else: ?>
        <li class="nav-item ms-lg-3 my-auto">
          <a class="btn btn-outline-light px-3 py-1 rounded-pill fw-semibold shadow-sm d-inline-flex align-items-center" href="/login" style="border-width: 1.5px; font-size: 0.85rem; transition: all 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-box-arrow-in-right me-1" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14 2H6a1.5 1.5 0 0 0-1.5 1.5v2a.5.5 0 0 0 1 0z"/>
              <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
            </svg>
            <span>Login</span>
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<?php 
$uri = uri_string();
$isHome = empty($uri) || $uri === '/' || $uri === 'home';
?>

<?php if (!$isHome && $uri !== 'dashboard'): ?>
<div class="subpage-header">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <span class="badge rounded-pill px-3 py-1 mb-2 small" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35); color: #ffffff !important;">
                    <i class="bi bi-building me-1"></i> Biro Sarana dan Prasarana UPT
                </span>
                <h2 class="fw-bold text-white mb-0">Sistem Informasi SI-Sarpras</h2>
                <small class="text-white-50">Universitas Pignatelli Triputra</small>
            </div>
            <div class="d-flex gap-2">
                <a href="/" class="btn btn-outline-light rounded-pill btn-sm px-3 shadow-sm">
                    <i class="bi bi-house-door me-1"></i> Beranda
                </a>
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="/dashboard" class="btn btn-light rounded-pill btn-sm px-3 text-primary fw-semibold shadow-sm">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-light rounded-pill btn-sm px-3 text-primary fw-semibold shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="<?= ($isHome) ? 'container-fluid p-0' : (($uri === 'dashboard') ? 'container-fluid px-lg-4 py-3' : 'container pb-5') ?> main-content-wrapper flex-grow-1">
    <?php if(!$isHome && $uri !== 'dashboard' && session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div class="fw-medium"><?= session()->getFlashdata('message') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(!$isHome && $uri !== 'dashboard' && $uri !== 'login' && session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                <div class="fw-medium"><?= session()->getFlashdata('error') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?= $this->renderSection('content') ?>
</div>

<?php if ($uri === 'dashboard'): ?>
    <?php 
        $currentRole = session()->get('role') ?? 'user';
    ?>
    <?php if ($currentRole === 'super_admin'): ?>
    <!-- FOOTER KHUSUS DASHBOARD SUPER ADMIN (BIRO IT) -->
    <footer class="footer-dashboard-superadmin mt-auto py-3 text-white" style="background: linear-gradient(135deg, #041424 0%, #08223B 100%); border-top: 2px solid #F59E0B; box-shadow: 0 -4px 15px rgba(0,0,0,0.15);">
        <div class="container-fluid px-lg-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="/logo.png" alt="Logo UPT" style="height: 32px; width: auto; background: white; padding: 3px; border-radius: 6px;">
                    <div>
                        <div class="fw-bold text-white small" style="letter-spacing: 0.3px;">
                            Console Super Admin &bull; Biro Sistem Informasi & IT
                        </div>
                        <div class="text-white-50" style="font-size: 0.75rem;">
                            Universitas Pignatelli Triputra &bull; Integrated Infrastructure System
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark fw-bold ms-2 px-2 py-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                        <i class="bi bi-shield-lock-fill me-1"></i>SUPER ADMIN (BIRO IT)
                    </span>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3 small text-white-50">
                    <span class="d-flex align-items-center"><i class="bi bi-person-gear text-warning me-1"></i>Full CRUD Otoritas User</span>
                    <span class="d-none d-md-inline">&bull;</span>
                    <span class="d-flex align-items-center"><i class="bi bi-hdd-network-fill text-success me-1"></i>Server: Normal (Active)</span>
                    <span class="d-none d-md-inline">&bull;</span>
                    <span class="d-flex align-items-center">&copy; <?= date('Y') ?> Biro IT &bull; UPT</span>
                </div>
            </div>
        </div>
    </footer>
    <?php elseif ($currentRole === 'admin'): ?>
    <!-- FOOTER KHUSUS DASHBOARD ADMIN (SARPRAS) -->
    <footer class="footer-dashboard-admin mt-auto py-3 text-white" style="background: linear-gradient(135deg, #06223D 0%, #09375F 100%); border-top: 2px solid #00B4D8; box-shadow: 0 -4px 15px rgba(0,0,0,0.15);">
        <div class="container-fluid px-lg-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="/logo.png" alt="Logo UPT" style="height: 32px; width: auto; background: white; padding: 3px; border-radius: 6px;">
                    <div>
                        <div class="fw-bold text-white small" style="letter-spacing: 0.3px;">
                            Panel Administrasi Operasional &bull; Biro Sarana dan Prasarana
                        </div>
                        <div class="text-white-50" style="font-size: 0.75rem;">
                            Universitas Pignatelli Triputra &bull; Pelayanan Terpadu Civitas Kampus
                        </div>
                    </div>
                    <span class="badge bg-info text-dark fw-bold ms-2 px-2 py-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                        <i class="bi bi-gear-fill me-1"></i>ADMIN SARPRAS
                    </span>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3 small text-white-50">
                    <span class="d-flex align-items-center"><i class="bi bi-people-fill text-info me-1"></i>Kelola Pengguna: Dosen & Mahasiswa</span>
                    <span class="d-none d-md-inline">&bull;</span>
                    <span class="d-flex align-items-center"><i class="bi bi-envelope-at text-warning me-1"></i>IT Support: biro-it@upitra.ac.id</span>
                    <span class="d-none d-md-inline">&bull;</span>
                    <span class="d-flex align-items-center">&copy; <?= date('Y') ?> Biro Sarpras &bull; UPT</span>
                </div>
            </div>
        </div>
    </footer>
    <?php else: ?>
    <!-- FOOTER KHUSUS DASHBOARD USER (MAHASISWA & DOSEN) -->
    <footer class="footer-dashboard-user mt-auto py-3 text-white" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%); border-top: 2px solid #10B981; box-shadow: 0 -4px 15px rgba(0,0,0,0.15);">
        <div class="container-fluid px-lg-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="/logo.png" alt="Logo UPT" style="height: 30px; width: auto; background: white; padding: 3px; border-radius: 6px;">
                    <div>
                        <div class="fw-bold text-white small">Portal Layanan Terpadu Sarpras &bull; Universitas Pignatelli Triputra</div>
                        <div class="text-white-50" style="font-size: 0.75rem;">Peminjaman Ruangan, Kendaraan, Maintenance & Supplies ATK</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 small text-white-50">
                    <span><i class="bi bi-clock-history text-success me-1"></i>Pelayanan: Senin - Jumat (08:00 - 16:30 WIB)</span>
                    <span class="d-none d-md-inline">&bull;</span>
                    <span>&copy; <?= date('Y') ?> Sarpras UPT</span>
                </div>
            </div>
        </div>
    </footer>
    <?php endif; ?>
<?php else: ?>
<!-- FOOTER HALAMAN PUBLIK (HOME, PELAPORAN, REQUEST, DLL.) -->
<footer class="footer-modern mt-auto">
    <div class="footer-top py-5 text-white" style="background: linear-gradient(135deg, #072B4D 0%, #0A3A66 100%); border-top: 3px solid var(--accent-blue);">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="/logo.png" alt="Logo UPT" style="height: 48px; width: auto; margin-right: 12px; background: white; padding: 4px; border-radius: 8px;">
                        <div>
                            <h5 class="fw-bold mb-0 text-white">BIRO SARPRAS</h5>
                            <small class="text-white-50">Universitas Pignatelli Triputra</small>
                        </div>
                    </div>
                    <p class="text-white-50 small pe-lg-4 mb-3">
                        Pusat pengelolaan dan pelayanan sarana, prasarana, fasilitas akademik, kendaraan dinas, dan ketertiban lingkungan kampus Universitas Pignatelli Triputra yang modern, terintegrasi, dan transparan.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge px-3 py-2 rounded-pill small" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff !important;">
                            <i class="bi bi-clock me-1 text-info"></i> Pelayanan: Senin - Jumat (08:00 - 16:30 WIB)
                        </span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white text-uppercase mb-3" style="letter-spacing: 0.5px;">Layanan Civitas</h6>
                    <ul class="list-unstyled small text-white-50 mb-0">
                        <li class="mb-2"><a href="/peminjaman/ruangan" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Peminjaman Ruangan</a></li>
                        <li class="mb-2"><a href="/peminjaman/kendaraan" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Peminjaman Kendaraan</a></li>
                        <li class="mb-2"><a href="/request/maintenance" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Request Maintenance</a></li>
                        <li class="mb-2"><a href="/request/supplies" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Permohonan ATK (Supplies)</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12">
                    <h6 class="fw-bold text-white text-uppercase mb-3" style="letter-spacing: 0.5px;">Layanan Umum & Kontak</h6>
                    <ul class="list-unstyled small text-white-50 mb-3">
                        <li class="mb-2"><a href="/pelaporan/lost-found" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Form Lost & Found (Umum)</a></li>
                        <li class="mb-2"><a href="/pelaporan/visitor" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Visitor ID Pass (Buku Tamu)</a></li>
                        <li class="mb-2"><a href="/tracking" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Lacak Status Tiket</a></li>
                        <li class="mb-2"><a href="/kebijakan-privasi" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right me-1 text-info"></i> Kebijakan Privasi (UU PDP)</a></li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-1 text-info"></i> Jl. Duwet Raya No.I, Karangasem, Kec. Laweyan, Kota Surakarta, Jawa Tengah 57145</li>
                        <li class="mb-2"><i class="bi bi-envelope me-1 text-info"></i> sarpras@upitra.ac.id</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-3 text-center text-white-50 small" style="background: #051F38; border-top: 1px solid rgba(255,255,255,0.06);">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                &copy; <?= date('Y') ?> Biro Sarana dan Prasarana &bull; Universitas Pignatelli Triputra. Hak Cipta Dilindungi.
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="/kebijakan-privasi" class="text-white-50 text-decoration-none hover-white">Kebijakan Privasi</a>
                <span>&bull;</span>
                <a href="/tracking" class="text-white-50 text-decoration-none hover-white">Lacak Tiket</a>
                <span>&bull;</span>
                <a href="/login/admin" class="text-white-50 text-decoration-none hover-white" title="Akses Darurat Administrator"><i class="bi bi-shield-lock me-1"></i>Akses Admin (2FA)</a>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Global Anti-Flicker & Modal Teleportation Safeguard
// Memindahkan semua modal langsung ke document.body agar tidak berkedip/flicker
// akibat transform CSS pada card atau scroll container tabel.
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal').forEach(function(modal) {
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
    });
});
document.addEventListener('show.bs.modal', function(event) {
    var modal = event.target;
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
});

// Pemicu Notifikasi SweetAlert2 Otomatis setelah Berhasil / Gagal CRUD
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('message')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: <?= json_encode(session()->getFlashdata('message')) ?>,
            confirmButtonColor: '#0A3A66',
            timer: 2600,
            timerProgressBar: true
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Perhatian / Terjadi Kesalahan',
            text: <?= json_encode(session()->getFlashdata('error')) ?>,
            confirmButtonColor: '#0A3A66'
        });
    <?php endif; ?>
});

// Konfirmasi Hapus / Tindakan Modern dengan SweetAlert2 (menggantikan browser/windows default confirm)
document.addEventListener('submit', function(e) {
    var form = e.target;
    if (form && form.classList && form.classList.contains('form-swal-delete')) {
        if (!form.dataset.swalConfirmed) {
            e.preventDefault();
            var title = form.getAttribute('data-swal-title') || 'Konfirmasi Hapus';
            var text = form.getAttribute('data-swal-text') || 'Apakah Anda yakin ingin menghapus data ini?';
            var icon = form.getAttribute('data-swal-icon') || 'warning';
            var confirmBtnText = form.getAttribute('data-swal-confirm-btn') || '<i class="bi bi-trash me-1"></i> Ya, Hapus!';
            var confirmBtnColor = form.getAttribute('data-swal-confirm-color') || '#dc2626';

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmBtnColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmBtnText,
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.dataset.swalConfirmed = 'true';
                    form.submit();
                }
            });
        }
    }
});
</script>
</body>
</html>
