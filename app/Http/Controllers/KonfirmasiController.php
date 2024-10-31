<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konfirmasi;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Notifikasi;

class KonfirmasiController extends Controller
{
    public function editDataDiri()
    {
        // Ambil data pegawai yang sedang login
        $pegawai = auth()->user()->pegawai;
        $riwayatPengajuan = Konfirmasi::where('id_pegawai', $pegawai->id_pegawai)->orderByDesc('waktu_pengajuan')->get();

        return view('pegawai.perubahan.index', compact('pegawai', 'riwayatPengajuan'));
    }


    public function updateDataDiri(Request $request)
    {
        // Ambil data pegawai yang sedang login
        $pegawai = auth()->user()->pegawai;
        $id_pegawai = $pegawai->id_pegawai;

        // Validasi data
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
            'foto_ijazah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_akte_kelahiran' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status_kepegawaian' => 'required|in:ASN,Non-ASN,Honorer',
            'nip' => 'nullable|required_if:status_kepegawaian,ASN|max:18|unique:tbl_pegawai,nip,' . $id_pegawai . ',id_pegawai',
            'no_sk_pengangkatan' => 'max:50',
            'tanggal_pengangkatan' => 'date',
            'pangkat' => 'max:50',
            'golongan' => 'max:50',
            'gelar_depan' => 'nullable|max:50',
            'gelar_belakang' => 'nullable|max:50',
        ]);

        // Data perubahan yang diajukan
        $changes = [];
        $fields = [
            'nik',
            'nama_pegawai',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'agama',
            'status_pernikahan',
            'no_tlp',
            'email',
            'pendidikan_terakhir',
            'tahun_lulus',
            'status_kepegawaian',
            'nip',
            'no_sk_pengangkatan',
            'tanggal_pengangkatan',
            'pangkat',
            'golongan',
            'gelar_depan',
            'gelar_belakang',
        ];

        // Folder untuk upload gambar
        $nik = $request->nik;
        $folderPath = 'uploads/data_gambar_pegawai/' . $nik;
        $fotoProfilFolder = 'foto_profil';

        // Prepare the data to be changed
        $dataToChange = $request->except(['_token', 'foto_pegawai', 'foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran']);

        // Handle file uploads and check for changes in files
        $uploadFields = ['foto_pegawai', 'foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran'];
        foreach ($uploadFields as $field) {
            if ($request->hasFile($field)) {
                $fileName = $field . '_' . time() . '.' . $request->file($field)->getClientOriginalExtension();
                $folder = ($field === 'foto_pegawai') ? $fotoProfilFolder : $folderPath;
                $request->file($field)->move(public_path($folder), $fileName);
                $dataToChange[$field] = $folder . '/' . $fileName;

                // Cek apakah file baru berbeda dengan file lama
                if ($pegawai->$field != $dataToChange[$field]) {
                    $changes[$field] = [
                        'old' => $pegawai->$field,
                        'new' => $dataToChange[$field]
                    ];
                }
            }
        }

        // Cek perbedaan data dengan data lama
        foreach ($fields as $field) {
            if ($request->$field != $pegawai->$field) {
                $changes[$field] = [
                    'old' => $pegawai->$field,
                    'new' => $request->$field
                ];
            }
        }

        // Cek jika tidak ada perubahan data
        if (empty($changes)) {
            return redirect()->back()->with('info', 'Tidak ada perubahan data.');
        }

        // Simpan perubahan ke tabel Konfirmasi
        $konfirmasi = new Konfirmasi();
        $konfirmasi->kolom_diubah = json_encode($changes); // Simpan perubahan yang terjadi
        $konfirmasi->status_konfirmasi = 'menunggu';
        $konfirmasi->waktu_pengajuan = now();
        $konfirmasi->id_pegawai = $id_pegawai;
        $konfirmasi->save();

        // Kirim notifikasi ke user dengan role Operator
        $operators = User::where('role', 'Operator')->get();
        foreach ($operators as $operator) {
            $notifikasiOperator = new Notifikasi();
            $notifikasiOperator->pesan = 'Ada pengajuan perubahan data pegawai baru. Silahkan cek dan konfirmasi perubahan!';
            $notifikasiOperator->judul = 'Konfirmasi Perubahan Data Pegawai';
            $notifikasiOperator->data = route('operator.perubahan');
            $notifikasiOperator->id_user = $operator->id_user;
            $notifikasiOperator->id_sender = auth()->user()->id_user;
            $notifikasiOperator->save();
        }

        return redirect()->back()->with('success', 'Perubahan data berhasil diajukan untuk konfirmasi.');
    }

    public function batalkanPengajuan($id)
    {
        $pengajuan = Konfirmasi::find($id);

        if ($pengajuan->status_konfirmasi == 'menunggu') {
            // Jika dibatalkan maka hapus file jika perubahan ada file
            $changes = json_decode($pengajuan->kolom_diubah, true);
            $uploadFields = ['foto_pegawai', 'foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran'];
            foreach ($uploadFields as $field) {
                if (isset($changes[$field])) {
                    $filePath = public_path($changes[$field]['new']);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            // Kirim notifikasi ke user dengan role Operator
            $operators = User::where('role', 'Operator')->get();
            foreach ($operators as $operator) {
                $notifikasiOperator = Notifikasi::where('id_user', $operator->id_user)
                    ->where('id_sender', auth()->user()->id_user)
                    ->where('judul', 'Konfirmasi Perubahan Data Pegawai')
                    ->first();
                if ($notifikasiOperator) {
                    $notifikasiOperator->delete();
                }
            }

            $pengajuan->delete();
            return redirect()->back()->with('success', 'Pengajuan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pengajuan tidak dapat dibatalkan.');
    }


    public function daftarPengajuan(Request $request)
    {
        // Cari data pengajuan berdasarkan nama pegawai
        $search = $request->input('search');
        $riwayatPengajuan = Konfirmasi::with('pegawai') // 'user' adalah relasi ke model User atau Pegawai
            ->whereHas('pegawai', function ($query) use ($search) {
                $query->where('nama_pegawai', 'like', "%$search%");
            })
            ->orderBy('waktu_pengajuan', 'desc') // Mengurutkan dari yang terbaru
            ->get();

        // Return view dengan data pengajuan
        return view('operator.perubahan.index', compact('riwayatPengajuan', 'search'));
    }

    public function setujuiPengajuan(Request $request, $id)
    {
        // Validasi respon operator
        $request->validate([
            'pesan_operator' => 'required|string',
        ]);

        // Temukan pengajuan berdasarkan ID
        $pengajuan = Konfirmasi::findOrFail($id);

        // Ambil data pegawai terkait
        $pegawai = Pegawai::findOrFail($pengajuan->id_pegawai);

        // Ambil kolom yang diubah dari JSON
        $kolomDiubah = json_decode($pengajuan->kolom_diubah, true);

        // Iterasi setiap kolom yang diubah dan update data pegawai
        foreach ($kolomDiubah as $kolom => $value) {
            // Pastikan kolom yang akan diubah ada di model Pegawai
            if (in_array($kolom, ['nik',
                'nama_pegawai',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'agama',
                'status_pernikahan',
                'foto_pegawai',
                'nip',
                'no_sk_pengangkatan',
                'tgl_pengangkatan',
                'status_kepegawaian',
                'pangkat',
                'golongan',
                'no_tlp',
                'email',
                'pendidikan_terakhir',
                'tahun_lulus',
                'gelar_depan',
                'gelar_belakang',
                'status_pegawai',
                'foto_ijazah',
                'foto_ktp',
                'foto_kk',
                'foto_akte_kelahiran',
            ])) {
                // Update kolom dengan nilai baru
                $pegawai->$kolom = $value['new'];

                // Jika ada foto yang diubah, maka hapus foto sebelumnya
                if (in_array($kolom, ['foto_pegawai', 'foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran'])) {
                    $filePath = public_path($value['old']);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }
        }

        // Simpan perubahan ke dalam tabel pegawai
        $pegawai->save();

        // Update status pengajuan dan pesan operator
        $pengajuan->update([
            'status_konfirmasi' => 'disetujui',
            'pesan_operator' => $request->pesan_operator,
            'waktu_respon' => now(),
            'id_operator' => auth()->user()->id_user,
        ]);

        // Kirim notifikasi ke user
        $notifikasiPegawai = new Notifikasi();
        $notifikasiPegawai->pesan = 'Pengajuan perubahan data pegawai berhasil disetujui. Silahkan cek detail data pegawai anda.';
        $notifikasiPegawai->judul = 'Konfirmasi Perubahan Data Pegawai';
        $notifikasiPegawai->data = route('pegawai.perubahan');
        $notifikasiPegawai->id_user = $pegawai->user->id_user;
        $notifikasiPegawai->id_sender = auth()->user()->id_user;
        $notifikasiPegawai->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil disetujui dan data pegawai telah diperbarui.');
    }


    public function tolakPengajuan(Request $request, $id)
    {
        // Validasi respon operator
        $request->validate([
            'pesan_operator' => 'required|string',
        ]);

        // Temukan pengajuan berdasarkan ID
        $pengajuan = Konfirmasi::findOrFail($id);

        $pegawai = Pegawai::findOrFail($pengajuan->id_pegawai);

        // Jika dibatalkan maka hapus file jika perubahan ada file
        $changes = json_decode($pengajuan->kolom_diubah, true);
        $uploadFields = ['foto_pegawai', 'foto_ijazah', 'foto_ktp', 'foto_kk', 'foto_akte_kelahiran'];
        foreach ($uploadFields as $field) {
            if (isset($changes[$field])) {
                $filePath = public_path($changes[$field]['new']);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        }

        // Kirim notifikasi ke user
        $notifikasiPegawai = new Notifikasi();
        $notifikasiPegawai->pesan = 'Pengajuan perubahan data pegawai ditolak. Silahkan cek detail data pegawai anda.';
        $notifikasiPegawai->judul = 'Konfirmasi Perubahan Data Pegawai';
        $notifikasiPegawai->data = route('pegawai.perubahan');
        $notifikasiPegawai->id_user = $pegawai->user->id_user;
        $notifikasiPegawai->id_sender = auth()->user()->id_user;
        $notifikasiPegawai->save();

        // Update status pengajuan dan pesan operator
        $pengajuan->update([
            'status_konfirmasi' => 'ditolak',
            'pesan_operator' => $request->pesan_operator,
            'waktu_respon' => now(),
            'id_operator' => auth()->user()->id_user,
        ]);


        return redirect()->back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function detailPengajuan($id)
    {
        $pengajuan = Konfirmasi::with('pegawai') // Relasi ke user
            ->findOrFail($id); // Temukan pengajuan berdasarkan ID

        return view('operator.perubahan.detail', compact('pengajuan'));
    }


}
