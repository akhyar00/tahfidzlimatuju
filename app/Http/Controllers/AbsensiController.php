<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    /**
     * Menampilkan halaman riwayat absensi dengan filter.
     */
    public function riwayat(Request $request)
    {
        $query = Absensi::query()->with('santri');

        $query->when($request->filled('search_nama'), function ($q) use ($request) {
            return $q->whereHas('santri', function ($q2) use ($request) {
                $q2->where('nama', 'like', '%' . $request->search_nama . '%');
            });
        });
        $query->when($request->filled('start_date'), fn ($q) => $q->where('tanggal', '>=', $request->start_date));
        $query->when($request->filled('end_date'), fn ($q) => $q->where('tanggal', '<=', $request->end_date));

        $semuaAbsensi = $query->latest()->paginate(15);
        
        return view('absensi.riwayat', compact('semuaAbsensi'));
    }

    /**
     * Menampilkan halaman untuk memilih sesi absensi (pagi/sore/malam).
     */
    public function pilihSesi()
    {
        $today = date('Y-m-d');
        $pagiCount = Absensi::where('tanggal', $today)->where('sesi', 'pagi')->count();
        $soreCount = Absensi::where('tanggal', $today)->where('sesi', 'sore')->count();
        $malamCount = Absensi::where('tanggal', $today)->where('sesi', 'malam')->count();
        
        return view('absensi.pilih_sesi', compact('pagiCount', 'soreCount', 'malamCount'));
    }

    /**
     * Menampilkan form untuk menginput absensi berdasarkan sesi.
     */
    public function formInput($sesi)
    {
        if (!in_array($sesi, ['pagi', 'sore', 'malam'])) {
            abort(404);
        }
        $santriAktif = Santri::where('status', 'Aktif')->orderBy('nama')->get();
        
        return view('absensi.form_input', compact('sesi', 'santriAktif'));
    }

    /**
     * Menyimpan data absensi dari form ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_ids' => 'required|array',
            'status' => 'required|array',
            'tanggal' => 'required|date',
            'sesi' => 'required|string|in:pagi,sore,malam'
        ]);

        $jumlahDisimpan = 0;
        foreach ($validated['santri_ids'] as $santriId) {
            if (isset($validated['status'][$santriId]) && !empty($validated['status'][$santriId])) {
                Absensi::updateOrCreate(
                    ['santri_id' => $santriId, 'tanggal' => $validated['tanggal'], 'sesi' => $validated['sesi']],
                    ['status' => $validated['status'][$santriId]]
                );
                $jumlahDisimpan++;
            }
        }
        
        return redirect()->route('absensi.input')->with('success', '✅ Absensi ' . $validated['sesi'] . ' berhasil disimpan untuk ' . $jumlahDisimpan . ' santri!');
    }
    public function hapusSemua()
{
    // Perintah ini akan menghapus semua baris di tabel absensis
    Absensi::truncate();
    
    return redirect()->route('absensi.index')->with('success', 'Semua riwayat absensi berhasil dihapus.');
}    
}