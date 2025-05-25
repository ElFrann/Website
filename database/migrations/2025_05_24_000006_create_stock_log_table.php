<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockLogTable extends Migration
{
    public function up()
    {
        Schema::create('stock_log', function (Blueprint $table) {
            $table->id();
            $table->string('id_tanaman');
            $table->string('jenis')->nullable();
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('jumlah')->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_log');
    }
}
