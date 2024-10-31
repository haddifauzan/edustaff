<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteExpiredData extends Command
{
    // Nama dan deskripsi command
    protected $signature = 'data:delete-expired';
    protected $description = 'Menghapus data yang expired berdasarkan expired_at';

    /**
     * Eksekusi command.
     *
     * @return int
     */
    public function handle()
    {
        // Model yang ingin diperiksa
        $models = ['App\Models\Kelas', 'App\Models\Jurusan', 'App\Models\Jabatan', 'App\Models\Mapel', 'App\Models\Pegawai', 'App\Models\Prestasi'];

        foreach ($models as $model) {
            $expiredData = $model::where('expired_at', '<=', now())->get();
            
            // Hapus data yang expired
            foreach ($expiredData as $data) {
                $data->forceDelete(); // Hapus secara permanen dari database
                $primaryKey = $data->getKeyName();
                $this->info("Deleted: {$model} with ID {$data->{$primaryKey}}");
            }
        }

        return 0;
    }
}
