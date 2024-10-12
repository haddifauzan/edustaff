<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $table = 'tbl_riwayat_jabatan';
    protected $primaryKey = 'id_riwayat_jabatan'; 

    protected $fillable = [
        'tgl_mulai',
        'tgl_selesai',
        'id_pegawai',
        'id_jabatan',
    ];

    // Relasi ke model Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    // Relasi ke model Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}