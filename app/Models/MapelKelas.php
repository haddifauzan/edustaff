<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelKelas extends Model
{
    use HasFactory;

    protected $table = 'tbl_mapel_kelas';

    protected $primaryKey = 'id_mapel_kelas';
    protected $fillable = [
        'id_mapel',
        'id_kelas',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_pelajaran');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
