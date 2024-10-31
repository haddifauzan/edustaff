<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiwayatJabatan;
use App\Models\Jabatan;
use App\Models\Pegawai;
use PDF;

class LaporanRiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data jabatan untuk dropdown
        $jabatanList = Jabatan::all();
        
        // Ambil data riwayat jabatan dengan filter
        $riwayatJabatan = RiwayatJabatan::with(['pegawai', 'jabatan'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('pegawai', function ($q) use ($request) {
                    $q->where('nama_pegawai', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                      ->orWhere('nip', 'like', '%' . $request->search . '%')
                      ->orWhere('nik', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('tahun_ajaran'), function ($query) use ($request) {
                $tahunAjaran = explode('-', $request->tahun_ajaran);
                $startYear = $tahunAjaran[0] . '-01-01';
                $endYear = $tahunAjaran[1] . '-12-31';
                $query->whereBetween('created_at', [$startYear, $endYear]);
            })
            ->when($request->id_jabatan, function ($query) use ($request) {
                $query->where('id_jabatan', $request->id_jabatan);
            })
            ->get();

        return view('admin.laporan.laporan-riwayat-jabatan', compact('riwayatJabatan', 'jabatanList'));
    }

    public function downloadPDF(Request $request)
    {
        // Ambil data riwayat jabatan dengan filter yang sama seperti di method index
        $riwayatJabatan = RiwayatJabatan::with(['pegawai', 'jabatan'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('pegawai', function ($q) use ($request) {
                    $q->where('nama_pegawai', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%')
                      ->orWhere('nip', 'like', '%' . $request->search . '%')
                      ->orWhere('nik', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('tahun_ajaran'), function ($query) use ($request) {
                $tahunAjaran = explode('-', $request->tahun_ajaran);
                $startYear = $tahunAjaran[0] . '-01-01';
                $endYear = $tahunAjaran[1] . '-12-31';
                $query->whereBetween('created_at', [$startYear, $endYear]);
            })
            ->when($request->id_jabatan, function ($query) use ($request) {
                $query->where('id_jabatan', $request->id_jabatan);
            })
            ->get();

        // Mendapatkan data Kepala Sekolah
        $kepalaSekolah = Pegawai::whereHas('jabatan', function($query) {
            $query->where('nama_jabatan', 'Kepala Sekolah');
        })->first();

        // Mengirim data ke view PDF
        $pdf = PDF::loadView('admin.laporan.pdf.riwayat-jabatan-pdf', [
            'riwayatJabatan' => $riwayatJabatan,
            'kepalaSekolah' => $kepalaSekolah
        ]);
        return $pdf->stream('laporan_riwayat_jabatan.pdf');
    }
}
