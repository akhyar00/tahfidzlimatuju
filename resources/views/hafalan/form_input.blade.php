<!DOCTYPE html>
<html>
<head>
    <title>Input Hafalan {{ ucfirst($sesi) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "Segoe UI", sans-serif; margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed; color: #fff;
            padding: 20px; padding-bottom: 60px;
        }
        .container { max-width: 600px; margin: 0 auto; }
        .glass-card {
            background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px;
        }
        .header { padding: 25px; text-align: center; }
        .header h1 { margin: 0; font-size: 2.2rem; }
        .header p { margin: 5px 0 0 0; opacity: 0.8; }
        .form-container { padding: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: rgba(255,255,255,0.9); }
        .form-control {
            width: 100%; box-sizing: border-box; padding: 12px; border-radius: 8px; font-size: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3); background: rgba(255, 255, 255, 0.2); color: #fff;
        }
        .form-control:focus { outline: none; border-color: #fff; }
        .form-control option { color: #333; }
        .btn-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn {
            flex-grow: 1; text-align: center; text-decoration: none; border-radius: 8px;
            font-weight: 600; transition: all .2s ease; display: inline-flex;
            align-items: center; justify-content: center; gap: 8px; border: none;
            cursor: pointer; padding: 15px; font-size: 1rem;
        }
        .btn-primary { background: #fff; color: #667eea; }
        .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('hafalan.input') }}" class="btn btn-secondary" style="margin-bottom:20px;">← Kembali ke Pilih Sesi</a>

        <div class="glass-card header">
            <h1>
                @if($sesi == 'pagi') 🌅
                @elseif($sesi == 'sore') 🌇
                @else 🌃
                @endif
                Input Hafalan {{ ucfirst($sesi) }}
            </h1>
            <p>Tanggal: <strong>{{ date('d F Y') }}</strong></p>
        </div>

        <form method="POST" action="{{ route('hafalan.store') }}" class="glass-card form-container">
            @csrf
            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="sesi" value="{{ $sesi }}">

            <div class="form-group">
                <label for="santri_id" class="form-label">Nama Santri</label>
                <select name="santri_id" id="santri_id" class="form-control" required>
                    <option value="">-- Pilih Santri --</option>
                    @foreach($santriAktif as $santri)
                        <option value="{{ $santri->id }}">{{ $santri->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="jenis_hafalan" class="form-label">Jenis Setoran</label>
                <select name="jenis_hafalan" id="jenis_hafalan" class="form-control" required>
                    <option value="baru">Hafalan Baru</option>
                    <option value="murojaah">Murojaah (Mengulang)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="juz" class="form-label">Juz</label>
                <select name="juz" id="juz" class="form-control" required>
                    @foreach($juzList as $juz)
                        <option value="{{ $juz }}">Juz {{ $juz }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="surah" class="form-label">Surah</label>
                <select name="surah" id="surah" class="form-control" required>
                     @foreach($surahList as $surah)
                        <option value="{{ $surah }}">{{ $surah }}</option>
                    @endforeach
                </select>
            </div>

             <div class="form-group">
                <label for="halaman" class="form-label">Halaman / Keterangan Ayat</label>
                <input type="text" name="halaman" id="halaman" class="form-control" placeholder="Contoh: Hal 5 / Ayat 1-7" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">💾 Simpan Setoran</button>
                <a href="{{ route('hafalan.input') }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>