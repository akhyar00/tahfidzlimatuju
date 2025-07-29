<!DOCTYPE html>
<html>
<head>
    <title>Input Absensi Santri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
         /* Salin style dari halaman dashboard */
         body { font-family: "Segoe UI", sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; color: #fff; padding: 20px; }
         .container { max-width: 900px; margin: 0 auto; }
         .glass-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px; }
         .header { padding: 25px; text-align: center; }
         .header h1 { margin: 0; font-size: 2.2rem; }
         .header p { margin: 5px 0 0 0; opacity: 0.9; font-size: 1.1rem; }
         .sesi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; padding: 25px; }
         .sesi-card { background: rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 20px; text-align: center; border: 1px solid rgba(255, 255, 255, 0.2); transition: all 0.2s ease-in-out; }
         .sesi-card:hover { transform: translateY(-5px); background: rgba(255, 255, 255, 0.2); }
         .sesi-card h2 { margin-top: 0; }
         .btn { background: #fff; color: #667eea; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all .2s ease; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; font-size: 1rem; }
         .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
         .status-terisi { font-size: 0.9rem; color: #d4edda; font-weight: 600; margin-top: 15px; }
         .status-kosong { font-size: 0.9rem; color: #f8d7da; font-weight: 600; margin-top: 15px; }
         .alert-success { padding: 15px; background: rgba(40, 167, 69, 0.5); border-radius: 10px; text-align: center; font-weight: 600; margin-bottom: 20px;}
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="margin-bottom:20px;">← Kembali ke Dashboard</a>
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        <div class="glass-card header">
            <h1>✏️ Input Absensi Santri</h1>
            <p>Pilih sesi absensi untuk hari ini: <strong>{{ date('d F Y') }}</strong></p>
        </div>
        <div class="sesi-grid">
            <div class="sesi-card">
                <h2>🌅 Pagi</h2>
                <a href="{{ route('absensi.input.form', ['sesi' => 'pagi']) }}" class="btn">Mulai Input</a>
                @if($pagiCount > 0)
                    <div class="status-terisi">✓ Sudah Diisi ({{ $pagiCount }} data)</div>
                @else
                    <div class="status-kosong">✗ Belum Diisi</div>
                @endif
            </div>
            <div class="sesi-card">
                <h2>🌇 Sore</h2>
                <a href="{{ route('absensi.input.form', ['sesi' => 'sore']) }}" class="btn">Mulai Input</a>
                @if($soreCount > 0)
                    <div class="status-terisi">✓ Sudah Diisi ({{ $soreCount }} data)</div>
                @else
                    <div class="status-kosong">✗ Belum Diisi</div>
                @endif
            </div>
            <div class="sesi-card">
                <h2>🌃 Malam</h2>
                <a href="{{ route('absensi.input.form', ['sesi' => 'malam']) }}" class="btn">Mulai Input</a>
                @if($malamCount > 0)
                    <div class="status-terisi">✓ Sudah Diisi ({{ $malamCount }} data)</div>
                @else
                    <div class="status-kosong">✗ Belum Diisi</div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>