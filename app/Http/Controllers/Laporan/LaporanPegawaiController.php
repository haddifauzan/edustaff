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
        $pegawai = Pegawai::query();

        $jabatanList = Jabatan::all();
        // Pencarian berdasarkan nama_pegawai, email, nip, atau nik
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $pegawai->where(function($query) use ($searchTerm) {
                $query->where('nama_pegawai', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('nip', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('nik', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Filter berdasarkan Tahun Ajaran
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran != '') {
            $tahunAjaran = explode('-', $request->tahun_ajaran);
            $pegawai->whereBetween('created_at', [$tahunAjaran[0] . '-01-01', $tahunAjaran[1] . '-12-31']);
        }

        // Filter berdasarkan Jabatan
        if ($request->has('id_jabatan') && $request->id_jabatan != '') {
            $pegawai->where('id_jabatan', $request->id_jabatan);
        }

        // Filter berdasarkan Status Pegawai
        if ($request->has('status_pegawai') && $request->status_pegawai != '') {
            $pegawai->where('status_pegawai', $request->status_pegawai);
        }

        // Filter berdasarkan Agama
        if ($request->has('agama') && $request->agama != '') {
            $pegawai->where('agama', $request->agama);
        }

        // Filter berdasarkan Status Pernikahan
        if ($request->has('status_pernikahan') && $request->status_pernikahan != '') {
            $pegawai->where('status_pernikahan', $request->status_pernikahan);
        }

        // Filter berdasarkan Status Kepegawaian
        if ($request->has('status_kepegawaian') && $request->status_kepegawaian != '') {
            $pegawai->where('status_kepegawaian', $request->status_kepegawaian);
        }

        // Filter berdasarkan Jenis Kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $pegawai->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Ambil semua filter yang aktif
        $activeFilters = $request->only([
            'tahun_ajaran', 'id_jabatan', 'status_pegawai', 'agama',
            'status_pernikahan', 'status_kepegawaian', 'jenis_kelamin'
        ]);

        // Ambil data pegawai yang telah difilter
        $pegawai = $pegawai->get();

        return view('admin.laporan.laporan-pegawai', compact('pegawai', 'jabatanList', 'activeFilters'));
    }

    public function downloadPDF(Request $request)
    {
        $pegawai = $this->getPegawaiData($request);
        $pdf = PDF::loadView('admin.laporan.pdf.pegawai-pdf', compact('pegawai'));
        
        // Ubah nama file saat download agar lebih sesuai
        return $pdf->download('laporan-pegawai.pdf');
    }

    
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
        
        $pdf = PDF::loadView('admin.laporan.pdf.pegawai-detail-pdf', compact('pegawai'));
        
        return $pdf->download($pegawai->nama_pegawai . '_detail.pdf');
    }
    
}
