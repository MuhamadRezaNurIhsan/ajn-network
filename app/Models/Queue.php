<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'queue';
    protected $primaryKey = 'id_queue';
    protected $fillable = ['pelanggan_id', 'target_speed', 'simple_queue_name'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id_pelanggan');
    }
}