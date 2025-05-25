<?php

namespace App\Http\Controllers;

use App\Models\StockLog;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class StockLogController extends Controller
{
    /**
     * Display a listing of the stock logs.
     */
    public function index()
    {
        $pembelians = Pembelian::all();
        $penjualans = Penjualan::all();
        return view('stock_logs.index', compact('pembelians', 'penjualans'));
    }
    
    public function getStockLogs()
    {
        $stockLogs = StockLog::join('inventories', 'stock_logs.inventory_id', '=', 'inventories.id')
            ->selectRaw("inventories.name as plant_name, SUM(stock_logs.quantity) as total_quantity, TO_CHAR(stock_logs.created_at, 'YYYY-MM') as period")
            // ->where('stock_logs.type', 'in') // aktifkan jika ingin filter tipe
            ->groupBy('inventories.name', 'period')
            ->orderByDesc('period')
            ->get();

        return view('stock_logs.list', compact('stockLogs'));
    }
}
