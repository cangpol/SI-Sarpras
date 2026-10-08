<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biro Sarana dan Prasarana - Universitas Pignatelli Triputra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; }
        .hero { background: #003366; color: white; padding: 40px 0; text-align: center; }
        footer { background: #f8f9fa; padding: 20px 0; margin-top: 50px; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">SI-Sarpras UPT</a>
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

<div class="container mt-4">
    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>
    
    <?= $this->renderSection('content') ?>
</div>

<footer>
    <div class="container">
        &copy; <?= date('Y') ?> Biro Sarana dan Prasarana - Universitas Pignatelli Triputra
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
