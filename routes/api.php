<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NotifikasiController;
use App\Http\Controllers\API\PengajuanController;
use App\Http\Controllers\API\PerubahanController;
use App\Http\Controllers\API\PrestasiController;
use App\Http\Controllers\API\HomeController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // USER DAN NOTIFIKASI
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::get('/notifikasi', [NotifikasiController::class, 'getNotifications']);
    Route::post('/notifikasi/{notificationId}/read', [NotifikasiController::class, 'markAsRead']);
    Route::post('/logout', [AuthController::class, 'logout']);


    // FITUR UTAMA
    Route::get('/data-pengajuan', [PengajuanController::class, 'getPengajuan']);
    Route::get('/data-perubahan', [PerubahanController::class, 'getPerubahan']);
    Route::get('/data-perubahan/{id_konfirmasi}', [PerubahanController::class, 'getPerubahanDetail']);
    Route::get('/data-prestasi', [PrestasiController::class, 'getPrestasi']);
    Route::get('/home', [HomeController::class, 'getDashboard']);

    // NOTIFIKASI
    Route::get('/notifikasi', [NotifikasiController::class, 'index']);
    // Menandai semua notifikasi sebagai dibaca
    Route::post('/notifikasi/mark-all-as-read', [NotifikasiController::class, 'markAllAsRead']);
    // Menandai notifikasi tertentu sebagai dibaca
    Route::post('/notifikasi/mark-as-read/{id}', [NotifikasiController::class, 'markAsRead']);
    // Menghapus notifikasi tertentu
    Route::delete('/notifikasi/delete/{id}', [NotifikasiController::class, 'destroy']);
    // Menghapus semua notifikasi
    Route::delete('/notifikasi/delete-all', [NotifikasiController::class, 'deleteAll']);
    Route::post('/update-fcm-token', [NotifikasiController::class, 'updateFcmToken']);
    Route::post('/test-send-notification/{userId}', [NotifikasiController::class, 'testSendNotification']);


});

