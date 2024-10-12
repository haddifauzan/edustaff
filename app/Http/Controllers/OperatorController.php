<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    // Menampilkan dan mencari operator
    public function index_admin(Request $request)
    {
        $search = $request->input('search');

        $operators = User::query()
            ->where('role', 'Operator')
            ->when($search, function ($query, $search) {
                return $query->where('nama_user', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.operator.operator', compact('operators'));
    }

    // Method untuk menghapus operator
    public function destroy($id)
    {
        $operator = User::findOrFail($id);
        $operator->delete();

        return redirect()->route('admin.operator')->with('success', 'Operator berhasil dihapus');
    }

    // Method untuk toggle status aktif/nonaktif operator
    public function toggleStatus($id)
    {
        $operator = User::where('id_user', $id)->first();
        
        // Toggle status
        $operator->status_akun = $operator->status_akun === 'Aktif' ? 'Non-Aktif' : 'Aktif';
        
        // Simpan perubahan
        $operator->save();

        // Kirim respons dalam format JSON dengan status akun
        return response()->json([
            'status' => 'success',
            'status_akun' => $operator->status_akun
        ]);
    }


    // Menampilkan form tambah operator
    public function create()
    {
        return view('admin.operator.tambah-edit');
    }

    // Menyimpan operator baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|email|unique:tbl_user',
            'no_hp' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $operator = new User();
        $operator->nama_user = $request->input('nama_user');
        $operator->email = $request->input('email');
        $operator->no_hp = $request->input('no_hp');
        $operator->role = 'Operator';
        $operator->status_akun = "Aktif";
        $operator->password = Hash::make($request->input('password'));

        if ($request->hasFile('foto_profil')) {
            $imageName = time() . '.' . $request->file('foto_profil')->extension();
            $request->file('foto_profil')->move(public_path('foto_profil'), $imageName);
            $operator->foto_profil = $imageName;
        }

        $operator->save();

        return redirect()->route('admin.operator')->with('success', 'Operator berhasil ditambahkan');
    }

    // Menampilkan form edit operator
    public function edit($id)
    {
        $operator = User::findOrFail($id);
        return view('admin.operator.tambah-edit', compact('operator'));
    }

    // Mengupdate data operator
    public function update(Request $request, $id)
    {
        $operator = User::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|email|unique:tbl_user,email,' . $operator->id_user . ',id_user',
            'no_hp' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $operator->nama_user = $request->input('nama_user');
        $operator->email = $request->input('email');
        $operator->no_hp = $request->input('no_hp');

        if ($request->filled('password')) {
            $operator->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('foto_profil')) {
            // Hapus gambar lama jika ada
            if ($operator->foto_profil && file_exists(public_path('foto_profil/' . $operator->foto_profil))) {
                unlink(public_path('foto_profil/' . $operator->foto_profil));
            }

            // Upload gambar baru
            $imageName = time() . '.' . $request->file('foto_profil')->extension();
            $request->file('foto_profil')->move(public_path('foto_profil'), $imageName);
            $operator->foto_profil = $imageName;
        }

        $operator->save();

        return redirect()->route('admin.operator')->with('success', 'Operator berhasil diperbarui');
    }
}
