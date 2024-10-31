<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestasi;
use App\Models\User;
use App\Models\Notifikasi;

class PrestasiController extends Controller
{
    public function index()
    {
        // Ambil semua prestasi yang terkait dengan pegawai yang sedang login
        $prestasi = Prestasi::where('id_pegawai', Auth::user()->id_pegawai)->get();

        // Tampilkan view prestasi dengan data prestasi
        return view('pegawai.prestasi.index', compact('prestasi'));
    }


    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'deskripsi_prestasi' => 'required|string',
            'tgl_dicapai' => 'required|date',
            'foto_sertifikat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto sertifikat jika ada
        $fotoSertifikat = null;
        if ($request->hasFile('foto_sertifikat')) {
            $imageName = "prestasi_" . time() . '.' . $request->file('foto_sertifikat')->extension();
            $request->file('foto_sertifikat')->move(public_path('prestasi'), $imageName);
            $fotoSertifikat = $imageName;
        }

        // Simpan prestasi baru ke database
        Prestasi::create([
            'nama_prestasi' => $request->nama_prestasi,
            'deskripsi_prestasi' => $request->deskripsi_prestasi,
            'tgl_dicapai' => $request->tgl_dicapai,
            'foto_sertifikat' => $fotoSertifikat,
            'status' => "menunggu",
            'id_pegawai' => Auth::user()->id_pegawai, 
        ]);

        // Kirim notifikasi ke user dengan role Operator
        $operators = User::where('role', 'Operator')->get();
        foreach ($operators as $operator) {
            $notifikasiOperator = new Notifikasi();
            $notifikasiOperator->pesan = 'Ada pengajuan prestasi pegawai baru. Silahkan cek dan konfirmasi perubahan!';
            $notifikasiOperator->judul = 'Konfirmasi Prestasi Pegawai';
            $notifikasiOperator->data = route('operator.prestasi');
            $notifikasiOperator->id_user = $operator->id_user;
            $notifikasiOperator->id_sender = auth()->user()->id_user;
            $notifikasiOperator->save();
        }

        return redirect()->route('pegawai.prestasi')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'deskripsi_prestasi' => 'required|string',
            'tgl_dicapai' => 'required|date',
            'foto_sertifikat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data prestasi
        $prestasi = Prestasi::findOrFail($id);

        // Pastikan pegawai hanya bisa mengedit prestasinya sendiri
        if ($prestasi->id_pegawai !== Auth::user()->id_pegawai) {
            return redirect()->route('pegawai.prestasi')->with('error', 'Anda tidak memiliki akses untuk mengedit prestasi ini.');
        }

        // Upload foto sertifikat jika ada dan hapus yang lama
        if ($request->hasFile('foto_sertifikat')) {
            // Hapus gambar lama jika ada
            if ($prestasi->foto_sertifikat && file_exists(public_path('prestasi/' . $prestasi->foto_sertifikat))) {
                unlink(public_path('prestasi/' . $prestasi->foto_sertifikat));
            }

            // Upload gambar baru
            $imageName = "prestasi_" . time() . '.' . $request->file('foto_sertifikat')->extension();
            $request->file('foto_sertifikat')->move(public_path('prestasi'), $imageName);
            $prestasi->foto_sertifikat = $imageName;
        }

        // Update data prestasi
        $prestasi->update([
            'nama_prestasi' => $request->nama_prestasi,
            'deskripsi_prestasi' => $request->deskripsi_prestasi,
            'tgl_dicapai' => $request->tgl_dicapai,
        ]);

        return redirect()->route('pegawai.prestasi')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Ambil data prestasi
        $prestasi = Prestasi::findOrFail($id);

        // Pastikan pegawai hanya bisa menghapus prestasinya sendiri
        if ($prestasi->id_pegawai !== Auth::user()->id_pegawai) {
            return redirect()->route('pegawai.prestasi')->with('error', 'Anda tidak memiliki akses untuk menghapus prestasi ini.');
        }

