<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'santri_id',
        'tanggal',
        'sesi',
        'status',
        'keterangan',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}