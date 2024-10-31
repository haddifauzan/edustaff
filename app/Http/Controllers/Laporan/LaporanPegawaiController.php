<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Exports\PegawaiExport;
use PDF;

class LaporanPegawaiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data pegawai yang telah difilter
        $pegawai = $this->getPegawaiData($request);
        $jabatanList = Jabatan::all();

        // Ambil semua filter yang aktif
        $activeFilters = $request->only([
            'tahun_ajaran', 'id_jabatan', 'status_pegawai', 'agama',
            'status_pernikahan', 'status_kepegawaian', 'jenis_kelamin'
        ]);

        return view('admin.laporan.laporan-pegawai', compact('pegawai', 'jabatanList', 'activeFilters'));
    }

    public function downloadPDF(Request $request)
    {
        $pegawai = $this->getPegawaiData($request);

        // Mendapatkan data Kepala Sekolah
        $kepalaSekolah = Pegawai::whereHas('jabatan', function($query) {
            $query->where('nama_jabatan', 'Kepala Sekolah');
        })->first();

        // Mengirim data ke view PDF
        $pdf = PDF::loadView('admin.laporan.pdf.pegawai-pdf', [
            'pegawai' => $pegawai,
            'search' => $request->search,
            'tahunAjaran' => $request->tahun_ajaran,
            'jabatan' => $request->jabatan,
            'statusPegawai' => $request->status_pegawai,
            'agama' => $request->agama,
            'statusPernikahan' => $request->status_pernikahan,
            'statusKepegawaian' => $request->status_kepegawaian,
            'jenisKelamin' => $request->jenis_kelamin,
            'kepalaSekolah' => $kepalaSekolah
        ]);

        return $pdf->stream('laporan-pegawai.pdf');
    }


    // Fungsi getPegawaiData untuk filter yang konsisten
    private function getPegawaiData(Request $request)
    {
        $pegawai = Pegawai::query();

        // Filter pencarian umum
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $pegawai->where(function($query) use ($searchTerm) {
                $query->where('nama_pegawai', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('nip', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('nik', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Filter berdasarkan Tahun Ajaran
        if ($request->filled('tahun_ajaran')) {
            $tahunAjaran = explode('-', $request->tahun_ajaran);
            $startYear = $tahunAjaran[0] . '-01-01';
            $endYear = $tahunAjaran[1] . '-12-31';
            $pegawai->whereBetween('created_at', [$startYear, $endYear]);
        }

        // Filter lainnya berdasarkan input yang ada
        $filters = [
            'id_jabatan' => 'id_jabatan',
            'status_pegawai' => 'status_pegawai',
            'agama' => 'agama',
            'status_pernikahan' => 'status_pernikahan',
            'status_kepegawaian' => 'status_kepegawaian',
            'jenis_kelamin' => 'jenis_kelamin',
        ];

        foreach ($filters as $requestKey => $dbColumn) {
            if ($request->filled($requestKey)) {
                $pegawai->where($dbColumn, $request->input($requestKey));
            }
        }

        return $pegawai->get();
    }

    public function downloadPegawaiDetailPDF($id)
    {
        $pegawai = Pegawai::with(['jabatan', 'riwayatJabatan', 'tugasTambahan', 'mapels.mapelKelas.kelas', 'walikelas', 'kepalaJurusan'])->findOrFail($id);
        
        $pdf = PDF::loadView(
            'admin.laporan.pdf.pegawai-detail-pdf',
            compact('pegawai')
        );
        
        return $pdf->stream($pegawai->nama_pegawai . '_detail.pdf');
    }
    
}
