<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\RiwayatJabatan;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes; // Gunakan SoftDeletes jika perlu

    // Tentukan tabel yang digunakan
    protected $table = 'tbl_jabatan'; 

    // Primary key yang digunakan
    protected $primaryKey = 'id_jabatan'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_jabatan',
        'deskripsi_jabatan',
        'golongan',
        'level_jabatan',
    ];

    // Kolom tanggal
    protected $dates = ['deleted_at', 'expired_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($jabatan) {
            if (!$jabatan->isForceDeleting()) {
                $jabatan->expired_at = Carbon::now()->addDays(30);
                $jabatan->save();
            }
        });
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan');
    }

    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatan::class, 'id_jabatan');
    }
}
