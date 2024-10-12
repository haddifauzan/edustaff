<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Pegawai;

class MapelController extends Controller
{
    public function index_admin(Request $request)
    {
        $search = $request->input('search');
        $mapels = Mapel::query()
            ->where(function ($query) use ($search) {
                $query->where('nama_pelajaran', 'like', "%{$search}%")
                    ->orWhere('kode_pelajaran', 'like', "%{$search}%");
            })
            ->get();

        $jurusans = Jurusan::all();

        return view('admin.data_master.mapel', compact('mapels', 'jurusans'));
    }

    public function index_operator(Request $request)
    {
        $search = $request->input('search');
        $mapels = Mapel::with(['guru', 'kelas'])
            ->where(function ($query) use ($search) {
                $query->where('nama_pelajaran', 'like', "%{$search}%")
                    ->orWhere('kode_pelajaran', 'like', "%{$search}%");
            })
            ->get();

        $gurus = Pegawai::where('is_guru', true)->get();
        $kelass = Kelas::all();

        return view('operator.guru_mapel.index', compact('mapels', 'gurus', 'kelass'));
    }

    // Menambah mapel baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelajaran' => 'required',
            'kode_pelajaran' => 'required|unique:tbl_mapel,kode_pelajaran',
            'jenis_mapel' => 'required',
            'tingkat' => 'required',
            'jurusan' => 'required_if:jenis_mapel,Kejuruan', // Hanya wajib jika Kejuruan
        ]);

        Mapel::create([
            'nama_pelajaran' => $request->nama_pelajaran,
            'kode_pelajaran' => $request->kode_pelajaran,
            'deskripsi' => $request->deskripsi,
            'jenis_mapel' => $request->jenis_mapel,
            'tingkat' => $request->tingkat,
            'id_jurusan' => $request->jurusan, // Simpan jurusan jika ada
        ]);

        return redirect()->route('admin.mapel')->with('success', 'Mapel berhasil ditambahkan.');
    }

    // Update mapel
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
            'kode_pelajaran' => 'required|string|max:10|unique:tbl_mapel,kode_pelajaran,' . $id . ',id_pelajaran',
            'jenis_mapel' => 'required|string',
            'tingkat' => 'required|string',
            'jurusan' => 'required_if:jenis_mapel,Kejuruan', // Hanya wajib jika Kejuruan
        ]);

        // Update data mapel
        $mapel = Mapel::findOrFail($id);
        $mapel->update([
            'nama_pelajaran' => $request->nama_pelajaran,
            'kode_pelajaran' => $request->kode_pelajaran,
            'deskripsi' => $request->deskripsi,
            'jenis_mapel' => $request->jenis_mapel,
            'tingkat' => $request->tingkat,
            'id_jurusan' => $request->jurusan, // Simpan jurusan jika ada
        ]);

        return redirect()->route('admin.mapel')->with('success', 'Mata Pelajaran berhasil diupdate.');
    }

    // Hapus mapel
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('admin.mapel')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }

    public function update_guru_mapel(Request $request, $id_pelajaran)
    {
        // Validasi input
        $request->validate([
            'kelas' => 'array',
        ]);

        // Update Mapel (Hubungkan dengan guru)
        $mapel = Mapel::findOrFail($id_pelajaran);
        $mapel->id_pegawai = $request->id_pegawai;
        $mapel->save();

        // Update hubungan dengan kelas (many-to-many)
        $mapel->kelas()->sync($request->kelas);

        return redirect()->back()->with('success', 'Data mapel berhasil diperbarui.');
    }

}
