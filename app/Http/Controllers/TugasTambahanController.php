<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasTambahan;
use App\Models\Pegawai;

class TugasTambahanController extends Controller
{
    // Method untuk menampilkan halaman tugas tambahan
    public function index(Request $request)
    {
        $pegawais = Pegawai::all();
        $tugasTambahanDaftar = TugasTambahan::all();  // Mengambil semua data pegawai

        $tugasTambahan = TugasTambahan::with('pegawai')
            ->where(function ($query) use ($request) {
                if ($request->has('nama_tugas')) {
                    $query->where('nama_tugas', 'LIKE', '%' . $request->input('nama_tugas') . '%');
                }
            })
            ->get();

        return view('operator.tugas_tambahan.index', compact('pegawais', 'tugasTambahan', 'tugasTambahanDaftar'));
    }

    // Method untuk menambah tugas tambahan
    public function store(Request $request)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'id_pegawai' => 'required|exists:tbl_pegawai,id_pegawai',
        ]);

        TugasTambahan::create([
            'nama_tugas' => $request->nama_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'id_pegawai' => $request->id_pegawai,
        ]);

        return redirect()->back()->with('success', 'Tugas tambahan berhasil ditambahkan.');
    }

    // Method untuk mengupdate tugas tambahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'id_pegawai' => 'required|exists:tbl_pegawai,id_pegawai',
        ]);

        $tugas = TugasTambahan::findOrFail($id);

        $tugas->update([
            'nama_tugas' => $request->nama_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'id_pegawai' => $request->id_pegawai,
        ]);

        return redirect()->back()->with('success', 'Tugas tambahan berhasil diupdate.');
    }

    // Method untuk menghapus tugas tambahan
    public function destroy($id)
    {
        $tugas = TugasTambahan::findOrFail($id);
        $tugas->delete();

        return redirect()->back()->with('success', 'Tugas tambahan berhasil dihapus.');
    }

    // Method untuk mengatur tugas tambahan ke pegawai
    public function assign(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:tbl_pegawai,id_pegawai',
            'tugas_tambahan' => 'required|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'id_pegawai' => 'exists:tbl_pegawai,id_pegawai',
        ]);

        TugasTambahan::create([
            'nama_tugas' => $request->tugas_tambahan,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'id_pegawai' => $request->id_pegawai,
        ]);

        return redirect()->back()->with('success', 'Tugas tambahan berhasil diatur untuk pegawai.');
    }
}
