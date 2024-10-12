<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'judul',
        'pesan',
        'link',
        'dibaca',
        'tanggal_kirim',
        'id_user',
        'semua_pegawai',
    ];

    // Relasi ke model User (jika diperlukan)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
