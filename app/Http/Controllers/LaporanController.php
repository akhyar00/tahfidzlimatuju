<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Hafalan;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman rekap harian gabungan (absensi & hafalan).
     */
    public function rekapHarian(Request $request)
{
    // Baris ini mengambil tanggal dari input form, atau tanggal hari ini jika kosong
    $filterTanggal = $request->input('tanggal', date('Y-m-d'));

    // Ambil data absensi untuk tanggal yang dipilih
    $rekapAbsensi = Absensi::with('santri')
        ->where('tanggal', $filterTanggal)
        ->get()
        ->groupBy('santri_id');

    // Ambil data hafalan untuk tanggal yang dipilih
    $rekapHafalan = Hafalan::with('santri')
        ->where('tanggal', $filterTanggal)
        ->get()
        ->groupBy('santri_id');

    // Ambil semua santri aktif untuk ditampilkan di laporan
    $semuaSantri = Santri::where('status', 'Aktif')->orderBy('nama')->get();

    return view('laporan.rekap', compact('filterTanggal', 'rekapAbsensi', 'rekapHafalan', 'semuaSantri'));
}

    /**
     * Mengekspor semua data aktivitas ke file CSV.
     */
    public function exportExcel()
    {
        $fileName = 'laporan_aktivitas_santri_' . date('Y-m-d') . '.csv';
        $absensi = Absensi::with('santri')->latest()->get();
        $hafalan = Hafalan::with('santri')->latest()->get();
        $semuaAktivitas = collect([]);

        foreach ($absensi as $data) {
            $semuaAktivitas->push([
                'tanggal' => $data->tanggal,
                'nama_santri' => $data->santri->nama ?? 'Santri Dihapus',
                'tipe_aktivitas' => 'Absensi ' . ucfirst($data->sesi),
                'detail' => ucfirst(str_replace('_', ' ', $data->status)),
                'dicatat_pada' => $data->created_at,
            ]);
        }

        foreach ($hafalan as $data) {
            $semuaAktivitas->push([
                'tanggal' => $data->tanggal,
                'nama_santri' => $data->santri->nama ?? 'Santri Dihapus',
                'tipe_aktivitas' => 'Hafalan ' . ucfirst($data->sesi) . ' (' . ucfirst($data->jenis_hafalan) . ')',
                'detail' => $data->surah . ' - ' . $data->halaman,
                'dicatat_pada' => $data->created_at,
            ]);
        }

        $semuaAktivitas = $semuaAktivitas->sortByDesc('dicatat_pada');
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream(function () use ($semuaAktivitas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Nama Santri', 'Tipe Aktivitas', 'Detail Keterangan', 'Waktu Dicatat']);
            foreach ($semuaAktivitas as $aktivitas) {
                fputcsv($file, [
                    Carbon::parse($aktivitas['tanggal'])->isoFormat('D MMM Y'),
                    $aktivitas['nama_santri'],
                    $aktivitas['tipe_aktivitas'],
                    $aktivitas['detail'],
                    Carbon::parse($aktivitas['dicatat_pada'])->isoFormat('D MMM Y HH:mm')
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }
}