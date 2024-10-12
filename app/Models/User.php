<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tentukan tabel yang digunakan
    protected $table = 'tbl_user'; 

    // Primary key yang digunakan
    protected $primaryKey = 'id_user'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_user',
        'email',
        'password',
        'role',
        'status_akun',
        'last_login',
        'no_hp',
        'foto_profil',
        'id_pegawai'
    ];

    // Kolom yang disembunyikan saat serialisasi, misalnya untuk API
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting kolom tertentu ke tipe data
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
