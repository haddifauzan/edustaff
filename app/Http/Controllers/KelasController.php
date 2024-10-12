<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Pegawai;

class KelasController extends Controller
{
    public function index_admin(Request $request)
    {
        $search = $request->input('search');
        $kelass = Kelas::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_kelas', 'like', "%{$search}%");
            })
            ->get();
        $jurusans = Jurusan::all();

        return view('admin.data_master.kelas', compact('kelass', 'jurusans'));
    }

    public function index_operator(Request $request)
    {
        $search = $request->input('search');
        $kelass = Kelas::query()
            ->when($search, function($query) use ($search) {
                return $query->where('nama_kelas', 'like', "%{$search}%");
            })
            ->get();
        $walikelas = Pegawai::where('is_guru', true)->doesntHave('kelas')->get();
        $gurus = Pegawai::where('is_guru', true)->get();

        return view('operator.walikelas.index', compact('kelass', 'kelass', 'walikelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required',
            'jurusan_id' => 'required|exists:tbl_jurusan,id_jurusan',
            'kelompok' => 'required',
            'nama_kelas' => 'required|unique:tbl_kelas,nama_kelas', // Perbaikan di sini
        ]);

        Kelas::create([
            'tingkat' => $request->tingkat,
            'id_jurusan' => $request->jurusan_id,
            'kelompok' => $request->kelompok,
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    // Method untuk mengupdate kelas
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'tingkat' => 'required',
            'jurusan_id' => 'required|exists:tbl_jurusan,id_jurusan',
            'kelompok' => 'required',
            'nama_kelas' => 'required|unique:tbl_kelas,nama_kelas,' . $id . ',id_kelas', // Pastikan ini benar
        ]);

        $kelas->update([
            'tingkat' => $request->tingkat,
            'id_jurusan' => $request->jurusan_id,
            'kelompok' => $request->kelompok,
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    // Method untuk menghapus kelas
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    public function updateWalikelas(Request $request, $id_kelas)
    {
        $request->validate([
            'id_walikelas' => 'required|unique:tbl_kelas,id_walikelas', // Wali kelas tidak boleh sama        
        ]);

        $kelas = Kelas::findOrFail($id_kelas);
        $kelas->id_walikelas = $request->id_walikelas;
        $kelas->save();

        return redirect()->route('operator.walikelas.pegawai')->with('success', 'Wali kelas berhasil diupdate');
    }
}
