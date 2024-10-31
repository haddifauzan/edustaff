<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfirmasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_konfirmasi';
    protected $primaryKey = 'id_konfirmasi';
    public $timestamps = false; 

    protected $fillable = [
        'kolom_diubah',
        'data',
        'status_konfirmasi',
        'waktu_pengajuan',
        'waktu_respon',
        'pesan_operator',
        'id_operator',
        'id_pegawai',
    ];

    protected $casts = [
        'kolom_diubah' => 'array',
    ];

    // Relasi ke tabel operator
    public function operator()
    {
        return $this->belongsTo(User::class, 'id_operator', 'id_user');
    }

    // Relasi ke tabel pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai'); // Ganti 'Pegawai' dengan nama model pegawai
    }
}
