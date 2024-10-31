<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TugasTambahan;
use App\Models\Pegawai;
use PDF;

class LaporanTugasController extends Controller
{
    public function index(Request $request)
    {
        // Filter data berdasarkan input pencarian dan filter
        $query = TugasTambahan::with('pegawai'); // Relasi pegawai dari model TugasTambahan

        if ($request->filled('search')) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('nama_pegawai', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tahun_ajaran')) {
            $tahunAjaran = explode('-', $request->tahun_ajaran);
            $startYear = $tahunAjaran[0] . '-01-01';
            $endYear = $tahunAjaran[1] . '-12-31';
            $query->whereBetween('created_at', [$startYear, $endYear]);
        }

        if ($request->filled('id_jabatan')) {
            $query->where('id_tugas_tambahan', $request->id_jabatan);
        }

        // Dapatkan data tugas tambahan
        $tugasTambahan = $query->get();

        // Ambil daftar tugas tambahan untuk filter
        $tugasTambahanList = TugasTambahan::all();

        return view('admin.laporan.laporan-tugas', compact('tugasTambahan', 'tugasTambahanList'));
    }

    public function downloadPDF(Request $request)
    {
        // Filter data seperti di method index
        $query = TugasTambahan::with('pegawai');

        if ($request->filled('search')) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('nama_pegawai', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tahun_ajaran')) {
            $tahunAjaran = explode('-', $request->tahun_ajaran);
            $startYear = $tahunAjaran[0] . '-01-01';
            $endYear = $tahunAjaran[1] . '-12-31';
            $query->whereBetween('created_at', [$startYear, $endYear]);
        }

        if ($request->filled('id_jabatan')) {
            $query->where('id_tugas_tambahan', $request->id_jabatan);
        }

        $tugasTambahan = $query->get();

        // Mendapatkan data Kepala Sekolah
        $kepalaSekolah = Pegawai::whereHas('jabatan', function($query) {
            $query->where('nama_jabatan', 'Kepala Sekolah');
        })->first();

        // Mengirim data ke view PDF
        $pdf = PDF::loadView('admin.laporan.pdf.tugas-tambahan-pdf', [
            'tugasTambahan' => $tugasTambahan,
            'kepalaSekolah' => $kepalaSekolah
        ]);

        // Return PDF for download
        return $pdf->stream('Laporan_Tugas_Tambahan_Pegawai.pdf');
    }


}
