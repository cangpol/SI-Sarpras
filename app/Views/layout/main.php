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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0A3A66;
            --secondary-blue: #1C5A96;
            --accent-blue: #3A8DD5;
            --light-bg: #F8F9FB;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--light-bg);
            color: #333;
        }
        /* Navbar Premium */
        .navbar {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        .navbar-brand { 
            font-weight: 700; 
            letter-spacing: 0.5px;
            font-size: 1.4rem;
        }
        .nav-link {
            font-weight: 500;
            padding: 10px 15px !important;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-item.dropdown:hover .nav-link {
            color: #fff !important;
            opacity: 0.8;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 10px 0;
        }
        .dropdown-item {
            font-weight: 500;
            padding: 10px 20px;
            transition: 0.2s;
        }
        .dropdown-item:hover {
            background-color: var(--light-bg);
            color: var(--primary-blue);
        }
        
        /* Hero Section */
        .hero { 
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-blue) 100%);
            color: white; 
            padding: 80px 0; 
            text-align: center;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(10, 58, 102, 0.2);
        }
        .hero h1 {
            font-weight: 700;
            font-size: 2.8rem;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .hero p.lead {
            font-weight: 300;
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            background: white;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 15px;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(28, 90, 150, 0.3);
        }
        
        .btn-success {
            background-color: #0E9F6E;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-success:hover {
            background-color: #046C4E;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(14, 159, 110, 0.3);
        }

        .btn-warning {
            background-color: #FF8A4C;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-warning:hover {
            background-color: #E06C2C;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 138, 76, 0.3);
        }

        /* Form Inputs */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(58, 141, 213, 0.2);
            border-color: var(--accent-blue);
        }
        label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        /* Footer */
        footer { 
            background: white; 
            padding: 30px 0; 
            margin-top: 80px; 
            text-align: center; 
            color: #777;
            font-weight: 500;
            border-top: 1px solid #eaeaea;
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

<div class="hero">
    <div class="container">
        <h1>Biro Sarana dan Prasarana</h1>
        <p class="lead">Universitas Pignatelli Triputra</p>
    </div>
</div>

<div class="container" style="min-height: 50vh;">
    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert alert-success shadow-sm" style="border-radius: 12px; font-weight: 500;">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    
    <?= $this->renderSection('content') ?>
</div>

<footer>
    <div class="container">
        &copy; <?= date('Y') ?> Biro Sarana dan Prasarana<br>
        <small>Universitas Pignatelli Triputra</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
