<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kelas', 
        'status'
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}