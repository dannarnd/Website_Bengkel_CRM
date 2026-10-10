<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\KendaraanController;
use App\Http\Controllers\Api\SparepartController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PembelianController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\ChatbotRuleController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/tracking-service', [TrackingController::class, 'track']);
Route::post('/chatbot', [ChatbotController::class, 'process']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    Route::apiResource('karyawan', KaryawanController::class);
    Route::apiResource('pelanggan', PelangganController::class);
    Route::apiResource('kendaraan', KendaraanController::class);
    Route::get('/sparepart/next-code/{prefix}', [SparepartController::class, 'generateNextCode']);
    Route::apiResource('sparepart', SparepartController::class);
    
    Route::get('/service', [ServiceController::class, 'index']);
    Route::get('/service/{id}', [ServiceController::class, 'show']);
    Route::post('/service', [ServiceController::class, 'store']);
    Route::put('/service/{id}/status', [ServiceController::class, 'updateStatus']);
    Route::delete('/service/{id}', [ServiceController::class, 'destroy']);
    Route::post('/service/{id}/sparepart', [ServiceController::class, 'addSparepart']);
    Route::delete('/service/{id}/sparepart/{detail_id}', [ServiceController::class, 'removeSparepart']);
    Route::post('/service/{id}/upload-photos', [ServiceController::class, 'uploadPhotos']);
    Route::post('/service/{id}/finish', [ServiceController::class, 'finish']);
    Route::post('/service/{id}/reopen', [ServiceController::class, 'reopen']);
    Route::post('/service/{id}/claim-warranty', [ServiceController::class, 'claimWarranty']);
    Route::put('/service/{id}/warranty', [ServiceController::class, 'updateWarranty']);
    
    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::post('/pembelian', [PembelianController::class, 'store']);
    
    Route::get('/distributor', [App\Http\Controllers\Api\DistributorController::class, 'index']);
    Route::post('/distributor', [App\Http\Controllers\Api\DistributorController::class, 'store']);
    Route::put('/distributor/{id}', [App\Http\Controllers\Api\DistributorController::class, 'update']);
    Route::delete('/distributor/{id}', [App\Http\Controllers\Api\DistributorController::class, 'destroy']);
    
    Route::get('/penjualan', [App\Http\Controllers\Api\PenjualanController::class, 'index']);
    Route::post('/penjualan', [App\Http\Controllers\Api\PenjualanController::class, 'store']);
    
    Route::get('/mutasi', [App\Http\Controllers\Api\MutasiController::class, 'index']);
    
    Route::apiResource('chatbot-rule', ChatbotRuleController::class);
});
