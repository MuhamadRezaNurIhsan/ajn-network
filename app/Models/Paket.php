<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket';
    protected $primaryKey = 'id_paket';
    protected $fillable = ['nama_paket', 'speed_download', 'speed_upload', 'harga'];

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'paket_id', 'id_paket');
    }
}