<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pegawai;
use App\Models\RiwayatJabatan;
use Carbon\Carbon;

class UpdateStatusJabatan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jabatan:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status jabatan pegawai';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $riwayatJabatans = RiwayatJabatan::whereNotNull('tgl_selesai')
                                         ->whereDate('tgl_selesai', '<=', Carbon::today())
                                         ->get();

        foreach ($riwayatJabatans as $riwayat) {
            $pegawai = $riwayat->pegawai;
            $pegawai->id_jabatan = null; 
            $pegawai->save();

            $this->info("Jabatan pegawai dengan ID {$pegawai->id_pegawai} telah dihapus.");
        }
    }
}