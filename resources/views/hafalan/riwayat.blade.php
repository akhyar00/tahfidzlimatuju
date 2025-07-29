<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Hafalan Santri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
         body { font-family: "Segoe UI", sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; color: #fff; padding: 20px; padding-bottom: 60px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .glass-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px; }
        .header { padding: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;}
        .header h1 { margin: 0; font-size: 2.2rem; }
        .header-actions { display: flex; gap: 10px; }
        .card-body { padding: 25px; }
        .filter-form { display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-label { margin-bottom: 8px; font-weight: 600; }
        .form-control { padding: 10px; border-radius: 8px; border: 2px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.2); color: #fff; }
        .btn { padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s ease; border: none; cursor: pointer; font-size: 1rem; }
        .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
        .btn-primary { background: #fff; color: #667eea; }
        .btn-danger { background: #dc3545; color: #fff; }
        .table-container { overflow-x: auto; padding: 0 10px 10px 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); text-align: left; white-space: nowrap; }
        .pagination { padding: 25px; }
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
            <h1>📜 Riwayat Setoran Hafalan</h1>
            <div class="header-actions">
                <a href="{{ route('hafalan.input') }}" class="btn btn-primary">➕ Input Hafalan Baru</a>
                <form method="POST" action="{{ route('hafalan.hapus_semua') }}" onsubmit="return confirm('PERINGATAN! Anda yakin ingin menghapus SEMUA riwayat hafalan? Tindakan ini tidak bisa dibatalkan.');">
                    @csrf
                    <button type="submit" class="btn btn-danger">🗑️ Hapus Semua Riwayat</button>
                </form>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-body">
                <form method="GET" action="{{ route('hafalan.riwayat') }}" class="filter-form">
                    <div class="form-group">
                        <label for="search_nama" class="form-label">Nama Santri</label>
                        <input type="text" name="search_nama" id="search_nama" class="form-control" placeholder="Cari nama..." value="{{ request('search_nama') }}">
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('hafalan.riwayat') }}" class="btn btn-secondary" style="margin-left:10px;">Reset Filter</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="glass-card">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th><th>Sesi</th><th>Nama Santri</th>
                            <th>Jenis</th><th>Surah</th><th>Juz</th><th>Halaman/Ayat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatHafalan as $hafalan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($hafalan->tanggal)->isoFormat('D MMM Y') }}</td>
                                <td>{{ ucfirst($hafalan->sesi) }}</td>
                                <td><strong>{{ $hafalan->santri->nama ?? 'Santri Dihapus' }}</strong></td>
                                <td>{{ ucfirst($hafalan->jenis_hafalan) }}</td>
                                <td>{{ $hafalan->surah }}</td>
                                <td>{{ $hafalan->juz }}</td>
                                <td>{{ $hafalan->halaman }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" style="text-align: center; padding: 40px;">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $riwayatHafalan->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</body>
</html>