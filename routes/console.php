<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\UpdateStatusJabatan;
use App\Console\Commands\DeleteExpiredData;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('jabatan:update-status', function () {
    $this->call(UpdateStatusJabatan::class);
})->purpose('Update status jabatan berdasarkan waktu jabatan');

Artisan::command('data:delete-expired', function () {
    $this->call(DeleteExpiredData::class);
})->purpose('Hapus data yang sudah kadaluarsa');
