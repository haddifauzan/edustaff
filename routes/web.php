<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\HomeOperatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DeletedDataController;
use App\Http\Controllers\TugasTambahanController;

use App\Http\Controllers\Laporan\LaporanPegawaiController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login-submit', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'create_forgot_password'])
    ->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'store_forgot_password'])
    ->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'create_reset_password'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'store_reset_password'])
    ->name('password.update');


Route::middleware(['auth:admin'])->group(function () {
    // ADMIN MENU
    Route::get('/admin-dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/update-profile-admin', [UserController::class, 'updateProfile'])->name('profile.update.admin');

    // USER MENU PEGAWAI
    Route::get('admin/user', [UserController::class, 'index_admin'])->name('admin.user');
    Route::get('admin/user/toggle/{id}', [UserController::class, 'toggleStatus'])->name('toggleStatus');
    Route::get('admin/pegawai', [PegawaiController::class, 'index_admin'])->name('admin.pegawai');
    Route::get('admin/pegawai/{id}/show', [PegawaiController::class, 'show'])->name('admin.pegawai.show');
    Route::get('admin/pegawai/toggle/{id}', [UserController::class, 'toggleStatus'])->name('toggleStatus');

    // OPERATOR MENU
    Route::get('admin/operator', [OperatorController::class, 'index_admin'])->name('admin.operator');
    Route::get('admin/operator/create', [OperatorController::class, 'create'])->name('admin.operator.create');
    Route::post('admin/operator/store', [OperatorController::class, 'store'])->name('admin.operator.store');
    Route::get('admin/operator/{id}/edit', [OperatorController::class, 'edit'])->name('admin.operator.edit');
    Route::put('admin/operator/update/{id}', [OperatorController::class, 'update'])->name('admin.operator.update');
    Route::delete('admin/operator/delete/{id}', [OperatorController::class, 'destroy'])->name('admin.operator.destroy');
    Route::get('/admin/operator/toggle/{id}', [OperatorController::class, 'toggleStatus'])->name('toggleStatus');

    // JABATAN MENU
    Route::get('admin/jabatan', [JabatanController::class, 'index_admin'])->name('admin.jabatan');
    Route::post('admin/jabatan/store', [JabatanController::class, 'store'])->name('admin.jabatan.store');
    Route::put('admin/jabatan/update/{id}', [JabatanController::class, 'update'])->name('admin.jabatan.update');
    Route::delete('admin/jabatan/delete/{id}', [JabatanController::class, 'destroy'])->name('admin.jabatan.destroy');

    // JURUSAN MENU
    Route::get('admin/jurusan', [JurusanController::class, 'index_admin'])->name('admin.jurusan');
    Route::post('admin/jurusan/store', [JurusanController::class, 'store'])->name('admin.jurusan.store');
    Route::put('admin/jurusan/update/{id}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
    Route::delete('admin/jurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');

    // MAPEL MENU
    Route::get('admin/mapel', [MapelController::class, 'index_admin'])->name('admin.mapel');
    Route::post('admin/mapel/store', [MapelController::class, 'store'])->name('admin.mapel.store');
    Route::put('admin/mapel/update/{id}', [MapelController::class, 'update'])->name('admin.mapel.update');
    Route::delete('admin/mapel/delete/{id}', [MapelController::class, 'destroy'])->name('admin.mapel.destroy');

    // KELAS MENU
    Route::get('admin/kelas', [KelasController::class, 'index_admin'])->name('admin.kelas');
    Route::post('admin/kelas/store', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::put('admin/kelas/update/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('admin/kelas/delete/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');


    //SAMPAH MENU
    Route::get('admin/deleted/{modelType}', [DeletedDataController::class, 'deleted_admin'])
    ->name('admin.deleted')
    ->where('modelType', '^(kelas|jurusan|jabatan|mapel)$'); 
    Route::post('admin/deleted/{modelType}/{id}/restore', [DeletedDataController::class, 'restore'])->name('deleted.restore');
    Route::delete('admin/deleted/{modelType}/{id}/force-delete', [DeletedDataController::class, 'forceDelete'])->name('deleted.forceDelete');


    // MENU LAPORAN
    Route::get('admin/laporan/pegawai', [LaporanPegawaiController::class, 'index'])->name('laporan.pegawai');
    Route::get('/laporan/pegawai/pdf', [LaporanPegawaiController::class, 'downloadPDF'])->name('laporan.pegawai.pdf');
    Route::get('/laporan/pegawai/{id}/pdf', [LaporanPegawaiController::class, 'downloadPegawaiDetailPDF'])->name('laporan.pegawai-detail.pdf');
 
});

Route::middleware(['auth:operator'])->group(function () {
    Route::get('/operator-dashboard', [HomeOperatorController::class, 'index'])->name('operator.dashboard');
    Route::post('/update-profile-operator', [UserController::class, 'updateProfile'])->name('profile.update.operator');

    // PEGAWAI MENU
    Route::get('operator/pegawai', [PegawaiController::class, 'index_operator'])->name('operator.pegawai');
    Route::get('operator/pegawai/create', [PegawaiController::class, 'create'])->name('operator.pegawai.create');
    Route::post('operator/pegawai/store', [PegawaiController::class, 'store'])->name('operator.pegawai.store');
    Route::get('operator/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('operator.pegawai.edit');
    Route::put('operator/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('operator.pegawai.update');
    Route::delete('operator/pegawai/delete/{id}', [PegawaiController::class, 'destroy'])->name('operator.pegawai.destroy');
    Route::get('operator/pegawai/{id}/show', [PegawaiController::class, 'show'])->name('operator.pegawai.show');
    Route::get('/operator/pegawai/toggle/{id}', [PegawaiController::class, 'toggleStatus'])->name('toggleStatus');

    // JABATAN MENU
    Route::get('operator/pegawai/jabatan', [JabatanController::class, 'index_operator'])->name('operator.jabatan.pegawai');
    Route::put('/pegawai/update-jabatan', [JabatanController::class, 'updateJabatan'])->name('operator.pegawai.updateJabatan');
    Route::delete('/operator/jabatan/deleteRiwayat/{id}', [JabatanController::class, 'deleteRiwayat'])->name('operator.jabatan.deleteRiwayat');
    Route::delete('/operator/jabatan/deleteAllRiwayat/{id_pegawai}', [JabatanController::class, 'deleteAllRiwayat'])->name('operator.jabatan.deleteAllRiwayat');

    // TUGAS TAMBAHAN MENU
    Route::get('operator/tugas', [TugasTambahanController::class, 'index'])->name('operator.tugas.pegawai');
    Route::post('operator/tugas/store', [TugasTambahanController::class, 'store'])->name('operator.tugas.tambah');
    Route::put('operator/tugas/update/{id}', [TugasTambahanController::class, 'update'])->name('operator.tugas.update');
    Route::delete('operator/tugas/delete/{id}', [TugasTambahanController::class, 'destroy'])->name('operator.tugas.delete');
    Route::post('operator/tugas/assign', [TugasTambahanController::class, 'assign'])->name('operator.tugas.atur');

    // GURU MATA PELAJARAN MENU
    Route::get('operator/guru_mapel', [MapelController::class, 'index_operator'])->name('operator.guru_mapel.pegawai');
    Route::put('operator/guru_mapel/update/{id}', [MapelController::class, 'update_guru_mapel'])->name('operator.guru_mapel.update');

    // GURU WALIKELAS MENU
    Route::get('/operator/kelas', [KelasController::class, 'index_operator'])->name('operator.walikelas.pegawai');
    Route::put('/operator/kelas/{id_kelas}/update-walikelas', [KelasController::class, 'updateWalikelas'])->name('operator.kelas.update_walikelas');

    // KEPALA JURUSAN MENU
    Route::get('operator/kepala-jurusan', [JurusanController::class, 'index_operator'])->name('operator.kepala_jurusan.pegawai');
    Route::post('operator/jurusan/{id}/update-kepala-jurusan', [JurusanController::class, 'updateKepalaJurusan'])->name('operator.jurusan.updateKepalaJurusan');


    // SAMPAH MENU
    Route::get('operator/deleted/{modelType}', [DeletedDataController::class, 'deleted_operator'])
    ->name('operator.deleted')
    ->where('modelType', '^(pegawai|prestasi)$'); 
    Route::post('operator/deleted/{modelType}/{id}/restore', [DeletedDataController::class, 'restore'])->name('operator.deleted.restore');
    Route::delete('operator/deleted/{modelType}/{id}/force-delete', [DeletedDataController::class, 'forceDelete'])->name('operator.deleted.forceDelete');
});


