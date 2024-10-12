<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Pegawai;

class JurusanController extends Controller
{
    public function index_admin(Request $request)
    {
        $search = $request->input('search');

        $jurusans = Jurusan::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_jurusan', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.data_master.jurusan', compact('jurusans'));
    }

    public function index_operator(Request $request)
    {
        $search = $request->input('search');

        $jurusans = Jurusan::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_jurusan', 'like', "%{$search}%");
            })
            ->with('kepalaJurusan')
            ->get();

        $pegawais = Pegawai::all(); // Untuk menampilkan pilihan pegawai sebagai kepala jurusan
        
        return view('operator.kepala_jurusan.index', compact('jurusans', 'pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'singkatan' => 'required',
            'deskripsi_jurusan' => 'string',
        ]);

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
            'singkatan' => $request->singkatan,
            'deskripsi_jurusan' => $request->deskripsi_jurusan,
        ]);

        return redirect()->route('admin.jurusan')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required',
            'singkatan' => 'required',
            'deskripsi_jurusan' => 'string',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
            'singkatan' => $request->singkatan,
            'deskripsi_jurusan' => $request->deskripsi_jurusan,
        ]);

        return redirect()->route('admin.jurusan')->with('success', 'Jurusan berhasil diupdate!');
    }

    public function destroy($id)
    {
        Jurusan::findOrFail($id)->delete();
        return redirect()->route('admin.jurusan')->with('success', 'Jurusan berhasil dihapus!');
    }

    public function updateKepalaJurusan(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->kepala_jurusan = $request->id_kepala_jurusan;
        $jurusan->save();

        return redirect()->route('operator.kepala_jurusan.pegawai')->with('success', 'Kepala Jurusan berhasil diupdate!');
    }
}