        // Hapus foto sertifikat jika ada
        if ($prestasi->foto_sertifikat && file_exists(public_path('prestasi/' . $prestasi->foto_sertifikat))) {
            unlink(public_path('prestasi/' . $prestasi->foto_sertifikat));
        }

        // Kirim notifikasi ke user dengan role Operator
        $operators = User::where('role', 'Operator')->get();
        foreach ($operators as $operator) {
            $notifikasiOperator = Notifikasi::where('id_user', $operator->id_user)
                ->where('id_sender', auth()->user()->id_user)
                ->where('judul', 'Konfirmasi Prestasi Pegawai')
                ->first();
            if ($notifikasiOperator) {
                $notifikasiOperator->delete();
            }
        }

        // Hapus data prestasi secara permanen
        $prestasi->forceDelete();

        return redirect()->route('pegawai.prestasi')->with('success', 'Prestasi berhasil dihapus.');
    }

    public function daftarPrestasi(Request $request)
    {
        // Cari data pengajuan berdasarkan nama pegawai
        $search = $request->input('search');
        $pengajuanPrestasi = Prestasi::with('pegawai') // 'user' adalah relasi ke model User atau Pegawai
            ->whereHas('pegawai', function ($query) use ($search) {
                $query->where('nama_pegawai', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc') // Mengurutkan dari yang terbaru
            ->get();

        // Return view dengan data pengajuan
        return view('operator.prestasi.index', compact('pengajuanPrestasi', 'search'));
    }

    public function setujuiPrestasi(Request $request, $id)
    {
        // Temukan prestasi berdasarkan ID
        $prestasi = Prestasi::findOrFail($id);

        // Update status prestasi menjadi disetujui
        $prestasi->status = 'diterima';
        $prestasi->save();

        // Kirim notifikasi ke user
        $notifikasiPegawai = new Notifikasi();
        $notifikasiPegawai->pesan = 'Prestasi berhasil disetujui. Silahkan cek detail prestasi anda.';
        $notifikasiPegawai->judul = 'Konfirmasi Prestasi Pegawai';
        $notifikasiPegawai->data = route('pegawai.prestasi');
        $notifikasiPegawai->id_user = $prestasi->pegawai->user->id_user;
        $notifikasiPegawai->id_sender = auth()->user()->id_user;
        $notifikasiPegawai->save();

        // Berikan respon sukses
        return redirect()->route('operator.prestasi')->with('success', 'Prestasi berhasil disetujui.');
    }


    public function tolakPrestasi(Request $request, $id)
    {
        // Temukan prestasi berdasarkan ID
        $prestasi = Prestasi::findOrFail($id);

        // Update status prestasi menjadi ditolak
        $prestasi->status = 'ditolak';
        $prestasi->save();

        // Kirim notifikasi ke user
        $notifikasiPegawai = new Notifikasi();
        $notifikasiPegawai->pesan = 'Prestasi ditolak. Silahkan cek detail prestasi anda.';
        $notifikasiPegawai->judul = 'Konfirmasi Prestasi Pegawai';
        $notifikasiPegawai->data = route('pegawai.prestasi');
        $notifikasiPegawai->id_user = $prestasi->pegawai->user->id_user;
        $notifikasiPegawai->id_sender = auth()->user()->id_user;
        $notifikasiPegawai->save();

        // Berikan respon sukses
        return redirect()->route('operator.prestasi')->with('success', 'Prestasi berhasil ditolak.');
    }

    public function hapusPrestasi($id)
    {
        // Ambil data prestasi
        $prestasi = Prestasi::findOrFail($id);

        // Hapus foto sertifikat jika ada
        if ($prestasi->foto_sertifikat && file_exists(public_path('prestasi/' . $prestasi->foto_sertifikat))) {
            unlink(public_path('prestasi/' . $prestasi->foto_sertifikat));
        }

        // Simpan di sampah
        $prestasi->delete();

        return redirect()->route('operator.prestasi')->with('success', 'Prestasi berhasil dihapus.');
    }
}
