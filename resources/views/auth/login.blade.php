<!DOCTYPE html>
<html>
<head>
    <title>Login Admin - TAHFIDZ 57</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: "Segoe UI", sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .login-container { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); padding: 40px; border-radius: 20px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; text-align: center; color: #fff; }
        .title { margin: 0; font-size: 2.2rem; }
        .subtitle { margin: 5px 0 25px 0; opacity: 0.9; }
        .form-label { display: block; text-align: left; margin-bottom: 8px; font-weight: 600; }
        .form-control { width: 100%; box-sizing: border-box; padding: 15px; font-size: 1rem; border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 10px; background: rgba(255, 255, 255, 0.2); color: #fff; }
        .btn-login { width: 100%; margin-top: 20px; background: #fff; color: #667eea; border: none; padding: 15px; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 1rem; }
        .alert { padding: 12px; margin-bottom: 15px; border-radius: 8px; font-weight: 500; }
        .alert-error { background: rgba(255, 100, 100, 0.3); border: 1px solid rgba(255, 100, 100, 0.5); }
        .alert-success { background: rgba(100, 255, 100, 0.3); border: 1px solid rgba(100, 255, 100, 0.5); }
        .public-link { margin-top: 30px; }
        .public-link a { color: rgba(255, 255, 255, 0.8); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="title">🔐 Admin Login</h1>
        <p class="subtitle">Sistem Absensi TAHFIDZ 57</p>
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf <label for="password" class="form-label">Password Admin:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required autofocus>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        <div class="public-link">
            <a href="/">← Kembali ke Pencarian Publik</a>
        </div>
    </div>
</body>
</html>