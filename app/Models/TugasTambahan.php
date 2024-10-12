<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasTambahan extends Model
{
    use HasFactory;

    protected $table = 'tbl_tugas_tambahan'; 
    protected $primaryKey = 'id_tugas_tambahan'; 

    protected $fillable = [
        'nama_tugas',
        'deskripsi_tugas',
        'tgl_mulai',
        'tgl_selesai',
        'id_pegawai' 
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
