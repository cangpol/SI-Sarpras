<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SI-Sarpras</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; }
        .header { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header h1 { margin: 0; font-size: 1.5rem; color: #333; }
        .content { padding: 2rem; }
        .card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 1rem; }
        .btn { padding: 0.5rem 1rem; background-color: #dc3545; color: white; border: none; border-radius: 4px; text-decoration: none; font-size: 0.9rem; }
        .btn:hover { background-color: #c82333; }
        .api-link { display: inline-block; margin-top: 10px; color: #007bff; text-decoration: none; }
        .api-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIM Sarpras</h1>
        <div>
            Welcome, <?= session()->get('name') ?> (<?= session()->get('role_name') ?>)
            <a href="/logout" class="btn" style="margin-left: 1rem;">Logout</a>
        </div>
    </div>
    <div class="content">
        <div class="card">
            <h2>Backend API is Ready</h2>
            <p>You have successfully logged into the SIM Sarpras backend.</p>
            <p>From here, the frontend can interact with the API endpoints.</p>
            <hr>
            <h3>Frontend Views</h3>
            <ul>
                <li><a class="api-link" href="/booking/room">Form Peminjaman Ruangan (dengan Kalender)</a></li>
                <li><a class="api-link" href="/booking/vehicle">Form Peminjaman Mobil (dengan Kalender)</a></li>
            </ul>
            <hr>
            <h3>Test API Endpoints</h3>
            <ul>
                <li><a class="api-link" href="/api/dashboard/statistics" target="_blank">View Dashboard Statistics API (JSON)</a></li>
                <li><a class="api-link" href="/api/dashboard/calendar" target="_blank">View Calendar Events API (JSON)</a></li>
                <li><a class="api-link" href="/api/rooms/bookings" target="_blank">View Room Bookings API (JSON)</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

