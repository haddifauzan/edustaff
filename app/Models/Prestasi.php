<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_prestasi_pegawai';
    protected $primaryKey = 'id_prestasi';
    public $timestamps = true;

    protected $fillable = [
        'nama_prestasi',
        'deskripsi_prestasi',
        'tgl_dicapai',
        'foto_sertifikat',
        'status',
        'expired_at',
        'id_pegawai',
    ];

    // Relasi ke tabel pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

}
