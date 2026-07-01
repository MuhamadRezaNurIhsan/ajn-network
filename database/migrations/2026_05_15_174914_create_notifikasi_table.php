<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('jenis', 10);
            $table->text('pesan');
            $table->datetime('waktu_kirim');
            $table->string('status', 20)->default('terkirim');
            $table->timestamps();
            
            $table->foreign('pelanggan_id')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
};