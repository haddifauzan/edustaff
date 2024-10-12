<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\RiwayatJabatan;

class JabatanController extends Controller
{
    public function index_admin(Request $request)
    {
        $search = $request->input('search');

        $jabatans = Jabatan::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_jabatan', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.data_master.jabatan', compact('jabatans'));
    }

    public function index_operator(Request $request)
    {
        $search = $request->input('search');
        $jabatan = $request->input('jabatan');

        $pegawais = Pegawai::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    return $query->where('nama_pegawai', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($jabatan, function ($query, $jabatan) {
                if ($jabatan == "-") {
                    return $query->whereNull('id_jabatan');
                }
                return $query->where('id_jabatan', $jabatan);
            })
            ->get();

        $jabatans = Jabatan::all();

        return view('operator.jabatan.index', compact('pegawais', 'jabatans'));    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required',
            'golongan' => 'required',
            'level_jabatan' => 'required|integer',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi_jabatan' => $request->deskripsi_jabatan,
            'golongan' => $request->golongan,
            'level_jabatan' => $request->level_jabatan,
        ]);

        return redirect()->route('admin.jabatan')->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required',
            'golongan' => 'required',
            'level_jabatan' => 'required|integer',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi_jabatan' => $request->deskripsi_jabatan,
            'golongan' => $request->golongan,
            'level_jabatan' => $request->level_jabatan,
        ]);

        return redirect()->route('admin.jabatan')->with('success', 'Jabatan berhasil diupdate!');
    }

    public function destroy($id)
    {
        Jabatan::findOrFail($id)->delete();
        return redirect()->route('admin.jabatan')->with('success', 'Jabatan berhasil dihapus!');
    }

    public function updateJabatan(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required',
            'jabatan' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
            'is_guru' => 'nullable|boolean',
        ]);
            
        $pegawai = Pegawai::findOrFail($request->id_pegawai);
        
        $jabatanBerubah = $pegawai->id_jabatan != $request->jabatan;
        
        $pegawai->id_jabatan = $request->jabatan;
        $pegawai->is_guru = $request->is_guru ?? false;
        $pegawai->save();
        
        if ($jabatanBerubah || !$pegawai->riwayatJabatan->count()) {
            RiwayatJabatan::create([
                'id_pegawai' => $request->id_pegawai,
                'id_jabatan' => $request->jabatan,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'is_guru' => $request->is_guru ?? false,
                ]);
        } else {
            $riwayatJabatan = RiwayatJabatan::where('id_pegawai', $request->id_pegawai)
            ->where('id_jabatan', $pegawai->id_jabatan)
            ->orderBy('created_at', 'desc') // Pastikan mendapatkan riwayat terakhir
            ->first();

            if ($riwayatJabatan) {
                $riwayatJabatan->update([
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'is_guru' => $request->is_guru ?? false,
                ]);
            }
        }
        
        return redirect()->route('operator.jabatan.pegawai')->with('success', 'Jabatan pegawai berhasil diperbarui.');
    }

    // JabatanController.php

    public function deleteRiwayat($id)
    {
        $riwayat = RiwayatJabatan::findOrFail($id);
        $riwayat->delete();

        return redirect()->back()->with('success', 'Riwayat jabatan berhasil dihapus.');
    }

    public function deleteAllRiwayat($id_pegawai)
    {
        RiwayatJabatan::where('id_pegawai', $id_pegawai)->delete();

        return redirect()->back()->with('success', 'Semua riwayat jabatan berhasil dihapus.');
    }


}
