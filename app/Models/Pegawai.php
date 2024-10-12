<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Jabatan;
use App\Models\RiwayatJabatan;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_pegawai'; // Nama tabel di database
    protected $primaryKey = 'id_pegawai'; // Primary key tabel

    protected $fillable = [
        'nik',
        'nama_pegawai',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'agama',
        'status_pernikahan',
        'foto_pegawai',
        'nip',
        'no_sk_pengangkatan',
        'tgl_pengangkatan',
        'status_kepegawaian',
        'pangkat',
        'golongan',
        'no_tlp',
        'email',
        'pendidikan_terakhir',
        'tahun_lulus',
        'gelar_depan',
        'gelar_belakang',
        'status_pegawai',
        'foto_ijazah',
        'foto_ktp',
        'foto_kk',
        'foto_akte_kelahiran',
        'id_jabatan',
        'expired_at',
    ];

    // Dates yang akan otomatis di-cast ke Carbon instances
    protected $dates = [
        'tanggal_lahir',
        'tgl_pengangkatan',
        'expired_at',
        'deleted_at',
    ];

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

    /**
     * Relasi ke tabel Jabatan (tbl_jabatan).
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatan::class, 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke model Mapel
    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'id_pegawai');
    }

    public function mapelKelas()
    {
        return $this->belongsToMany(MapelKelas::class, 'tbl_mapel_kelas', 'id_pegawai', 'id_pelajaran');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_walikelas', 'id_pegawai');
    }

    public function kepalaJurusan()
    {
        return $this->hasMany(Jurusan::class, 'kepala_jurusan', 'id_pegawai');
    }
    
    public function tugasTambahan()
    {
        return $this->hasMany(TugasTambahan::class, 'id_pegawai', 'id_pegawai');
    }
    
    public function walikelas()
    {
        return $this->hasMany(Kelas::class, 'id_walikelas', 'id_pegawai');
    }
}
