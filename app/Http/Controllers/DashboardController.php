<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $timeRange = $request->input('timeRange', 'monthly');

        $driver = DB::getDriverName();

        switch ($timeRange) {
            case 'weekly':
                if ($driver === 'sqlite') {
                    $groupBy = "strftime('%Y%W', stock_logs.created_at)";
                } else {
                    $groupBy = "YEARWEEK(stock_logs.created_at, 1)";
                }
                break;
            case 'monthly':
                if ($driver === 'sqlite') {
                    $groupBy = "strftime('%Y-%m', stock_logs.created_at)";
                } else {
                    $groupBy = "TO_CHAR(stock_logs.created_at, 'YYYY-MM')";
                }
                break;
            case 'yearly':
                if ($driver === 'sqlite') {
                    $groupBy = "strftime('%Y', stock_logs.created_at)";
                } else {
                    $groupBy = "DATE_FORMAT(stock_logs.created_at, '%Y')";
                }
                break;
            default:
                if ($driver === 'sqlite') {
                    $groupBy = "strftime('%Y-%m', stock_logs.created_at)";
                } else {
                    $groupBy = "TO_CHAR(stock_logs.created_at, 'YYYY-MM')";
                }
                break;
        }

        $propagationData = DB::table('stock_logs')
            ->join('inventories', 'stock_logs.inventory_id', '=', 'inventories.id')
            ->select(
                'inventories.name as plant_name',
                DB::raw('SUM(stock_logs.quantity) as total_quantity'),
                DB::raw("$groupBy as period")
            )
            ->where('stock_logs.type', 'in')
            ->groupBy('plant_name', 'period')
            ->orderBy('period', 'desc')
            ->get();

        return view('dashboard', compact('propagationData', 'timeRange'));
    }
}
