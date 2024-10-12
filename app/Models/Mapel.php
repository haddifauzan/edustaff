<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Jurusan;
use Carbon\Carbon;

class Mapel extends Model
{
    use HasFactory, SoftDeletes;

    // Tentukan tabel yang digunakan
    protected $table = 'tbl_mapel'; 

    // Primary key yang digunakan
    protected $primaryKey = 'id_pelajaran'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_pelajaran',
        'kode_pelajaran',
        'deskripsi',
        'tingkat',
        'jenis_mapel',
        'deleted_at',
        'expired_at',
        'id_pegawai',
        'id_jurusan'
    ];

    // Kolom tanggal
    protected $dates = ['deleted_at', 'expired_at'];


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($mapel) {
            if (!$mapel->isForceDeleting()) {
                $mapel->expired_at = Carbon::now()->addDays(30);
                $mapel->save();
            }
        });
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    // Relasi ke model Pegawai (Guru)
    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    // Relasi many-to-many ke model Kelas melalui tbl_mapel_kelas
    public function mapelKelas()
    {
        return $this->hasMany(MapelKelas::class, 'id_pelajaran');
    }

    // Relasi ke Kelas melalui pivot tbl_mapel_kelas
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'tbl_mapel_kelas', 'id_pelajaran', 'id_kelas');
    }

}
