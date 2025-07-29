<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Hafalan;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $santriList = collect();

        if ($query) {
            $santriList = Santri::where('status', 'Aktif')
                                ->where('nama', 'LIKE', "%{$query}%")
                                ->orderBy('nama')
                                ->get();
        }
        return view('welcome', compact('query', 'santriList'));
    }

    public function showSantriProgress(Request $request, $id)
{
    $santri = Santri::findOrFail($id);

    // Tentukan rentang tanggal filter, defaultnya adalah hari ini
    $startDate = $request->input('start_date', date('Y-m-d'));
    $endDate = $request->input('end_date', date('Y-m-d'));

    // Query dasar untuk absensi dan hafalan
    $absensiQuery = Absensi::where('santri_id', $id);
    $hafalanQuery = Hafalan::where('santri_id', $id);

    // Terapkan filter rentang tanggal jika ada
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $absensiQuery->whereBetween('tanggal', [$startDate, $endDate]);
        $hafalanQuery->whereBetween('tanggal', [$startDate, $endDate]);
    }

    // Ambil data sesuai filter
    $absensiSantri = $absensiQuery->latest()->get();
    $hafalanSantri = $hafalanQuery->latest()->get();

    // Hitung statistik total (tanpa filter tanggal)
    $statsAbsensi = [
        'hadir' => Absensi::where('santri_id', $id)->where('status', 'hadir')->count(),
        'izin' => Absensi::where('santri_id', $id)->where('status', 'izin')->count(),
        'tidak_hadir' => Absensi::where('santri_id', $id)->where('status', 'tidak_hadir')->count(),
    ];

    return view('santri.progres_publik', compact('santri', 'absensiSantri', 'hafalanSantri', 'statsAbsensi', 'startDate', 'endDate'));
}
}