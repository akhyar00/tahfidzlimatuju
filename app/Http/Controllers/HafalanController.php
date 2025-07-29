<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Hafalan;

class HafalanController extends Controller
{
    /**
     * Menampilkan halaman riwayat hafalan dengan filter.
     */
    public function riwayat(Request $request)
{
    $query = Hafalan::query()->with('santri');

    // Filter berdasarkan pencarian nama
    $query->when($request->filled('search_nama'), function ($q) use ($request) {
        return $q->whereHas('santri', function ($q_santri) use ($request) {
            $q_santri->where('nama', 'like', '%' . $request->search_nama . '%');
        });
    });

    // Filter berdasarkan tanggal mulai
    $query->when($request->filled('start_date'), function ($q) use ($request) {
        return $q->where('tanggal', '>=', $request->start_date);
    });

    // Filter berdasarkan tanggal akhir
    $query->when($request->filled('end_date'), function ($q) use ($request) {
        return $q->where('tanggal', '<=', $request->end_date);
    });

    // Ambil data, urutkan dari yang terbaru, dan buat paginasi
    $riwayatHafalan = $query->latest()->paginate(15);

    // Panggil view
    return view('hafalan.riwayat', compact('riwayatHafalan'));
}

    /**
     * Menampilkan halaman untuk memilih sesi input hafalan.
     */
    public function pilihSesi()
    {
        $today = date('Y-m-d');
        $pagiCount = Hafalan::where('tanggal', $today)->where('sesi', 'pagi')->count();
        $soreCount = Hafalan::where('tanggal', $today)->where('sesi', 'sore')->count();
        $malamCount = Hafalan::where('tanggal', $today)->where('sesi', 'malam')->count();
        
        return view('hafalan.pilih_sesi', compact('pagiCount', 'soreCount', 'malamCount'));
    }

    /**
     * Menampilkan form untuk menginput hafalan berdasarkan sesi.
     */
    public function formInput($sesi)
    {
        if (!in_array($sesi, ['pagi', 'sore', 'malam'])) {
            abort(404);
        }
        $santriAktif = Santri::where('status', 'Aktif')->orderBy('nama')->get();
        
        $juzList = range(1, 30);
        $surahList = [ "Al-Fatihah", "Al-Baqarah", "Ali 'Imran", "An-Nisa'", "Al-Ma'idah", "Al-An'am", "Al-A'raf", "Al-Anfal", "At-Tawbah", "Yunus", "Hud", "Yusuf", "Ar-Ra'd", "Ibrahim", "Al-Hijr", "An-Nahl", "Al-Isra'", "Al-Kahf", "Maryam", "Taha", "Al-Anbiya'", "Al-Hajj", "Al-Mu'minun", "An-Nur", "Al-Furqan", "Asy-Syu'ara'", "An-Naml", "Al-Qasas", "Al-'Ankabut", "Ar-Rum", "Luqman", "As-Sajdah", "Al-Ahzab", "Saba'", "Fatir", "Yasin", "As-Saffat", "Sad", "Az-Zumar", "Ghafir", "Fussilat", "Asy-Syura", "Az-Zukhruf", "Ad-Dukhan", "Al-Jathiyah", "Al-Ahqaf", "Muhammad", "Al-Fath", "Al-Hujurat", "Qaf", "Az-Zariyat", "At-Tur", "An-Najm", "Al-Qamar", "Ar-Rahman", "Al-Waqi'ah", "Al-Hadid", "Al-Mujadilah", "Al-Hasyr", "Al-Mumtahanah", "As-Saff", "Al-Jumu'ah", "Al-Munafiqun", "At-Taghabun", "At-Talaq", "At-Tahrim", "Al-Mulk", "Al-Qalam", "Al-Haqqah", "Al-Ma'arij", "Nuh", "Al-Jinn", "Al-Muzzammil", "Al-Muddaththir", "Al-Qiyamah", "Al-Insan", "Al-Mursalat", "An-Naba'", "An-Nazi'at", "'Abasa", "At-Takwir", "Al-Infitar", "Al-Mutaffifin", "Al-Insyiqaq", "Al-Buruj", "At-Tariq", "Al-A'la", "Al-Ghasyiyah", "Al-Fajr", "Al-Balad", "Asy-Syams", "Al-Lail", "Ad-Duha", "Asy-Syarh", "At-Tin", "Al-'Alaq", "Al-Qadr", "Al-Bayyinah", "Az-Zalzalah", "Al-'Adiyat", "Al-Qari'ah", "At-Takathur", "Al-'Asr", "Al-Humazah", "Al-Fil", "Quraisy", "Al-Ma'un", "Al-Kauthar", "Al-Kafirun", "An-Nasr", "Al-Masad", "Al-Ikhlas", "Al-Falaq", "An-Nas" ];

        return view('hafalan.form_input', compact('sesi', 'santriAktif', 'juzList', 'surahList'));
    }

    /**
     * Menyimpan data hafalan dari form ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'sesi' => 'required|string|in:pagi,sore,malam',
            'santri_id' => 'required|exists:santris,id',
            'jenis_hafalan' => 'required|string|in:baru,murojaah',
            'juz' => 'required|integer|min:1|max:30',
            'surah' => 'required|string',
            'halaman' => 'required|string|max:50',
        ]);

        Hafalan::create($validated);

        return redirect()->route('hafalan.input')->with('success', '✅ Setoran hafalan berhasil disimpan!');
    }
    public function hapusSemua()
{
    // Perintah ini akan menghapus semua baris di tabel hafalans
    Hafalan::truncate();
    
    return redirect()->route('hafalan.riwayat')->with('success', 'Semua riwayat hafalan berhasil dihapus.');
}
}