<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\HomeOperatorController;
use App\Http\Controllers\HomePegawaiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DeletedDataController;
use App\Http\Controllers\TugasTambahanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\BantuanController;

use App\Http\Controllers\Laporan\LaporanPegawaiController;
use App\Http\Controllers\Laporan\LaporanRiwayatController;
use App\Http\Controllers\Laporan\LaporanTugasController;
use App\Http\Controllers\Laporan\LaporanPensiunKeluarController;
use App\Http\Controllers\Laporan\LaporanPrestasiController;

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

// ADMIN
Route::group(['middleware' => 'auth:admin'], function () {
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
    Route::get('admin/laporan/pegawai', [LaporanPegawaiController::class, 'index'])->name('admin.laporan.pegawai');
    Route::get('admin/laporan/pegawai/pdf', [LaporanPegawaiController::class, 'downloadPDF'])->name('admin.laporan.pegawai.pdf');
    Route::get('admin/laporan/pegawai/{id}/pdf', [LaporanPegawaiController::class, 'downloadPegawaiDetailPDF'])->name('admin.laporan.pegawai-detail.pdf');

    Route::get('admin/laporan/riwayat-jabatan', [LaporanRiwayatController::class, 'index'])->name('admin.laporan.riwayat-jabatan');
    Route::get('admin/laporan/riwayat-jabatan/pdf', [LaporanRiwayatController::class, 'downloadPDF'])->name('admin.laporan.riwayat-jabatan.pdf');

    Route::get('admin/laporan/tugas-tambahan', [LaporanTugasController::class, 'index'])->name('admin.laporan.tugas-tambahan');
    Route::get('admin/laporan/tugas-tambahan/pdf', [LaporanTugasController::class, 'downloadPDF'])->name('admin.laporan.tugas-tambahan.pdf');

    Route::get('admin/laporan/pensiun-keluar', [LaporanPensiunKeluarController::class, 'index'])->name('admin.laporan.pensiun-keluar');
    Route::get('admin/laporan/pensiun-keluar/pdf', [LaporanPensiunKeluarController::class, 'downloadPDF'])->name('admin.laporan.pensiun-keluar.pdf');
 
    Route::get('admin/laporan/prestasi', [LaporanPrestasiController::class, 'index'])->name('admin.laporan.prestasi');
    Route::get('admin/laporan/prestasi/pdf', [LaporanPrestasiController::class, 'downloadPDF'])->name('admin.laporan.prestasi.pdf');
    Route::get('admin/laporan/prestasi/{id}/pdf', [LaporanPrestasiController::class, 'prestasiDetailPdf'])->name('admin.laporan.prestasi-detail.pdf');

    // NOTIFIKASI
    Route::get('/admin-notifikasi/{id}', [NotifikasiController::class, 'index'])->name('notifikasi.admin');

    // LOG AKTIVITAS
    Route::get('admin/log-aktivitas', [LogController::class, 'index'])->name('admin.log');
});

// OPERATOR
Route::group(['middleware' => 'auth:operator'], function () {
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

    // PENGAJUAN PERUBAHAN DATA
    Route::get('/operator/perubahan', [KonfirmasiController::class, 'daftarPengajuan'])->name('operator.perubahan');
    Route::put('/operator/perubahan/setuju/{id}', [KonfirmasiController::class, 'setujuiPengajuan'])->name('operator.perubahan.setuju');
    Route::put('/operator/perubahan/tolak/{id}', [KonfirmasiController::class, 'tolakPengajuan'])->name('operator.perubahan.tolak');
    Route::get('/operator/perubahan/{id}/detail', [KonfirmasiController::class, 'detailPengajuan'])->name('operator.perubahan.detail');

    // PENGAJUAN PRESTASI PEGAWAI
    Route::get('/operator/prestasi', [PrestasiController::class, 'daftarPrestasi'])->name('operator.prestasi');
    Route::put('/operator/prestasi/setuju/{id}', [PrestasiController::class, 'setujuiPrestasi'])->name('operator.prestasi.setuju');
    Route::put('/operator/prestasi/tolak/{id}', [PrestasiController::class, 'tolakPrestasi'])->name('operator.prestasi.tolak');
    Route::delete('/operator/prestasi/{id}/hapus', [PrestasiController::class, 'hapusPrestasi'])->name('operator.prestasi.destroy');

    // PENGAJUAN PENSIUN/KELUAR
    Route::get('/operator/pengajuan', [PengajuanController::class, 'daftarPengajuan'])->name('operator.pengajuan');
    Route::post('/operator/pengajuan', [PengajuanController::class, 'storeOperator'])->name('operator.pengajuan.store');
    Route::post('/operator/pengajuan/{id}/approve', [PengajuanController::class, 'approve'])->name('operator.pengajuan.approve');
    Route::post('/operator/pengajuan/{id}/reject', [PengajuanController::class, 'reject'])->name('operator.pengajuan.reject');

    // SAMPAH MENU
    Route::get('operator/deleted/{modelType}', [DeletedDataController::class, 'deleted_operator'])
    ->name('operator.deleted')
    ->where('modelType', '^(pegawai|prestasi)$'); 
    Route::post('operator/deleted/{modelType}/{id}/restore', [DeletedDataController::class, 'restore'])->name('operator.deleted.restore');
    Route::delete('operator/deleted/{modelType}/{id}/force-delete', [DeletedDataController::class, 'forceDelete'])->name('operator.deleted.forceDelete');

    // NOTIFIKASI
    Route::get('/operator-notifikasi/{id}', [NotifikasiController::class, 'index'])->name('notifikasi.operator');

    // BANTUAN
    Route::get('operator/bantuan', [BantuanController::class, 'index_operator'])->name('operator.bantuan');
    Route::post('operator/bantuan-store', [BantuanController::class, 'store'])->name('bantuan.store.operator');
});

