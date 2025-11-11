<?php

use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Api\ApitiketController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
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

    Route::prefix('notifications')->group(function () {
        Route::get('/partial', [NotificationController::class, 'partial'])->name('notifications.partial');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    Route::prefix('tiket')->group(function () {
        Route::resource('/', TiketController::class)->parameters(['' => 'tiket']);
        Route::get('/', [TiketController::class, 'index'])->name('tiket.index');
        Route::post('/store', [TiketController::class, 'store'])->name('tiket.store');
        Route::post('/update', [TiketController::class, 'update'])->name('tiket.update');
        Route::post('/delete', [TiketController::class, 'delete'])->name('tiket.destroy');
        Route::post('/{id}/verification', [TiketController::class, 'verification'])->name('verification');
        Route::post('/{id}/return', [TiketController::class, 'return'])->name('return');
        Route::post('/{id}/close', [TiketController::class, 'close'])->name('return');
        Route::get('/{id}/timeline', [TiketController::class, 'getTimeline']);
        Route::post('/actionTiketAgent', [TiketController::class, 'actionTiketAgent'])->name('tiket.actionTiketAgent');

        // tiket message
        Route::get('/getAllChat/{ticketId}', [TiketController::class, 'getAllChat']);
        Route::post('/sendChat', [TiketController::class, 'sendChat']);

        // api
        Route::prefix('api')->group(function () {
            Route::get('/getKategori', [ApitiketController::class, 'getKategori'])->name('tiket.getKategori');
            Route::get('/getTiket', [ApitiketController::class, 'getTiket'])->name('tiket.getTiket');
            Route::get('/getDetailTiket/{id}', [ApitiketController::class, 'getDetailTiket'])->name('tiket.getDetailTiket');
            Route::get('/status-summary', [ApitiketController::class, 'statusSummary'])->name('tiket.statusSummary');
            Route::get('/checkDuplicateTiket/{id}/{title}', [ApitiketController::class, 'checkDuplicateTiket'])->name('tiket.checkDuplicateTiket');
        });
    });

    Route::resource('laporan', LaporanController::class);
    // Route::resource('settings', SettingsController::class);

    Route::prefix('help')->group(function () {
        Route::get('/faq', [HelpController::class, 'index'])->name('help.index');
        Route::get('/guide', [HelpController::class, 'guide'])->name('help.guide');
        Route::get('/kontak', [HelpController::class, 'kontak'])->name('help.kontak');
    });

    Route::name('user-management.')->prefix('user-management')->group(function () {
        Route::resource('users', UserManagementController::class);
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

