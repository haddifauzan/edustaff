<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konfirmasi;
use App\Models\User;

class PerubahanController extends Controller
{
    public function getPerubahan()
    {
        try {
            $pengajuan = Konfirmasi::where('id_pegawai', auth()->user()->pegawai->id_pegawai)->get();

            if ($pengajuan->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum pernah mengajukan perubahan data. Silahkan login web pegawai untuk mengajukan perubahan data.',
                    'route' => route('pegawai.perubahan')
                ]);
            }

            $pengajuanWithDetails = $pengajuan->map(function($p) {
                // Decode kolom_diubah JSON string to object
                $p->kolom_diubah = json_decode($p->kolom_diubah);
                // Add operator name by finding User
                $p->nama_operator = User::find($p->id_operator)->nama_user ?? 'Tidak ditemukan';
                return $p;
            });

            return response()->json([
                'success' => true,
                'message' => 'Data perubahan berhasil ditampilkan',
                'route' => route('pegawai.perubahan'),
                'data' => $pengajuanWithDetails
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menampilkan data perubahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPerubahanDetail($id_konfirmasi)
    {
        try {
            // Find the confirmation record by ID
            $pengajuan = Konfirmasi::findOrFail($id_konfirmasi);

            // Decode kolom_diubah JSON string to object
            $pengajuan->kolom_diubah = json_decode($pengajuan->kolom_diubah);
            // Add operator name by finding User
            $pengajuan->nama_operator = User::find($pengajuan->id_operator)->nama_user ?? 'Tidak ditemukan';

            return response()->json([
                'success' => true,
                'message' => 'Detail perubahan berhasil ditampilkan',
                'data' => $pengajuan
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data konfirmasi tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menampilkan detail perubahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
