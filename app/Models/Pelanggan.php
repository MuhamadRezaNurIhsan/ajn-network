<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = [
        'nama', 'alamat', 'kontak', 'paket_id',
        'masa_aktif_mulai', 'masa_aktif_berakhir', 'status'
    ];

    protected $casts = [
        'masa_aktif_mulai' => 'date',
        'masa_aktif_berakhir' => 'date',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id', 'id_paket');
    }

    public function userMikrotik()
    {
        return $this->hasOne(UserMikrotik::class, 'pelanggan_id', 'id_pelanggan');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'pelanggan_id', 'id_pelanggan');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'pelanggan_id', 'id_pelanggan');
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'pelanggan_id', 'id_pelanggan');
    }

    public function queue()
    {
        return $this->hasOne(Queue::class, 'pelanggan_id', 'id_pelanggan');
    }

    // SCOPE: Untuk mengambil pelanggan yang masa aktifnya hampir habis
    public function scopeHampirHabis($query, $hari = 3)
    {
        return $query->where('status', 'aktif')
            ->whereDate('masa_aktif_berakhir', '<=', now()->addDays($hari));
    }
}