<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Notifikasi;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->where('role', 'Pegawai')->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan atau bukan Pegawai.'
            ], 404);
        }

        if (Auth::guard('pegawai')->attempt($credentials)) {
            if (is_null($user->last_login)) {
                Notifikasi::create([
                    'id_user' => $user->id_user,
                    'pesan' => 'Selamat datang di Aplikasi EduStaff! Kami senang Anda bergabung dengan kami. Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau perlu bantuan.',
                    'judul' => 'Selamat Datang di EduStaff!!'
                ]);
            }

            $user->last_login = now();
            $user->save();

            if ($user->status_akun !== 'Aktif') {
                Auth::guard('pegawai')->logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Status akun anda Non-Aktif.'
                ], 403);
            }

            $token = $user->createToken('PegawaiToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.'
        ], 401);
    }

    public function logout(Request $request)
    {
        // Ambil user yang sedang login berdasarkan token
        $user = $request->user();

        if ($user->role !== 'Pegawai') {
            return response()->json([
                'success' => false,
                'message' => 'Akses tidak diizinkan untuk role ini.'
            ], 403);
        }

        // Hapus token yang sedang digunakan (logout)
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ], 200);
    }

    public function getProfile(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Cari data pegawai berdasarkan user yang login
        $pegawai = Pegawai::where('email', $user->email)->first();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai tidak ditemukan.'
            ], 404);
        }

        // Return data pegawai dalam bentuk JSON
        return response()->json([
            'success' => true,
            'message' => 'Data pegawai berhasil diambil.',
            'data' => [
                'id_pegawai' => $pegawai->id_pegawai,
                'nik' => $pegawai->nik,
                'nama_pegawai' => $pegawai->gelar_depan . ' ' . $pegawai->nama_pegawai . ' ' . $pegawai->gelar_belakang,
                'jenis_kelamin' => $pegawai->jenis_kelamin,
                'tempat_lahir' => $pegawai->tempat_lahir,
                'tanggal_lahir' => date('Y-m-d', strtotime($pegawai->tanggal_lahir)),
                'alamat' => $pegawai->alamat,
                'agama' => $pegawai->agama,
                'status_pernikahan' => $pegawai->status_pernikahan,
                'nip' => $pegawai->nip ?? '-',
                'no_sk_pengangkatan' => $pegawai->no_sk_pengangkatan ?? '-',
                'tgl_pengangkatan' => $pegawai->tgl_pengangkatan ? date('Y-m-d', strtotime($pegawai->tgl_pengangkatan)) : '-',
                'status_kepegawaian' => $pegawai->status_kepegawaian ?? '-',
                'pangkat' => $pegawai->pangkat ?? '-',
                'golongan' => $pegawai->golongan ?? '-',
                'no_tlp' => $pegawai->no_tlp ?? '-',
                'email' => $pegawai->email ?? '-',
                'pendidikan_terakhir' => $pegawai->pendidikan_terakhir ?? '-',
                'tahun_lulus' => $pegawai->tahun_lulus ?? '-',
                'jabatan' => $pegawai->jabatan ? $pegawai->jabatan->nama_jabatan : '-',
                'status_pegawai' => $pegawai->status_pegawai ?? '-',
                'gambar' => [
                    'foto_pegawai' => $pegawai->foto_pegawai ? asset('foto_profil/' . $pegawai->foto_pegawai) : '-',
                    'foto_ijazah' => $pegawai->foto_ijazah ? asset($pegawai->foto_ijazah) : '-',
                    'foto_ktp' => $pegawai->foto_ktp ? asset($pegawai->foto_ktp) : '-',
                    'foto_kk' => $pegawai->foto_kk ? asset($pegawai->foto_kk) : '-',
                    'foto_akte_kelahiran' => $pegawai->foto_akte_kelahiran ? asset($pegawai->foto_akte_kelahiran) : '-',
                ],
                'data_tambahan' => $pegawai->walikelas->count() > 0 || $pegawai->kepalaJurusan->count() > 0 || $pegawai->tugasTambahan->count() > 0 ? [
                    'kelas_walikelas' => $pegawai->walikelas->map(function ($kelas) {
                        return $kelas->nama_kelas;
                    }),
                    'kepala_jurusan' => $pegawai->kepalaJurusan->map(function ($jurusan) {
                        return $jurusan->nama_jurusan;
                    }),
                    'tugas_tambahan' => $pegawai->tugasTambahan->map(function ($tugas) {
                        return $tugas->nama_tugas;
                    }),
                ] : [
                    'keterangan' => 'Tidak ada data tambahan',
                ],
            ],
        ], 200);
    }

}
