<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('pelanggan_id');
            $table->datetime('waktu_login');
            $table->datetime('waktu_logout')->nullable();
            $table->integer('durasi')->default(0);
            $table->integer('total_data')->default(0);
            $table->timestamps();
            
            $table->foreign('pelanggan_id')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_aktivitas');
    }
};