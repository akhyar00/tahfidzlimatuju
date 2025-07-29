<!DOCTYPE html>
<html>
<head>
    <title>Edit Santri - TAHFIDZ 57</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Salin style dari halaman Tambah Santri */
        body { font-family: "Segoe UI", sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; color: #fff; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .glass-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px; }
        .header { padding: 25px; text-align: center; }
        .header h1 { margin: 0; font-size: 2.2rem; }
        .header p { margin: 5px 0 0 0; opacity: 0.8; }
        .card-body { padding: 30px; }
        .form-group { margin-bottom: 25px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: rgba(255,255,255,0.9); }
        .form-control { width: 100%; box-sizing: border-box; padding: 15px; border-radius: 8px; border: 2px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.2); color: #fff; font-size: 1rem; }
        .btn-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn { flex-grow: 1; text-align: center; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all .2s ease; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; padding: 15px; font-size: 1rem; }
        .btn-primary { background: #fff; color: #667eea; }
        .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('santri.index') }}" class="btn btn-secondary" style="margin-bottom:20px;">← Kembali</a>
        <div class="glass-card">
            <div class="header">
                <h1>✏️ Edit Data Santri</h1>
                <p>{{ $santri->nama }}</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('santri.update', $santri->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Lengkap Santri</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $santri->nama }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control" required>
                            @foreach(range(7, 12) as $kelas)
                            <option value="{{ $kelas }}" @if($santri->kelas == $kelas) selected @endif>Kelas {{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status Santri</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Aktif" @if($santri->status == 'Aktif') selected @endif>Aktif</option>
                            <option value="Non-Aktif" @if($santri->status == 'Non-Aktif') selected @endif>Non-Aktif</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">💾 Update Data</button>
                        <a href="{{ route('santri.index') }}" class="btn btn-secondary">❌ Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>