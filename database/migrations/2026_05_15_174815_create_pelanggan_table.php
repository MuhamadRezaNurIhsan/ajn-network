<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('kontak', 15);
            $table->unsignedBigInteger('paket_id');
            $table->date('masa_aktif_mulai');
            $table->date('masa_aktif_berakhir');
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif');
            $table->timestamps();
            
            $table->foreign('paket_id')->references('id_paket')->on('paket')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggan');
    }
};