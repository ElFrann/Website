<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StockLogController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenyetekanController;
use App\Http\Controllers\PenjualanController;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('inventories', InventoryController::class);
Route::resource('stock_logs', StockLogController::class);
Route::resource('pembelian', PembelianController::class);
Route::resource('penjualan', PenjualanController::class);

Route::get('/get-jenis/{id_tanaman}', [PenyetekanController::class, 'getJenis'])->name('get-jenis');

Route::resource('penyetekan', PenyetekanController::class);
Route::post('/penyetekan/proses', [PenyetekanController::class, 'proses'])->name('penyetekan.proses');
