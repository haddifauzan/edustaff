<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NotifikasiController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // USER DAN NOTIFIKASI
    Route::get('/profile', [AuthController::class, 'getProfile']);
    Route::get('/notifikasi', [NotifikasiController::class, 'getNotifications']);
    Route::post('/notifikasi/{notificationId}/read', [NotifikasiController::class, 'markAsRead']);
    Route::post('/logout', [AuthController::class, 'logout']);


    // FITUR UTAMA
    
});

