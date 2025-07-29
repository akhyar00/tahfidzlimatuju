<!DOCTYPE html>
<html>
<head>
    <title>Progres Santri: {{ $santri->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* TEMA GLASMORPHISM */
        body { font-family: "Segoe UI", sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; color: #fff; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .glass-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px; }
        .profile-header { padding: 30px; text-align: center; }
        .avatar { width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px auto; color: white; display:flex; align-items:center; justify-content:center; font-size: 4rem; font-weight: bold; }
        .profile-header h1 { margin: 0; font-size: 2rem; }
        .profile-header p { font-size: 1.2rem; opacity: 0.8; margin: 5px 0 0 0; }
        .card-title { padding: 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.2); font-size: 1.3rem; font-weight: 600; }
        .card-content { padding: 25px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; text-align: center; }
        .stat h3 { font-size: 2.5rem; margin: 0 0 5px 0; }
        .stat p { margin: 0; opacity: 0.8; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .table tr:last-child td { border-bottom: none; }
        .btn { padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s ease; border: none; cursor: pointer; }
        .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
        .btn-primary { background: #fff; color: #667eea; }
        .filter-form { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-label { margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; }
        .form-control { padding: 10px; border-radius: 8px; border: 2px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.2); color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="btn btn-secondary" style="margin-bottom:20px;">← Kembali ke Pencarian</a>
        <div class="glass-card profile-header">
            <div class="avatar">{{ strtoupper(substr($santri->nama, 0, 1)) }}</div>
            <h1>{{ $santri->nama }}</h1>
            <p>Kelas {{ $santri->kelas }}</p>
        </div>
        <div class="glass-card">
            <div class="card-title">📊 Rekap Total Kehadiran</div>
            <div class="card-content stats-grid">
                <div class="stat"><h3 style="color: #a7ffc4;">{{ $statsAbsensi['hadir'] }}</h3><p>Hadir</p></div>
                <div class="stat"><h3 style="color: #ffdca7;">{{ $statsAbsensi['izin'] }}</h3><p>Izin</p></div>
                <div class="stat"><h3 style="color: #ffa7a7;">{{ $statsAbsensi['tidak_hadir'] }}</h3><p>Alpha</p></div>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-title">🔍 Tampilkan Riwayat Berdasarkan Tanggal</div>
            <div class="card-content">
                <form method="GET" action="{{ route('santri.progres.publik', $santri->id) }}" class="filter-form">
                    <div class="form-group">
                        <label for="start_date" class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                        <a href="{{ route('santri.progres.publik', $santri->id) }}" class="btn btn-secondary" style="margin-left:10px;">Hari Ini</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-title">⭐ Progres Hafalan</div>
            <div class="card-content" style="padding: 0;">
                <table class="table">
                    <thead><tr><th>Tanggal</th><th>Jenis</th><th>Surah</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        @forelse($hafalanSantri as $hafalan)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($hafalan->tanggal)->isoFormat('D MMM Y') }}</td>
                            <td>{{ ucfirst($hafalan->jenis_hafalan) }}</td>
                            <td>{{ $hafalan->surah }}</td>
                            <td>{{ $hafalan->halaman }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center; padding: 20px;">Tidak ada riwayat hafalan pada rentang tanggal ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="glass-card">
            <div class="card-title">📖 Riwayat Absensi</div>
            <div class="card-content" style="padding: 0;">
                <table class="table">
                    <thead><tr><th>Tanggal</th><th>Sesi</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($absensiSantri as $absen)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absen->tanggal)->isoFormat('D MMM Y') }}</td>
                            <td>{{ ucfirst($absen->sesi) }}</td>
                            <td>{{ ucfirst(str_replace("_", " ", $absen->status)) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center; padding: 20px;">Tidak ada riwayat absensi pada rentang tanggal ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>