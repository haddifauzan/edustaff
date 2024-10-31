<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensiunKeluar extends Model
{
    use HasFactory;

    protected $table = 'tbl_pensiun_keluar';
    protected $primaryKey = 'id_pensiun_keluar';
    public $timestamps = true;

    protected $fillable = [
        'tgl_berlaku',
        'jenis_pengajuan',
        'status_pengajuan',
        'alasan',
        'pengaju',
        'keterangan_tambahan',
        'id_operator',
        'id_pegawai',
    ];

    // Relasi ke tabel pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai'); // Ganti 'Pegawai' dengan nama model pegawai
    }

    // Relasi ke tabel user
    public function operator()
    {
        return $this->belongsTo(User::class, 'id_operator', 'id_user');
    }
}
