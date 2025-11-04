<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\PembatalanSertifikatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SengketaKonflikController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
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
    Route::resource('tiket', TiketController::class);

    Route::prefix('pembatalan-sertifikat')->group(function () {
        // Views
        Route::get('/index', [PembatalanSertifikatController::class, 'index'])->name('pembatalan-sertifikat.index');
        Route::get('/cacat-administrasi', [PembatalanSertifikatController::class, 'cacat_administrasi'])->name('pembatalan-sertifikat.cacat_administrasi');
        Route::get('/putusan-pengadilan', [PembatalanSertifikatController::class, 'putusan_pengadilan'])->name('pembatalan-sertifikat.putusan_pengadilan');

        // CRUD
        Route::get('/create', [PembatalanSertifikatController::class, 'create'])->name('pembatalan-sertifikat.create');
        Route::post('/', [PembatalanSertifikatController::class, 'store'])->name('pembatalan-sertifikat.store');
        Route::get('/{id}/edit', [PembatalanSertifikatController::class, 'edit'])->name('pembatalan-sertifikat.edit');
        Route::put('/{id}', [PembatalanSertifikatController::class, 'update'])->name('pembatalan-sertifikat.update');
        Route::delete('/{id}', [PembatalanSertifikatController::class, 'destroy'])->name('pembatalan-sertifikat.destroy');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/partial', [NotificationController::class, 'partial'])->name('notifications.partial');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    Route::resource('laporan', LaporanController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('faq', FaqController::class);

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::prefix('help')->group(function () {
        Route::get('/faq', [FaqController::class, 'index'])->name('help.index');
        Route::get('/guide', [FaqController::class, 'guide'])->name('help.guide');
        Route::get('/kontak', [FaqController::class, 'kontak'])->name('help.kontak');
    });
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
