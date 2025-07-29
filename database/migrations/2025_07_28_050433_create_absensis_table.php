<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('sesi', ['pagi', 'sore', 'malam']);
            $table->enum('status', ['hadir', 'izin', 'tidak_hadir']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Mencegah duplikasi data untuk santri yang sama di tanggal dan sesi yang sama
            $table->unique(['santri_id', 'tanggal', 'sesi']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensis');
    }
};