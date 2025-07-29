<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - TAHFIDZ 57</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
         body { font-family: "Segoe UI", sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; color: #fff; padding: 20px; }
         .container { max-width: 1200px; margin: 0 auto; }
         .glass-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px; }
         .header { padding: 25px; }
         .header h1 { margin: 0; font-size: 2.2rem; }
         .header p { margin: 5px 0 0 0; opacity: 0.8; }
         .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 25px; }
         .stat-item { background: rgba(255, 255, 255, 0.2); padding: 20px; border-radius: 10px; text-align: center; }
         .stat-item h3 { margin: 0 0 5px 0; font-size: 2.5rem; }
         .stat-item p { margin: 0; opacity: 0.8; font-size: 0.9rem; text-transform: uppercase; }
         .menu-card { padding: 25px; }
         .menu-card h2 { margin-top: 0; border-bottom: 1px solid rgba(255, 255, 255, 0.3); padding-bottom: 10px; }
         .menu-grid { display: flex; flex-wrap: wrap; gap: 15px; }
         .menu-item { background: #fff; color: #667eea; padding: 12px 20px; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.2s ease-in-out; display: inline-flex; align-items: center; gap: 8px; }
         .menu-item:hover { background: #f0f0f0; transform: translateY(-2px); }
         .logout-form button { background: rgba(255, 100, 100, 0.8); color: #fff; border: none; cursor: pointer; padding: 12px 20px; border-radius: 8px; font-weight: 600; transition: all 0.2s ease-in-out; display: inline-flex; align-items: center; gap: 8px; font-size: 1rem; font-family: inherit; }
         .logout-form button:hover { background: rgba(255, 80, 80, 1); transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container">
        <div class="glass-card header">
            <h1>🎉 Dashboard Admin</h1>
            <p>Selamat datang, Administrator! | Sistem Absensi TAHFIDZ 57</p>
        </div>
        <div class="stats-grid">
            <div class="stat-item"><h3>{{ $totalSantri }}</h3><p>Total Santri</p></div>
            <div class="stat-item"><h3>{{ $hadirHariIni }} / {{ $santriAktif }}</h3><p>Hadir Hari Ini</p></div>
            <div class="stat-item"><h3>{{ $tidakHadir }}</h3><p>Belum Hadir</p></div>
            <div class="stat-item"><h3>{{ $tingkatKehadiran }}%</h3><p>Tingkat Hadir</p></div>
        </div>
        <div class="glass-card menu-card">
            <h2>📋 MENU UTAMA</h2>
            <div class="menu-grid">
                <a href="{{ route('santri.index') }}" class="menu-item">👥 Data Santri</a>
                <a href="{{ route('absensi.input') }}" class="menu-item">✏️ Input Absensi</a>
                <a href="{{ route('hafalan.input') }}" class="menu-item">📖 Input Hafalan</a>
                <a href="{{ route('hafalan.riwayat') }}" class="menu-item">📜 Riwayat Hafalan</a>
                <a href="{{ route('absensi.index') }}" class="menu-item">📋 Riwayat Absensi</a>
                <a href="{{ route('laporan.rekap') }}" class="menu-item">📊 Laporan Rekap</a>
            </div>
        </div>
        <div class="glass-card menu-card">
            <h2>⚙️ PENGATURAN & LAINNYA</h2>
            <div class="menu-grid">
                <a href="{{ route('laporan.export.excel') }}" class="menu-item">📤 Ekspor ke Excel</a>
                <a href="{{ route('home') }}" class="menu-item">🌐 Lihat Site Publik</a>
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit">🚪 Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>