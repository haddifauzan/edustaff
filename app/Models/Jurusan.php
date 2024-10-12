<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes; // Gunakan SoftDeletes jika perlu
    
    // Tentukan tabel yang digunakan
    protected $table = 'tbl_jurusan'; 

    // Primary key yang digunakan
    protected $primaryKey = 'id_jurusan'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_jurusan',
        'singkatan',
        'deskripsi_jurusan',
        'kepala_jurusan'
    ];

    // Kolom tanggal
    protected $dates = ['deleted_at', 'expired_at'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($jurusan) {
            if (!$jurusan->isForceDeleting()) {
                $jurusan->expired_at = Carbon::now()->addDays(30);
                $jurusan->save();
            }
        });
    }

    public function kepalaJurusan()
    {
        return $this->belongsTo(Pegawai::class, 'kepala_jurusan', 'id_pegawai');
    }
}