// PEGAWAI
Route::group(['middleware' => 'auth:pegawai'], function () {
    Route::get('/pegawai-dashboard', [HomePegawaiController::class, 'index'])->name('pegawai.dashboard');
    Route::get('/pegawai-profile', [HomePegawaiController::class, 'profile'])->name('pegawai.profile');
    Route::post('/update-profile-pegawai', [UserController::class, 'updateProfile'])->name('profile.update.pegawai');

    // PERUBAHAN DATA
    Route::get('/pegawai/edit', [KonfirmasiController::class, 'editDataDiri'])->name('pegawai.perubahan');
    Route::post('/pegawai/update', [KonfirmasiController::class, 'updateDataDiri'])->name('pegawai.updateDataDiri');
    Route::delete('/pengajuan/{id}/batalkan', [KonfirmasiController::class, 'batalkanPengajuan'])->name('batalkanPengajuan');

    // PRESTASI PEGAWAI
    Route::get('/pegawai/prestasi', [PrestasiController::class, 'index'])->name('pegawai.prestasi');
    Route::post('/pegawai/prestasi/store', [PrestasiController::class, 'store'])->name('pegawai.prestasi.store');
    Route::post('/pegawai/prestasi/update/{id}', [PrestasiController::class, 'update'])->name('pegawai.prestasi.update');
    Route::delete('/pegawai/prestasi/delete/{id}', [PrestasiController::class, 'destroy'])->name('pegawai.prestasi.destroy');
    Route::get('/pegawai/prestasi/{id}/show', [PrestasiController::class, 'show'])->name('pegawai.prestasi.show');

    // PENGAJUAN PENSIUN/KELUAR
    Route::get('/pegawai/pengajuan', [PengajuanController::class, 'index'])->name('pegawai.pengajuan');
    Route::post('/pegawai/pengajuan/store', [PengajuanController::class, 'store'])->name('pegawai.pengajuan.store');
    Route::put('/pegawai/pengajuan/update/{id}', [PengajuanController::class, 'update'])->name('pegawai.pengajuan.update');
    Route::delete('/pegawai/pengajuan/delete/{id}', [PengajuanController::class, 'destroy'])->name('pegawai.pengajuan.destroy');
    
    // NOTIFIKASI
    Route::get('/pegawai-notifikasi/{id}', [NotifikasiController::class, 'index'])->name('notifikasi.pegawai');

    // BANTUAN
    Route::get('pegawai/bantuan', [BantuanController::class, 'index_pegawai'])->name('pegawai.bantuan');
    Route::post('pegawai/bantuan-store', [BantuanController::class, 'store'])->name('bantuan.store');
});

Route::group(['middleware' => ['auth:pegawai,operator,admin']], function () {
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.markAllAsRead');
    Route::delete('/notifikasi/delete-all', [NotifikasiController::class, 'deleteAll'])->name('notifikasi.destroyAll');
    Route::post('/notifikasi/{id}/mark-as-read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::delete('/notifikasi/{id}/delete', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
});
