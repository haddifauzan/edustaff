<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\User;

class BantuanController extends Controller
{
    public function index_pegawai()
    {
        return view('pegawai.bantuan.index');
    }

    public function index_operator()
    {
        return view('operator.bantuan.index');
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string',
            'kategori' => 'required|string|max:255',
        ]);

        // Format pesan untuk dikirim
        $appName = config('app.name');
        $role = auth()->user()->role;
        $waMessage = urlencode("Bantuan Baru dari {$appName} ({$role})
        Nama: " . auth()->user()->nama_user . "
        Judul: " . $request->judul . "
        Pesan: " . $request->pesan . "
        Kategori: " . $request->kategori . "
        ");

        // URL WhatsApp
        $phoneNumber = '6281313264584'; // Ganti dengan nomor Anda
        $url = "https://wa.me/{$phoneNumber}?text={$waMessage}";

        // Simpan notifikasi ke admin
        $notification = new Notifikasi();
        $notification->judul = "Bantuan Baru dari {$appName} ({$role})";
        $notification->pesan = $request->pesan;
        $notification->data = "https://wa.me/{$phoneNumber}";
        $notification->id_user = User::where('role', 'Admin')->first()->id_user;
        $notification->id_sender = auth()->id();
        $notification->save();


        // Redirect ke URL WhatsApp
        return redirect()->away($url);
    }

}
