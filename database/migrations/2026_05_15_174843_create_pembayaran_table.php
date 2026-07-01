<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('pelanggan_id');
            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->string('periode_bulan', 20);
            $table->string('kwitansi', 255)->nullable();
            $table->timestamps();
            
            $table->foreign('pelanggan_id')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};