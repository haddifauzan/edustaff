<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PensiunKeluar;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\NotifikasiController;


class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = PensiunKeluar::where('id_pegawai', Auth::user()->id_pegawai)->get();
        return view('pegawai.pengajuan.index', compact('pengajuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pengajuan' => 'required',
            'alasan' => 'required',
            'tanggal_berlaku' => 'required|date',
        ]);

        PensiunKeluar::create([
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'alasan' => $request->alasan,
            'tgl_berlaku' => $request->tanggal_berlaku,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'id_pegawai' => auth()->user()->pegawai->id_pegawai,
            'pengaju' => 'Pegawai',
            'status_pengajuan' => 'menunggu',
            'tgl_pengajuan' => now(),
        ]);

        // Kirim notifikasi ke user dengan role Operator
        $operators = User::where('role', 'Operator')->get();
        foreach ($operators as $operator) {
            $notifikasiOperator = new Notifikasi();
            $notifikasiOperator->pesan = 'Ada pengajuan ' . $request->jenis_pengajuan . ' pegawai baru. Silahkan cek dan konfirmasi pengajuan!';
            $notifikasiOperator->judul = 'Konfirmasi Pengajuan ' . $request->jenis_pengajuan;
            $notifikasiOperator->data = route('operator.pengajuan');
            $notifikasiOperator->id_user = $operator->id_user;
            $notifikasiOperator->id_sender = auth()->user()->id_user;
            $notifikasiOperator->save();
        }


        return redirect()->route('pegawai.pengajuan')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pengajuan = PensiunKeluar::findOrFail($id);
        $request->validate([
            'jenis_pengajuan' => 'required',
            'alasan' => 'required',
            'tanggal_berlaku' => 'required|date',
        ]);

        $pengajuan->update([
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'alasan' => $request->alasan,
            'tanggal_berlaku' => $request->tgl_berlaku,
            'keterangan_tambahan' => $request->keterangan_tambahan,
        ]);

        return redirect()->route('pegawai.pengajuan')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = PensiunKeluar::findOrFail($id);
        if ($pengajuan->status_pengajuan !== 'menunggu') {
            return redirect()->route('pegawai.pengajuan')->with('error', 'Pengajuan tidak dapat dibatalkan karena sudah disetujui atau ditolak.');
        }

        // Kirim notifikasi ke user dengan role Operator
        $operators = User::where('role', 'Operator')->get();
        foreach ($operators as $operator) {
            $notifikasiOperator = Notifikasi::where('id_user', $operator->id_user)
                ->where('id_sender', auth()->user()->id_user)
                ->where('data', route('operator.pengajuan'))
                ->first();
            if ($notifikasiOperator) {
                $notifikasiOperator->delete();
            }
        }

        $pengajuan->delete();
        return redirect()->route('pegawai.pengajuan')->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function daftarPengajuan(Request $request)
    {
        $search = $request->input('search');
        $pengajuans = PensiunKeluar::with('pegawai') // 'user' adalah relasi ke model User atau Pegawai
            ->whereHas('pegawai', function ($query) use ($search) {
                $query->where('nama_pegawai', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc') // Mengurutkan dari yang terbaru
            ->get();

        $pegawais = PensiunKeluar::with('pegawai')->get();

        // Return view dengan data pengajuan
        return view('operator.pengajuan.index', compact('pengajuans', 'pegawais', 'search'));
    }

    // Method untuk menambah pengajuan baru
    public function storeOperator(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:tbl_pegawai,id_pegawai',
            'jenis_pengajuan' => 'required|string',
            'alasan' => 'required|string',
            'tanggal_berlaku' => 'required|date',
        ]);

        PensiunKeluar::create([
            'id_pegawai' => $request->id_pegawai,
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'alasan' => $request->alasan,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'id_operator' => auth()->user()->id_user,
            'tgl_berlaku' => $request->tanggal_berlaku,
            'status_pengajuan' => 'disetujui',
            'pengaju' => 'Operator',
        ]);

        // Kirim notifikasi ke user sesuai id_pegawai yang diajukan
        $pegawai = User::findOrFail($request->id_pegawai);
        $notifikasiUser = new Notifikasi();
        $notifikasiUser->pesan = 'Pengajuan ' . $request->jenis_pengajuan . ' Anda telah diproses.';
        $notifikasiUser->judul = 'Pengajuan ' . $request->jenis_pengajuan;
        $notifikasiUser->data = route('pegawai.pengajuan');
        $notifikasiUser->id_user = $pegawai->id_user;
        $notifikasiUser->id_sender = auth()->user()->id_user;
        $notifikasiUser->save();
        
        $notifikasiController = new NotifikasiController();
        $notifikasiController->sendFCMNotification($notifikasiUser->id_user, $notifikasiUser->judul, $notifikasiUser->pesan);

        return redirect()->route('operator.pengajuan')->with('success', 'Pengajuan berhasil ditambahkan');
    }

    // Method untuk menyetujui pengajuan
    public function approve($id)
    {
        $pengajuan = PensiunKeluar::findOrFail($id);
        $pengajuan->update([
            'status_pengajuan' => 'disetujui',
            'id_operator' => auth()->user()->id_user,
        ]);

        // Kirim notifikasi ke user sesuai id_pegawai yang diajukan
        $notifikasiUser = new Notifikasi();
        $notifikasiUser->pesan = 'Pengajuan ' . $pengajuan->jenis_pengajuan . ' Anda telah disetujui.';
        $notifikasiUser->judul = 'Pengajuan ' . $pengajuan->jenis_pengajuan;
        $notifikasiUser->data = route('pegawai.pengajuan');
        $notifikasiUser->id_user = $pengajuan->pegawai->user->id_user;
        $notifikasiUser->id_sender = auth()->user()->id_user;
        $notifikasiUser->save();

        $notifikasiController = new NotifikasiController();
        $notifikasiController->sendFCMNotification($notifikasiUser->id_user, $notifikasiUser->judul, $notifikasiUser->pesan);

        return redirect()->route('operator.pengajuan')->with('success', 'Pengajuan berhasil disetujui');
    }

    // Method untuk menolak pengajuan
    public function reject($id)
    {
        $pengajuan = PensiunKeluar::findOrFail($id);
        $pengajuan->update([
            'status_pengajuan' => 'ditolak',
            'id_operator' => auth()->user()->id_user,
        ]);

        // Kirim notifikasi ke user sesuai id_pegawai yang diajukan
        $pegawai = User::findOrFail($pengajuan->id_pegawai);
        $notifikasiUser = new Notifikasi();
        $notifikasiUser->pesan = 'Pengajuan ' . $pengajuan->jenis_pengajuan . ' Anda telah ditolak.';
        $notifikasiUser->judul = 'Pengajuan ' . $pengajuan->jenis_pengajuan;
        $notifikasiUser->data = route('pegawai.pengajuan');
        $notifikasiUser->id_user = $pengajuan->pegawai->user->id_user;
        $notifikasiUser->id_sender = auth()->user()->id_user;
        $notifikasiUser->save();

        $notifikasiController = new NotifikasiController();
        $notifikasiController->sendFCMNotification($notifikasiUser->id_user, $notifikasiUser->judul, $notifikasiUser->pesan);

        return redirect()->route('operator.pengajuan')->with('error', 'Pengajuan telah ditolak');
    }
}
