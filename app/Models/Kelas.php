<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Kelas extends Model
{
    use HasFactory, SoftDeletes; // Gunakan SoftDeletes jika perlu

    // Tentukan tabel yang digunakan
    protected $table = 'tbl_kelas';

    // Primary key yang digunakan
    protected $primaryKey = 'id_kelas';

    // Apakah primary key auto-increment
    public $incrementing = true; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'kelompok',
        'id_walikelas',
        'id_jurusan',
    ];

    // Kolom tanggal
    protected $dates = ['deleted_at', 'expired_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($kelas) {
            if (!$kelas->isForceDeleting()) {
                $kelas->expired_at = Carbon::now()->addDays(30);
                $kelas->save();
            }
        });
    }


    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    // Relasi many-to-many ke model Mapel
    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'tbl_mapel_kelas', 'id_kelas', 'id_pelajaran');
    }

    public function walikelas()
    {
        return $this->belongsTo(Pegawai::class, 'id_walikelas', 'id_pegawai');
    }

    public function mapelKelas()
    {
        return $this->hasMany(MapelKelas::class, 'id_kelas');
    }
}

