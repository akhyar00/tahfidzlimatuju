<!DOCTYPE html>
<html>
<head>
    <title>Data Santri - TAHFIDZ 57</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Salin semua <style> dari halaman Data Santri di web1.php yang lama */
        body { font-family: "Segoe UI", sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; color: #fff; padding: 20px; padding-bottom: 60px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .glass-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px; }
        .header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; padding: 25px; }
        .header h1 { margin: 0; font-size: 2.2rem; display: flex; align-items: center; gap: 10px; }
        .card-body { padding: 25px; }
        .filter-form { display: flex; gap: 20px; align-items: flex-end; flex-wrap: wrap; }
        .form-group { display: flex; flex-direction: column; }
        .form-label { margin-bottom: 8px; font-weight: 600; color: rgba(255,255,255,0.9); }
        .form-control { padding: 12px; border-radius: 8px; min-width: 200px; border: 2px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.2); color: #fff; }
        .btn { text-decoration: none; border-radius: 8px; font-weight: 600; transition: all .2s ease; display: inline-flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; padding: 10px 20px; font-size: 1rem; border: 2px solid transparent; box-sizing: border-box; }
        .btn-primary { background: #fff; color: #667eea; }
        .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
        .card-header { padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .card-header h3 { margin: 0; font-size: 1.3rem; }
        .table-container { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); vertical-align: middle; }
        .table th { text-align: left; }
        .table tr:hover { background: rgba(255,255,255,0.1); }
        .action-buttons { display: flex; gap: 8px; }
        .btn-edit, .btn-delete { color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 5px; font-size: 0.8rem; border: none; cursor: pointer; }
        .btn-edit { background: #28a745; }
        .btn-delete { background: #dc3545; }
        .alert-success { padding: 15px; background: rgba(40, 167, 69, 0.5); border-radius: 10px; text-align: center; font-weight: 600; margin-bottom: 20px;}
        .pagination { padding: 25px; }
    </style>
</head>
<body>
    <div class="container">
         <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="margin-bottom:20px;">← Kembali ke Dashboard</a>
         
         @if(session('success'))
             <div class="alert-success">{{ session('success') }}</div>
         @endif

        <div class="glass-card header">
            <h1>👥 Data Santri</h1>
            <a href="{{ route('santri.create') }}" class="btn btn-primary">➕ Tambah Santri</a>
        </div>

        <div class="glass-card">
            <div class="card-header"><h3>🔍 Filter & Pencarian</h3></div>
            <div class="card-body">
                <form method="GET" action="{{ route('santri.index') }}" class="filter-form">
                    <div class="form-group">
                        <label for="search" class="form-label">Cari Nama Santri</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Ketik nama..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group">
                        <label for="filter_kelas" class="form-label">Filter Kelas</label>
                        <select name="filter_kelas" id="filter_kelas" class="form-control">
                            <option value="">Semua Kelas</option>
                            @foreach(range(7, 12) as $kelas)
                                <option value="{{ $kelas }}" @if(request('filter_kelas') == $kelas) selected @endif>Kelas {{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                        <a href="{{ route('santri.index') }}" class="btn btn-secondary" style="margin-left:10px;">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-header">
                <h3>📋 Daftar Santri</h3>
                <small>Menampilkan {{ $santriTampil->count() }} dari {{ $totalSantri }} santri</small>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr><th>ID</th><th>Nama Santri</th><th>Status</th><th>Kelas</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($santriTampil as $santri)
                        <tr>
                            <td><strong>#{{ str_pad($santri->id, 3, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ $santri->nama }}</td>
                            <td>{{ $santri->status }}</td>
                            <td>Kelas {{ $santri->kelas }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('santri.edit', $santri->id) }}" class="btn-edit">✏️ Edit</a>
                                    <form method="POST" action="{{ route('santri.destroy', $santri->id) }}" onsubmit="return confirm('Yakin ingin menghapus santri {{ $santri->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align:center; padding: 20px;">Santri tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                {{ $santriTampil->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</body>
</html>