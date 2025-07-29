<!DOCTYPE html>
<html>
<head>
    <title>Input Absensi {{ ucfirst($sesi) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Salin style dari halaman input absensi di web1.php yang lama */
        body { font-family: "Segoe UI", sans-serif; margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed; color: #fff; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .glass-card { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px; }
        .header { padding: 25px; text-align: center; }
        .header h1 { margin: 0; font-size: 2.2rem; }
        .header p { margin: 5px 0 0 0; opacity: 0.9; }
        .form-container { padding: 25px; }
        .santri-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px; }
        .santri-item { background: rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 15px; border: 1px solid rgba(255, 255, 255, 0.2); }
        .santri-name { font-weight: 600; margin-bottom: 10px; font-size: 1.1rem; }
        .status-options { display: flex; gap: 10px; flex-wrap: wrap; }
        .status-radio { display: none; }
        .status-label { padding: 8px 15px; border-radius: 6px; cursor: pointer; transition: all 0.2s ease; font-size: 0.9rem; font-weight: 600; border: 2px solid transparent; flex: 1; text-align: center; }
        .status-label.hadir { background: rgba(40, 167, 69, 0.7); }
        .status-label.izin { background: rgba(255, 193, 7, 0.7); }
        .status-label.tidak_hadir { background: rgba(220, 53, 69, 0.7); }
        .status-radio:checked + .status-label { border-color: #fff; transform: scale(1.05); }
        .btn-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn { flex-grow: 1; text-align: center; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all .2s ease; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; cursor: pointer; padding: 15px; font-size: 1rem; }
        .btn-primary { background: #fff; color: #667eea; }
        .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('absensi.input') }}" class="btn btn-secondary" style="margin-bottom:20px;">← Kembali</a>
        <div class="glass-card header">
            <h1>Input Absensi {{ ucfirst($sesi) }}</h1>
            <p>Tanggal: <strong>{{ date('d F Y') }}</strong></p>
        </div>
        <form method="POST" action="{{ route('absensi.store') }}" class="glass-card form-container">
            @csrf
            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="sesi" value="{{ $sesi }}">
            <div class="santri-grid">
                @foreach ($santriAktif as $santri)
                <div class="santri-item">
                    <div class="santri-name">{{ $santri->nama }}</div>
                    <input type="hidden" name="santri_ids[]" value="{{ $santri->id }}">
                    <div class="status-options">
                        <input type="radio" name="status[{{ $santri->id }}]" value="hadir" id="hadir_{{ $santri->id }}" class="status-radio">
                        <label for="hadir_{{ $santri->id }}" class="status-label hadir">✅ Hadir</label>
                        
                        <input type="radio" name="status[{{ $santri->id }}]" value="izin" id="izin_{{ $santri->id }}" class="status-radio">
                        <label for="izin_{{ $santri->id }}" class="status-label izin">📝 Izin</label>
                        
                        <input type="radio" name="status[{{ $santri->id }}]" value="tidak_hadir" id="tidak_hadir_{{ $santri->id }}" class="status-radio">
                        <label for="tidak_hadir_{{ $santri->id }}" class="status-label tidak_hadir">❌ Alpha</label>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">💾 Simpan Absensi {{ ucfirst($sesi) }}</button>
                <a href="{{ route('absensi.input') }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>