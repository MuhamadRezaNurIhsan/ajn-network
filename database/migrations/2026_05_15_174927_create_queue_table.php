<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('queue', function (Blueprint $table) {
            $table->id('id_queue');
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('target_speed', 20);
            $table->string('simple_queue_name', 100);
            $table->timestamps();
            
            $table->foreign('pelanggan_id')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('queue');
    }
};