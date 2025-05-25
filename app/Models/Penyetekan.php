<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyetekan extends Model
{
    use HasFactory;

    protected $table = 'penyetekan';

    protected $fillable = [
        'id_tanaman',
        'jenis',
        'jumlah_potong',
        'harga',
        'tanggal',
    ];
}
