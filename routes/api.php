<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\EselonController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\AgamaController;
use App\Http\Controllers\UnitKerjaController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/pegawai/print', [PegawaiController::class, 'print'])
    ->name('pegawai.print');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('pegawai', PegawaiController::class);

    Route::apiResource('golongan', GolonganController::class);
    Route::apiResource('eselon', EselonController::class);
    Route::apiResource('jabatan', JabatanController::class);
    Route::apiResource('agama', AgamaController::class);
    Route::apiResource('unit-kerja', UnitKerjaController::class);
});
