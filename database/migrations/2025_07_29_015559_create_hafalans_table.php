<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hafalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('sesi'); // pagi, sore, malam
            $table->string('jenis_hafalan'); // baru, murojaah
            $table->tinyInteger('juz');
            $table->string('surah');
            $table->string('halaman');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafalans');
    }
};