<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Pegawai;
use PDF;

class LaporanPrestasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestasi::with('pegawai'); // Tambahkan relasi ke pegawai

        // Filter berdasarkan input pencarian
        if ($request->has('search')) {
            $query->whereHas('pegawai', function($q) use ($request) {
                $q->where(function($q) use ($request) {
                    $q->where('nama_pegawai', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('nik', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('nip', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->search . '%');
                });
            });
        }

        if ($request->filled('tahun_ajaran')) {
            $tahunAjaran = explode('-', $request->tahun_ajaran);
            $startYear = $tahunAjaran[0] . '-01-01';
            $endYear = $tahunAjaran[1] . '-12-31';
            $query->whereBetween('created_at', [$startYear, $endYear]);
        }

        // Filter berdasarkan nama prestasi
        if ($request->has('search_prestasi')) {
            $query->where('nama_prestasi', 'LIKE', '%' . $request->search_prestasi . '%');
        }

        // Filter berdasarkan status prestasi
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $prestasi = $query->get();

        return view('admin.laporan.laporan-prestasi', compact('prestasi'));
    }

    // Method untuk generate PDF daftar prestasi
    public function downloadPDF(Request $request)
    {
        $query = Prestasi::query();

        // Filter berdasarkan input pencarian
        if ($request->has('search')) {
            $query->where('nama_prestasi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi_prestasi', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('tahun_ajaran')) {
            $tahunAjaran = explode('-', $request->tahun_ajaran);
            $startYear = $tahunAjaran[0] . '-01-01';
            $endYear = $tahunAjaran[1] . '-12-31';
            $query->whereBetween('created_at', [$startYear, $endYear]);
        }

        // Filter berdasarkan nama prestasi
        if ($request->has('search_prestasi')) {
            $query->where('nama_prestasi', 'LIKE', '%' . $request->search_prestasi . '%');
        }

        // Filter berdasarkan status prestasi
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $prestasi = $query->get();

        // Mendapatkan data Kepala Sekolah
        $kepalaSekolah = Pegawai::whereHas('jabatan', function($query) {
            $query->where('nama_jabatan', 'Kepala Sekolah');
        })->first();

        // Mengirim data ke view PDF
        $pdf = PDF::loadView('admin.laporan.pdf.prestasi-pdf', [
            'prestasi' => $prestasi,
            'kepalaSekolah' => $kepalaSekolah
        ])->setPaper('a4', 'portrait');
        return $pdf->stream('laporan_prestasi_pegawai.pdf');
    }

    // Method untuk generate PDF detail prestasi
    public function prestasiDetailPdf($id)
    {
        $prestasi = Prestasi::findOrFail($id);

        $pdf = PDF::loadView('admin.laporan.pdf.prestasi-detail-pdf', compact('prestasi'))->setPaper('a4');
        return $pdf->stream('detail_prestasi_pegawai_' . $prestasi->nama_prestasi . '.pdf');
    }
}
