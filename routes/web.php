<?php

use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\PembatalanSertifikatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SengketaKonflikController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TicketCategoryController;
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

    Route::prefix('tiket')->name('tiket.')->group(function () {
        Route::resource('/', TiketController::class)->parameters(['' => 'tiket']);
        Route::post('/{id}/verification', [TiketController::class, 'verification'])->name('verification');
        Route::post('/{id}/return', [TiketController::class, 'return'])->name('return');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/partial', [NotificationController::class, 'partial'])->name('notifications.partial');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    Route::resource('laporan', LaporanController::class);
    // Route::resource('settings', SettingsController::class);

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::prefix('help')->group(function () {
        Route::get('/faq', [HelpController::class, 'index'])->name('help.index');
        Route::get('/guide', [HelpController::class, 'guide'])->name('help.guide');
        Route::get('/kontak', [HelpController::class, 'kontak'])->name('help.kontak');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::resource('faq', FaqController::class);
        Route::resource('ticket-category', TicketCategoryController::class);
    });
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
