<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\PembatalanSertifikatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SengketaKonflikController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HelpdeskController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tiket', HelpdeskController::class);

    Route::prefix('pembatalan-sertifikat')->group(function () {
        Route::get('/index', [PembatalanSertifikatController::class, 'index'])->name('pembatalan-sertifikat.index');
        Route::get('/cacat-administrasi', [PembatalanSertifikatController::class, 'cacat_administrasi'])->name('pembatalan-sertifikat.cacat_administrasi');
        Route::get('/putusan-pengadilan', [PembatalanSertifikatController::class, 'putusan_pengadilan'])->name('pembatalan-sertifikat.putusan_pengadilan');
    });

    Route::resource('laporan', LaporanController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('faq', FaqController::class);

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
