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
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: var(--light-bg);
            color: #334155;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        /* Navbar Modern */
        .navbar {
            background: linear-gradient(135deg, #072B4D 0%, #0A3A66 60%, #0D62AC 100%) !important;
            box-shadow: 0 4px 20px rgba(10, 58, 102, 0.15);
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }
        .navbar-brand { 
            font-weight: 700; 
            letter-spacing: 0.5px;
            font-size: 1.4rem;
        }
        .navbar-brand img {
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover img {
            transform: scale(1.04);
        }
        .nav-link {
            font-weight: 500;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.25s ease;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        .nav-link:hover, .nav-item.dropdown:hover > .nav-link {
            color: #FFFFFF !important;
            background-color: rgba(255, 255, 255, 0.12);
        }
        .dropdown-menu {
            border: 1px solid var(--card-border);
            box-shadow: 0 15px 35px rgba(10, 58, 102, 0.12);
            border-radius: 14px;
            padding: 8px;
            background: #FFFFFF;
        }
        .dropdown-item {
            font-weight: 500;
            padding: 9px 16px;
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
        <img src="/logo.png" alt="Logo UPT" style="height: 50px; width: auto; margin-right: 15px; border-radius: 8px;">
        <div style="line-height: 1.2;">
            <div style="font-weight: 800; font-size: 1.3rem; letter-spacing: 1px;">SARPRAS</div>
            <div style="font-size: 0.85rem; font-weight: 400; opacity: 0.9; letter-spacing: 0.5px;">Universitas Pignatelli Triputra</div>
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
        
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
            <li class="px-3 py-2 text-muted small border-bottom">
              Hak Akses: <strong class="text-primary"><?= $role === 'super_admin' ? 'Super Admin (Biro IT)' : ($role === 'admin' ? 'Admin (Sarpras)' : 'User (Mahasiswa & Dosen)') ?></strong>
            </li>
            <li><a class="dropdown-item py-2" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item py-2 text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>
        <?php else: ?>
        <li class="nav-item ms-lg-3 my-auto">
          <a class="btn btn-outline-light px-3 py-1 rounded-pill fw-semibold shadow-sm d-inline-flex align-items-center" href="/login" style="border-width: 1.5px; transition: all 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right me-1" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14 2H6a1.5 1.5 0 0 0-1.5 1.5v2a.5.5 0 0 0 1 0z"/>
              <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
            </svg>
            Login
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
                <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 mb-2 small">
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

<div class="<?= ($isHome) ? 'container-fluid p-0' : (($uri === 'dashboard') ? 'container-fluid px-lg-4 py-3' : 'container pb-5') ?>" style="min-height: 60vh;">
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
                        <span class="badge bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill small">
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
                        <li class="mb-2"><i class="bi bi-geo-alt me-1 text-info"></i> Jl. Kolonel Sugiyono No.37, Kadipiro, Banjarsari, Surakarta</li>
                        <li class="mb-2"><i class="bi bi-envelope me-1 text-info"></i> sarpras@pignatelli.ac.id</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-3 text-center text-white-50 small" style="background: #051F38; border-top: 1px solid rgba(255,255,255,0.06);">
        <div class="container">
            &copy; <?= date('Y') ?> Biro Sarana dan Prasarana &bull; Universitas Pignatelli Triputra. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
