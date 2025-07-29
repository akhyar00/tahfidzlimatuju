<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekap Harian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* TEMA GLASMORPHISM (Sama seperti halaman dashboard) */
        body {
            font-family: "Segoe UI", sans-serif; margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed; color: #fff;
            padding: 20px; padding-bottom: 60px;
        }
        .container { max-width: 1200px; margin: 0 auto; }
        .glass-card {
            background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); margin-bottom: 25px;
        }
        .header { padding: 25px; }
        .header h1 { margin: 0; font-size: 2.2rem; }
        .header p { margin: 5px 0 0 0; opacity: 0.9; }
        .card-body { padding: 25px; }
        .filter-form { display: flex; gap: 15px; align-items: center; }
        .btn {
            padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 8px; transition: all 0.2s ease; border: none; cursor: pointer;
        }
        .btn-secondary { background: rgba(255,255,255,0.3); color: #fff; }
        .btn-secondary:hover { background: rgba(255,255,255,0.5); }
        .btn-filter { background: #fff; color: #667eea; }
        .filter-input {
            padding: 10px; border-radius: 8px; border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2); color: #fff;
        }
        .table-container { overflow-x: auto; padding: 10px 25px 25px 25px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.2); text-align: left; }
        /* STYLE KHUSUS UNTUK LAPORAN */
        .status-hadir { font-weight: bold; color: #a7ffc4; }
        .status-izin { font-weight: bold; color: #ffdca7; }
        .status-tidak_hadir { font-weight: bold; color: #ffa7a7; }
        .hafalan-item { margin-bottom: 5px; padding: 5px 8px; border-radius: 5px; font-size: 0.9em; }
        .hafalan-baru { background: rgba(100, 200, 255, 0.2); }
        .hafalan-murojaah { background: rgba(255, 200, 100, 0.2); }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="btn btn-secondary" style="margin-bottom:20px;">← Kembali ke Dashboard</a>

        <div class="glass-card header">
            <h1>📊 Laporan Rekap Harian</h1>
            <p>{{ \Carbon\Carbon::parse($filterTanggal)->isoFormat('dddd, D MMMM Y') }}</p>
        </div>

        <div class="glass-card">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.rekap') }}" class="filter-form">
            <label for="tanggal">Pilih Tanggal:</label>
            <input type="date" name="tanggal" value="{{ $filterTanggal }}" class="filter-input">
            <button type="submit" class="btn btn-filter">Tampilkan</button>
        </form>
    </div>
</div>

        <div class="glass-card">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Santri</th>
                            <th>Absensi (Pagi/Sore/Malam)</th>
                            <th>Setoran Hafalan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaSantri as $santri)
                            <tr>
                                <td><strong>{{ $santri->nama }}</strong></td>
                                <td>
                                    @php
                                        // Ambil data absensi untuk santri ini
                                        $absensiSantri = $rekapAbsensi->get($santri->id);
                                        $pagi = $absensiSantri ? $absensiSantri->firstWhere('sesi', 'pagi') : null;
                                        $sore = $absensiSantri ? $absensiSantri->firstWhere('sesi', 'sore') : null;
                                        $malam = $absensiSantri ? $absensiSantri->firstWhere('sesi', 'malam') : null;
                                    @endphp
                                    <span class="status-{{ $pagi ? str_replace('_', '', $pagi->status) : 'tidak_hadir' }}">P</span> /
                                    <span class="status-{{ $sore ? str_replace('_', '', $sore->status) : 'tidak_hadir' }}">S</span> /
                                    <span class="status-{{ $malam ? str_replace('_', '', $malam->status) : 'tidak_hadir' }}">M</span>
                                </td>
                                <td>
                                    @php
                                        // Ambil data hafalan untuk santri ini
                                        $hafalanSantri = $rekapHafalan->get($santri->id);
                                    @endphp

                                    @if($hafalanSantri && $hafalanSantri->isNotEmpty())
                                        @foreach($hafalanSantri as $hafalan)
                                            <div class="hafalan-item hafalan-{{$hafalan->jenis_hafalan}}">
                                                <strong>[{{ ucfirst($hafalan->sesi) }}]</strong> {{ $hafalan->surah }} ({{ $hafalan->halaman }})
                                            </div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center; padding: 40px;">Belum ada data santri aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>