<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    use HasFactory;

    protected $table = 'tanaman'; // pastikan nama tabel sesuai di database

    protected $fillable = [
        'id_tanaman',
        // tambahkan kolom lain jika ada, misal: 'induk'
    ];
}
