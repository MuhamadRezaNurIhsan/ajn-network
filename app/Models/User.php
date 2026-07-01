<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function isAdministrator()
    {
        return $this->role === 'administrator';
    }

    public function isDirektur()
    {
        return $this->role === 'direktur';
    }
}