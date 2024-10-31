<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{    
    public function index_admin(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $status_akun = $request->input('status_akun');
        $sortBy = $request->input('sort_by', 'created_at'); // Default sorting by created_at
        $sortOrder = $request->input('sort_order') ?: 'asc'; // Jika sort_order kosong maka default 'asc'

        $users = User::where('role', '!=', 'Admin')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('nama_user', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->when($status_akun, function ($query, $status_akun) {
                return $query->where('status_akun', $status_akun);
            })
            ->when($sortBy, function ($query, $sortBy) use ($sortOrder) {
                return $query->orderBy($sortBy, $sortOrder);
            })
            ->get();

        return view('admin.user.user', compact('users'));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $hasChanges = false;

        // Validasi data
        $validatedData = $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            'current_password' => 'nullable|required_with:new_password|string|min:6', // Validasi password saat ini
            'new_password' => 'nullable|string|min:6|confirmed', // Validasi password baru
        ]);

        if (
            $user->nama_user !== $request->input('nama_user') ||
            $user->email !== $request->input('email') ||
            $user->no_hp !== $request->input('no_hp')
        ) {
            $hasChanges = true;
        }

        if ($request->hasFile('foto_profil')) {
            $hasChanges = true;
        }

        if ($request->filled('new_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah!'])->withInput();
            }
            $hasChanges = true;
        }

        if (!$hasChanges) {
            return back();
        }

        $user->nama_user = $request->input('nama_user');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');

        if ($request->hasFile('foto_profil')) {
            // Hapus gambar lama jika ada
            $imagePath = public_path('foto_profil/' . $user->foto_profil);
            if (File::exists($imagePath)) {
                try {
                    File::delete($imagePath);
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                }
            }

            try {
                $imageName = time() . '.' . $request->file('foto_profil')->extension();
                $request->file('foto_profil')->move(public_path('foto_profil'), $imageName);
                $user->foto_profil = $imageName; // Update dengan nama gambar baru

                // Jika user pegawai, maka ubah juga foto_pegawai di Pegawai
                if ($user->role === 'Pegawai') {
                    $pegawai = $user->pegawai;
                    $fileName = 'foto_pegawai_' . time() . '.' . $request->file('foto_pegawai')->getClientOriginalExtension();
                    $request->file('foto_pegawai')->move(public_path('foto_profil'), $fileName);
                    $pegawai->foto_pegawai = $fileName;
                    $pegawai->save();
                }
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        // Jika user pegawai, maka ubah juga nama, email, no_hp di Pegawai
        if ($user->role === 'Pegawai') {
            $pegawai = $user->pegawai;
            $pegawai->nama_pegawai = $request->input('nama_user');
            $pegawai->email = $request->input('email');
            $pegawai->no_tlp = $request->input('no_hp');
            $pegawai->save();
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $user->status_akun = $user->status_akun === 'Aktif' ? 'Non-Aktif' : 'Aktif';

        $user->save();

        return response()->json([
            'status' => 'success',
            'status_akun' => $user->status_akun
        ]);
    }

}
