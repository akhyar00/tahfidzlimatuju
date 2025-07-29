<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;

class SantriSeeder extends Seeder
{
    public function run()
    {
        // Baris ini penting untuk menghapus data lama sebelum memasukkan data baru
        Santri::truncate();

        $santriData = [
            ['nama' => 'Alfi', 'kelas' => '10', 'status' => 'Aktif'],
            ['nama' => 'Atho\'', 'kelas' => '10', 'status' => 'Aktif'],
            ['nama' => 'Ayyub', 'kelas' => '9', 'status' => 'Aktif'],
            ['nama' => 'Azka', 'kelas' => '7', 'status' => 'Aktif'],
            ['nama' => 'Azril', 'kelas' => '10', 'status' => 'Aktif'],
            ['nama' => 'Bagus', 'kelas' => '10', 'status' => 'Aktif'],
            ['nama' => 'Dhimas', 'kelas' => '10', 'status' => 'Aktif'],
            ['nama' => 'Fardan', 'kelas' => '10', 'status' => 'Aktif'],
            ['nama' => 'Nico', 'kelas' => '9', 'status' => 'Aktif'],
            ['nama' => 'Rehan', 'kelas' => '10', 'status' => 'Aktif'],
            ['nama' => 'Umar', 'kelas' => '7', 'status' => 'Aktif'],
            ['nama' => 'Zada', 'kelas' => '10', 'status' => 'Aktif'],
        ];

        foreach ($santriData as $santri) {
            Santri::create($santri);
        }
    }
}