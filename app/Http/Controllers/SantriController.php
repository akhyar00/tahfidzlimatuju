<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;

class SantriController extends Controller
{
    /**
     * Menampilkan halaman daftar semua santri dengan filter.
     */
    public function index(Request $request)
    {
        $query = Santri::query();

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kelas
        if ($request->filled('filter_kelas')) {
            $query->where('kelas', $request->filter_kelas);
        }
        
        $santriTampil = $query->orderBy('nama')->paginate(15);
        $totalSantri = Santri::count();
        
        return view('santri.index', compact('santriTampil', 'totalSantri'));
    }

    /**
     * Menampilkan form untuk menambah santri baru.
     */
    public function create()
    {
        return view('santri.create');
    }

    /**
     * Menyimpan santri baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'status' => 'required|string|in:Aktif,Non-Aktif',
        ]);

        Santri::create($validated);
        
        return redirect()->route('santri.index')->with('success', 'Santri "' . $validated['nama'] . '" berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data santri.
     */
    public function edit(string $id)
    {
        $santri = Santri::findOrFail($id);
        return view('santri.edit', compact('santri'));
    }

    /**
     * Memperbarui data santri di database.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'status' => 'required|string|in:Aktif,Non-Aktif',
        ]);

        $santri = Santri::findOrFail($id);
        $santri->update($validated);

        return redirect()->route('santri.index')->with('success', 'Data santri "' . $santri->nama . '" berhasil diupdate!');
    }

    /**
     * Menghapus data santri dari database.
     */
    public function destroy(string $id)
    {
        $santri = Santri::findOrFail($id);
        $namaYangDihapus = $santri->nama;
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Santri "' . $namaYangDihapus . '" berhasil dihapus!');
    }
}