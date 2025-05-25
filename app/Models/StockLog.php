<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    // Model ini tidak perlu digunakan jika rekap diambil langsung dari pembelian & penjualan

    protected $fillable = [
        'inventory_id',
        'type',
        'quantity',
        'description',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
