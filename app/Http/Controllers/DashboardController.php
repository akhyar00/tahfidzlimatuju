<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSantri = Santri::count();
        $santriAktif = Santri::where('status', 'Aktif')->count();
        
        $today = date('Y-m-d');
        
        // Menghitung jumlah santri unik yang hadir hari ini
        $hadirHariIni = Absensi::where('tanggal', $today)
                               ->where('status', 'hadir')
                               ->distinct('santri_id')
                               ->count('santri_id');
        
        $tidakHadir = $santriAktif - $hadirHariIni;
        
        $tingkatKehadiran = $santriAktif > 0 ? round(($hadirHariIni / $santriAktif) * 100, 1) : 0;
        
        return view('admin.dashboard', compact('totalSantri', 'santriAktif', 'hadirHariIni', 'tidakHadir', 'tingkatKehadiran'));
    }
}