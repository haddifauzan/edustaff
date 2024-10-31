<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PensiunKeluar;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;

class NonaktifkanPegawaiCommand extends Command
{
    protected $signature = 'pegawai:nonaktifkan';

    protected $description = 'Menonaktifkan status pegawai dan akun user yang telah mencapai tanggal berlaku pengajuan pensiun/keluar';

    public function handle()
    {
        $today = Carbon::today();

        // Ambil pengajuan yang tanggal berlakunya sudah tercapai dan belum diproses
        $pengajuans = PensiunKeluar::where('tgl_berlaku', '<=', $today)
            ->where('status_pengajuan', 'disetujui')
            ->get();

        foreach ($pengajuans as $pengajuan) {
            // Update status_pegawai di tbl_pegawai
            $pegawai = Pegawai::find($pengajuan->id_pegawai);
            if ($pegawai) {
                $pegawai->update(['status_pegawai' => 'Non-Aktif']);
                $this->info("Status pegawai {$pegawai->nama_pegawai} dinonaktifkan.");
            }

            // Update status_akun di tbl_user
            $user = User::where('id_pegawai', $pengajuan->id_pegawai)->first();
            if ($user) {
                $user->update(['status_akun' => 'Non-Aktif']);
                $this->info("Status akun user {$user->email} dinonaktifkan.");
            }
        }

        $this->info('Command selesai dijalankan.');
    }
}
