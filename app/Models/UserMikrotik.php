<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMikrotik extends Model
{
    protected $table = 'user_mikrotik';
    protected $primaryKey = 'id_user';
    protected $fillable = ['pelanggan_id', 'username', 'password', 'status_aktif'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id_pelanggan');
    }
}