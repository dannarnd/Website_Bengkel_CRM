<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\StockAdjustmentController;
use App\Http\Controllers\Api\ServiceController;

/*
|--------------------------------------------------------------------------
| 1. Public Routes (Portal Pelanggan Publik)
|--------------------------------------------------------------------------
| Rute-rute ini dapat diakses oleh siapa saja tanpa memerlukan token login.
| Biasanya digunakan oleh pelanggan langsung di E-CRM.
*/

// Auth: Endpoint untuk mendapatkan Token Sanctum bagi pegawai
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

// E-CRM: Chatbot Asisten
Route::post('/chatbot', [ChatbotController::class, 'sendMessage']);

// E-CRM: Pelacakan Status Servis (By Plat Nomor & Nomor HP)
Route::post('/tracking-service', [\App\Http\Controllers\Api\TrackingController::class, 'trackService']);


/*
|--------------------------------------------------------------------------
| 2. Protected Routes (Wajib Login: auth:sanctum)
|--------------------------------------------------------------------------
| Rute-rute ini adalah area "Dapur Bengkel" yang hanya bisa diakses oleh 
| Admin dan Mekanik dengan melampirkan Bearer Token dari hasil login.
*/

Route::middleware('auth:sanctum')->group(function () {

    // Auth: Endpoint untuk mencabut (revoke) Token Sanctum
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    // Melihat profil user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Dashboard Stats
    Route::get('/dashboard-stats', [\App\Http\Controllers\Api\DashboardController::class, 'stats']);

    // ---------------------------------------------------------
    // MASTER DATA (Otomatis memuat route GET, POST, PUT, DELETE)
    // ---------------------------------------------------------
    Route::get('/sparepart/next-code/{prefix}', [\App\Http\Controllers\Api\SparepartController::class, 'getNextCode']);
    Route::apiResource('sparepart', \App\Http\Controllers\Api\SparepartController::class);
    Route::apiResource('pelanggan', \App\Http\Controllers\Api\PelangganController::class);
    Route::apiResource('kendaraan', \App\Http\Controllers\Api\KendaraanController::class);
    Route::apiResource('chatbot-rule', \App\Http\Controllers\Api\ChatbotRuleController::class);

    // ---------------------------------------------------------
    // MODUL TRANSAKSI UTAMA (Service)
    // ---------------------------------------------------------
    Route::apiResource('service', \App\Http\Controllers\Api\ServiceController::class);
    Route::post('/service/{id}/upload-photos', [\App\Http\Controllers\Api\ServiceController::class, 'uploadPhotos']);
    Route::post('/service/{id}/sparepart', [\App\Http\Controllers\Api\ServiceController::class, 'addSparepart']);
    Route::delete('/service/{id}/sparepart/{detailId}', [\App\Http\Controllers\Api\ServiceController::class, 'removeSparepart']);
    Route::post('/service/{id}/finish', [\App\Http\Controllers\Api\ServiceController::class, 'finishService']);

    // API Manajemen Pegawai (User)
    Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
    Route::post('/users', [\App\Http\Controllers\Api\UserController::class, 'store']);
    Route::put('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'update']);
    Route::delete('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'destroy']);

    // Custom Endpoint: Update Garansi Manual
    Route::put('/services/{id}/warranty', [\App\Http\Controllers\Api\ServiceController::class, 'updateWarranty']);

    Route::put('/service/{id}/status', [ServiceController::class, 'updateStatus']);
    Route::post('/service/{id}/claim-warranty', [ServiceController::class, 'claimWarranty']);
    Route::post('/service/{id}/reopen', [ServiceController::class, 'reopenService']);

    // ---------------------------------------------------------
    // MODUL PENYESUAIAN STOK (Mutasi Gudang)
    // ---------------------------------------------------------
    Route::get('/stock-adjustments', [StockAdjustmentController::class, 'index']);
    Route::post('/stock-adjustments', [StockAdjustmentController::class, 'storeBarangKeluar']);
    Route::post('/stock-adjustments/in', [StockAdjustmentController::class, 'storeBarangMasuk']);

});
