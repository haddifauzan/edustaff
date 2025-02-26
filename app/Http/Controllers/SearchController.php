<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Prestasi;
use App\Models\TugasTambahan;
use App\Models\Mapel;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        
        $results = [
            'pegawais' => Pegawai::where('nama_pegawai', 'LIKE', "%{$query}%")->get(),
            'users' => User::where('nama_user', 'LIKE', "%{$query}%")->get(),
            'jabatans' => Jabatan::where('nama_jabatan', 'LIKE', "%{$query}%")->get(),
            'jurusans' => Jurusan::where('nama_jurusan', 'LIKE', "%{$query}%")->get(),
            'kelas' => Kelas::where('nama_kelas', 'LIKE', "%{$query}%")->get(),
            'prestasis' => Prestasi::where('nama_prestasi', 'LIKE', "%{$query}%")->get(),
            'tugastambahans' => TugasTambahan::where('nama_tugas', 'LIKE', "%{$query}%")->get(),
            'mapels' => Mapel::where('nama_pelajaran', 'LIKE', "%{$query}%")->get(),
        ];

        return response()->json($results); // Mengembalikan sebagai JSON
    }

    public function searchOperator(Request $request)
    {
        $query = $request->input('query');
    
        // Melakukan pencarian di beberapa model
        $results = [
            'pegawais' => Pegawai::where('nama_pegawai', 'LIKE', "%{$query}%")->get(),
            'jabatans' => Jabatan::where('nama_jabatan', 'LIKE', "%{$query}%")->get(),
            'tugastambahans' => TugasTambahan::where('nama_tugas', 'LIKE', "%{$query}%")->get(),
            'mapels' => Mapel::where('nama_pelajaran', 'LIKE', "%{$query}%")->get(),
            'kelas' => Kelas::where('nama_kelas', 'LIKE', "%{$query}%")->get(),
            'kepalajurusans' => Jurusan::where('nama_jurusan', 'LIKE', "%{$query}%")->get(),
            'perubahans' => Pengajuan::where('status', 'LIKE', "%{$query}%")->get(),
            'prestasis' => Prestasi::where('nama_prestasi', 'LIKE', "%{$query}%")->get(),
            'pengajuans' => Pengajuan::where('judul', 'LIKE', "%{$query}%")->get(),
        ];
    
        return response()->json($results); // Mengembalikan hasil pencarian dalam format JSON
    }
    



}

