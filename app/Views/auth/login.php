<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SI-Sarpras</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-card h2 { margin-top: 0; text-align: center; color: #333; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #666; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 0.75rem; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
        .alert { padding: 0.75rem; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>SIM Sarpras Login</h2>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <form action="/login" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="admin@example.com">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="password123">
            </div>
            <button type="submit" class="btn">Log In</button>
        </form>
    </div>
</body>
</html>

