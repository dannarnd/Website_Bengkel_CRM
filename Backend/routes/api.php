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
    Route::apiResource('sparepart', SparepartController::class);
    
    Route::get('/service', [ServiceController::class, 'index']);
    Route::get('/service/{id}', [ServiceController::class, 'show']);
    Route::post('/service', [ServiceController::class, 'store']);
    Route::put('/service/{id}/status', [ServiceController::class, 'updateStatus']);
    
    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::post('/pembelian', [PembelianController::class, 'store']);
    
    Route::apiResource('chatbot-rule', ChatbotRuleController::class);
});
