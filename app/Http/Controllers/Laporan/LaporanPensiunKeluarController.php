<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PensiunKeluar;
use App\Models\Pegawai;
use PDF;

class LaporanPensiunKeluarController extends Controller
{
    public function index(Request $request)
    {
        // Filter data berdasarkan pencarian, tahun ajaran, jenis, status pengajuan, dan pengaju
        $pensiunKeluar = PensiunKeluar::with('pegawai')
        ->when($request->search, function ($query, $search) {
            $query->whereHas('pegawai', function ($q) use ($search) {
                $q->where('nama_pegawai', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%");
            });
        })
        ->when($request->tahun_ajaran, function ($query, $tahunAjaran) {
            $query->where('tahun_ajaran', $tahunAjaran);
        })
        ->when($request->jenis_pengajuan, function ($query, $jenisPengajuan) {
            $query->where('jenis_pengajuan', $jenisPengajuan);
        })
        ->when($request->status_pengajuan, function ($query, $statusPengajuan) {
            $query->where('status_pengajuan', $statusPengajuan);
        })
        ->when($request->pengaju, function ($query, $pengaju) {
            $query->where('pengaju', $pengaju);
        })
        ->get();

        // Return ke view dengan data yang sudah difilter
        return view('admin.laporan.laporan-pensiun-keluar', compact('pensiunKeluar'));
    }

    public function downloadPDF(Request $request)
    {
        // Sama seperti filter di atas, untuk data yang akan dicetak
        $pensiunKeluar = PensiunKeluar::with('pegawai')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('pegawai', function ($q) use ($search) {
                    $q->where('nama_pegawai', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($request->tahun_ajaran, function ($query, $tahunAjaran) {
                $query->where('tahun_ajaran', $tahunAjaran);
            })
            ->when($request->jenis_pengajuan, function ($query, $jenisPengajuan) {
                $query->where('jenis_pengajuan', $jenisPengajuan);
            })
            ->when($request->status_pengajuan, function ($query, $statusPengajuan) {
                $query->where('status_pengajuan', $statusPengajuan);
            })
            ->when($request->pengaju, function ($query, $pengaju) {
                $query->where('pengaju', $pengaju);
            })
            ->get();

        // Mendapatkan data Kepala Sekolah
        $kepalaSekolah = Pegawai::whereHas('jabatan', function($query) {
            $query->where('nama_jabatan', 'Kepala Sekolah');
        })->first();

        // Mengirim data ke view PDF
        $pdf = PDF::loadView('admin.laporan.pdf.pensiun-keluar-pdf', [
            'pensiunKeluar' => $pensiunKeluar,
            'kepalaSekolah' => $kepalaSekolah
        ]);
        return $pdf->stream('Laporan_Pensiun_Keluar_Pegawai.pdf');
    }
}
