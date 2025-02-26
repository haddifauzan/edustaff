<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestasi;

class PrestasiController extends Controller
{
    public function getPrestasi()
    {
        try {
            $prestasi = Prestasi::where('id_pegawai', auth()->user()->pegawai->id_pegawai)->get();
    
            if (count($prestasi) == 0) {
                return response()->json(['success' => false, 'message' => 'Anda belum pernah mengajukan prestasi. Silahkan login web pegawai untuk mengajukan prestasi.', 'route' => route('pegawai.prestasi')]);
            }
            // Transformasi data: Ubah nama file menjadi URL lengkap
            foreach ($prestasi as $key => $value) {
                $prestasi[$key]['foto_sertifikat'] = url('prestasi/' . $value['foto_sertifikat']);
            }
    
            return response()->json(['success' => true, 'message' => 'Data prestasi anda berhasil ditampilkan', 'route' => route('pegawai.prestasi'), 'data' => $prestasi], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menampilkan data prestasi', 'error' => $e->getMessage()], 500);
        }
    }
}
