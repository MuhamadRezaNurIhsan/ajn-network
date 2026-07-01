<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_mikrotik', function (Blueprint $table) {
            $table->id('id_user');
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('username', 50);
            $table->string('password', 100);
            $table->boolean('status_aktif')->default(1);
            $table->timestamps();
            
            $table->foreign('pelanggan_id')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_mikrotik');
    }
};