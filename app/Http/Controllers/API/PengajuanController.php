<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PensiunKeluar;
use App\Models\User;

class PengajuanController extends Controller
{
    public function getPengajuan()
    {
        try {
            $pengajuan = PensiunKeluar::where('id_pegawai', auth()->user()->pegawai->id_pegawai)->get();
            
            if ($pengajuan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum pernah mengajukan pensiun keluar. Silahkan login web pegawai untuk mengajukan pensiun keluar.',
                    'route' => route('pegawai.pengajuan')
                ]);
            }
        
            $pengajuanWithDetails = $pengajuan->map(function($p) {
                $p->operator = User::find($p->id_operator)->nama_user;
                $p->waktu_pengajuan = $p->created_at->format('d M Y, H:i'); // Format created_at ke waktu_pengajuan
                return $p;
            });
        
            return response()->json([
                'success' => true,
                'message' => 'Data pengajuan berhasil ditampilkan',
                'route' => route('pegawai.pengajuan'),
                'data' => $pengajuanWithDetails
            ], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menampilkan data pengajuan',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}
