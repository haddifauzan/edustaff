<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Tentukan tabel yang digunakan
    protected $table = 'tbl_user'; 

    // Primary key yang digunakan
    protected $primaryKey = 'id_user'; 

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_user',
        'email',
        'password',
        'role',
        'status_akun',
        'last_login',
        'no_hp',
        'foto_profil',
        'id_pegawai' // Relasi ke pegawai
    ];

    // Kolom yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting kolom tertentu ke tipe data
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke tabel pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke tabel jabatan (melalui pegawai)
    public function jabatan()
    {
        return $this->hasOneThrough(Jabatan::class, Pegawai::class, 'id_pegawai', 'id_jabatan', 'id_pegawai', 'id_jabatan');
    }

    // Relasi ke tabel riwayat jabatan (melalui pegawai)
    public function riwayatJabatan()
    {
        return $this->hasManyThrough(RiwayatJabatan::class, Pegawai::class, 'id_pegawai', 'id_pegawai', 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke model Mapel (melalui pegawai)
    public function mapels()
    {
        return $this->hasManyThrough(Mapel::class, Pegawai::class, 'id_pegawai', 'id_pegawai', 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke tabel mapel_kelas (melalui pegawai)
    public function mapelKelas()
    {
        return $this->hasManyThrough(MapelKelas::class, Pegawai::class, 'id_pegawai', 'id_pelajaran', 'id_pegawai', 'id_pelajaran');
    }

    // Relasi ke model Kelas (walikelas)
    public function walikelas()
    {
        return $this->hasManyThrough(Kelas::class, Pegawai::class, 'id_pegawai', 'id_walikelas', 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke model Jurusan (kepala jurusan)
    public function kepalaJurusan()
    {
        return $this->hasManyThrough(Jurusan::class, Pegawai::class, 'id_pegawai', 'kepala_jurusan', 'id_pegawai', 'id_pegawai');
    }

    // Relasi ke model TugasTambahan
    public function tugasTambahan()
    {
        return $this->hasManyThrough(TugasTambahan::class, Pegawai::class, 'id_pegawai', 'id_pegawai', 'id_pegawai', 'id_pegawai');
    }
}
