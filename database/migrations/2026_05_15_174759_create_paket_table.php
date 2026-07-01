<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paket', function (Blueprint $table) {
            $table->id('id_paket');
            $table->string('nama_paket', 50);
            $table->integer('speed_download');
            $table->integer('speed_upload');
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paket');
    }
};