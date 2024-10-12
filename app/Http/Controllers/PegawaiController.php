<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Notifikasi;


class PegawaiController extends Controller
{
    public function index_operator(Request $request)
    {
        $search = $request->input('search');

        $pegawais = Pegawai::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_pegawai', 'like', "%{$search}%");
            })
            ->get();

        return view('operator.pegawai.pegawai', compact('pegawais'));
    }

    public function index_admin(Request $request)
    {
        $search = $request->input('search');
        $status_akun = $request->input('status_akun');

        $pegawais = User::where('role', '!=', 'Admin')
            ->where('role', '!=', 'Operator')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('nama_user', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status_akun, function ($query, $status_akun) {
                return $query->where('status_akun', $status_akun);
            })
            ->get();

        return view('admin.pegawai.pegawai', compact('pegawais'));
    }

    public function create()
    {
        return view('operator.pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|max:16|unique:tbl_pegawai,nik',
            'nama_pegawai' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'agama' => 'required|max:50',
            'status_pernikahan' => 'required|in:Menikah,Belum Menikah,Cerai',
            'no_tlp' => 'required|max:15',
            'email' => 'required|email|unique:tbl_pegawai,email',
            'pendidikan_terakhir' => 'required|max:50',
            'tahun_lulus' => 'required|integer',
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_kepegawaian' => 'required|in:ASN,Non-ASN,Honorer',
            'nip' => 'nullable|required_if:status_kepegawaian,ASN|max:18|unique:tbl_pegawai,nip', // NIP hanya wajib jika status kepegawaian adalah ASN
            'no_sk_pengangkatan' => 'max:50',
            'tanggal_pengangkatan' => 'date',
            'pangkat' => 'max:50',
            'golongan' => 'max:50',
            'gelar_depan' => 'nullable|max:50',
            'gelar_belakang' => 'nullable|max:50',
            'foto_ijazah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_akte_kelahiran' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $nik = $request->nik;

        $folderPath = 'uploads/data_gambar_pegawai/' . $nik; // Folder untuk foto profil

        $pegawai = new Pegawai();
        $pegawai->fill($request->all());
        $pegawai->is_guru = false;

        $fotoProfilFolder = 'foto_profil';

        if ($request->hasFile('foto_pegawai')) {
            $fileName = 'foto_pegawai_' . time() . '.' . $request->file('foto_pegawai')->getClientOriginalExtension();
            $request->file('foto_pegawai')->move(public_path($fotoProfilFolder), $fileName);
            $pegawai->foto_pegawai = $fotoProfilFolder . '/' . $fileName;   
        }

        $fotoData = [];
        $uploadFields = ['foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran'];
        foreach ($uploadFields as $field) {
            if ($request->hasFile($field)) {
                $fileName = $field . '_' . time() . '.' . $request->file($field)->extension(); // Nama file unik
                $request->file($field)->move(public_path($folderPath), $fileName); // Pindahkan file
                $fotoData[$field] = $folderPath . '/' . $fileName; // Simpan path file ke array $fotoData
            } else {
                $fotoData[$field] = null; // Jika tidak ada file, set ke null
            }
        }

        $pegawai->fill($request->all());
        $pegawai->foto_pegawai = $fotoPegawaiFileName ?? $pegawai->foto_pegawai;
        $pegawai->fill($fotoData);
        $pegawai->save();
        $user = User::create([
            'nama_user' => $request->nama_pegawai,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => 'Pegawai',
            'status_aktif' => 'Aktif',
            'no_hp' => $request->no_tlp,
            'foto_profil' => $pegawai->foto_pegawai, 
            'id_pegawai' => $pegawai->id_pegawai, 
        ]);


        Notifikasi::create([
            'judul' => 'Selamat Datang!',
            'pesan' => 'Akun Pegawai anda sudah berhasil dibuat, silahkan untuk mengecek data diri anda dan jika ada kesalahan bisa diperbaiki dan kami akan konfirmasi! Terima Kasih.',
            'id_user' => $user->id_user, // ID pengguna yang baru dibuat
            'tanggal_kirim' => now(),
            'dibaca' => false,
            'link' => 'pegawai.notifikasi',
            'semua_pegawai' => false, 
        ]);

        return redirect()->route('operator.pegawai')->with('success', 'Data pegawai dan pengguna berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        User::where('id_pegawai', $pegawai->id_pegawai)->delete();

        if ($pegawai->foto_pegawai) {
            $fotoProfilPath = public_path($pegawai->foto_pegawai);
            if (File::exists($fotoProfilPath)) {
                File::delete($fotoProfilPath);
            }
        }

        $nikFolderPath = public_path('uploads/data_gambar_pegawai/' . $pegawai->nik);

        $uploadFields = ['foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran'];
        foreach ($uploadFields as $field) {
            if ($pegawai->$field) {
                $filePath = public_path($pegawai->$field); // Path dari file tersebut
                if (File::exists($filePath)) {
                    File::delete($filePath); // Hapus file
                }
            }
        }

        if (File::exists($nikFolderPath) && File::isDirectory($nikFolderPath)) {
            File::deleteDirectory($nikFolderPath);
        }

        $pegawai->delete();

        Notifikasi::where('id_user', function($query) use ($pegawai) {
            $query->select('id_user')->from('tbl_user')->where('id_pegawai', $pegawai->id_pegawai);
        })->delete();

        Pegawai::where('id_pegawai', $pegawai->id_pegawai)->delete();

        return redirect()->route('operator.pegawai')->with('success', 'Pegawai berhasil dihapus.');
    }

    
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('operator.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id_pegawai)
    {
        $request->validate([
            'nik' => 'required|max:16|unique:tbl_pegawai,nik,' . $id_pegawai . ',id_pegawai',
            'nama_pegawai' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'agama' => 'required|max:50',
            'status_pernikahan' => 'required|in:Menikah,Belum Menikah,Cerai',
            'no_tlp' => 'required|max:15',
            'email' => 'required|email|unique:tbl_pegawai,email,' . $id_pegawai . ',id_pegawai',
            'pendidikan_terakhir' => 'required|max:50',
            'tahun_lulus' => 'required|integer',
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_kepegawaian' => 'required|in:ASN,Non-ASN,Honorer',
            'nip' => 'nullable|required_if:status_kepegawaian,ASN|max:18|unique:tbl_pegawai,nip,' . $id_pegawai . ',id_pegawai',
            'no_sk_pengangkatan' => 'max:50',
            'tanggal_pengangkatan' => 'date',
            'pangkat' => 'max:50',
            'golongan' => 'max:50',
            'gelar_depan' => 'nullable|max:50',
            'gelar_belakang' => 'nullable|max:50',
            'foto_ijazah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_akte_kelahiran' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pegawai = Pegawai::findOrFail($id_pegawai);

        $nik = $request->nik;

        $folderPath = 'uploads/data_gambar_pegawai/' . $nik;
        $fotoProfilFolder = 'foto_profil'; // Folder untuk foto profil

        if ($request->hasFile('foto_pegawai')) {
            $filePath = public_path($fotoProfilFolder . '/' . $pegawai->foto_pegawai);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $fileName = 'foto_pegawai_' . time() . '.' . $request->file('foto_pegawai')->extension();
            $request->file('foto_pegawai')->move(public_path($fotoProfilFolder), $fileName);
            $pegawai->foto_pegawai = $fotoProfilFolder . '/' . $fileName;        
        }

        $fotoData = [];
        $uploadFields = ['foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran'];
        foreach ($uploadFields as $field) {
            if ($request->hasFile($field)) {
                if ($pegawai->$field) {
                    File::delete(public_path($pegawai->$field));
                }

                // Upload file baru
                $fileName = $field . '_' . time() . '.' . $request->file($field)->extension();
                $request->file($field)->move(public_path($folderPath), $fileName);
                $fotoData[$field] = $folderPath . '/' . $fileName; // Simpan path file ke array $fotoData
            }
        }

        $fotoPegawaiFileName = $fileName ?? $pegawai->foto_pegawai;
        $pegawai->fill(array_merge($request->all(), $fotoData, ['foto_pegawai' => $fotoPegawaiFileName]));

        $pegawai->save();

        $user = User::where('id_pegawai', $id_pegawai)->first();
        if ($user) {
            $user->nama_user = $request->nama_pegawai;
            $user->email = $request->email;
            $user->no_hp = $request->no_tlp;
            $user->foto_profil = $pegawai->foto_pegawai;
            $user->save();
        }

        return redirect()->route('operator.pegawai')->with('success', 'Data pegawai dan pengguna berhasil diperbarui.');
    }

    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if (auth()->user()->role === 'Operator') {
            return view('operator.pegawai.show', compact('pegawai'));
        } elseif (auth()->user()->role === 'Admin') {
            return view('admin.pegawai.show', compact('pegawai'));
        }
    }

    public function toggleStatus($id)
    {
        $pegawai = Pegawai::where('id_pegawai', $id)->first();
        $user = User::where('id_pegawai', $id)->first();

        $pegawai->status_pegawai = $pegawai->status_pegawai === 'Aktif' ? 'Non-Aktif' : 'Aktif';
        $user->status_akun = $user->status_akun === 'Aktif' ? 'Non-Aktif' : 'Aktif';

        $pegawai->save();
        $user->save();

        return response()->json([
            'status' => 'success',
            'status_pegawai' => $pegawai->status_pegawai,
            'status_akun' => $user->status_akun
        ]);
    }


}
