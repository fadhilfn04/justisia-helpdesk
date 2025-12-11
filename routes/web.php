<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\Api\ApitiketController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\Apps\UserManagementController;
use Illuminate\Support\Facades\Auth as FacadesAuth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Main route definitions for the Helpdesk application.
| These routes are loaded by the RouteServiceProvider within a "web" group.
|--------------------------------------------------------------------------
*/

Route::prefix('sso')->group(function () {
    Route::get('/redirect', function (Request $request) {
        $data = $request->all();
        // return $data;
        // Ambil string JSON pada field "data"
        $jsonString = $data['data'] ?? null;

        // Decode string JSON pertama
        $decodedData = $jsonString ? json_decode($jsonString, true) : null;

        if($decodedData['email_verified'] == false){
            $decodedData['email_verified'] = $decodedData['preferred_username'].'@atrbpn.go.id';
        }

        $email = $decodedData['email_verified'] ?? null;
        $user = User::where('email', $email)->first();
        if (!$user) {
            // Jika user belum ada, buat user baru
            $user = User::create([
                'name' => $decodedData['atrbpn-profile']['namapegawai'] ?? 'Unknown',
                'email' => $email,
                'role_id'=>3,
                'password' => bcrypt('password123'), // Set password random atau sesuai kebutuhan
                'data_user' => json_encode($decodedData),
            ]);
        } else {
            // Jika user sudah ada, update data_user
            $user->update([
                'data_user' => json_encode($decodedData),
            ]);
        }

        // Login user
        FacadesAuth::login($user);

        return redirect('/dashboard');
        // Return hasil decode, misal seluruh array
        // return response()->json([
        //     'raw_request' => $data,
        //     'decoded_data' => $decodedData,
        //     'nama_pegawai' => $decodedData['atrbpn-profile']['namapegawai'] ?? null,
        //     'kantor' => $decodedData['atrbpn-profile']['namakantor'] ?? null,
        // ]);
    })->name('sso.redirect');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/dashboard', 'index');
        Route::get('/dashboard/agen-online', 'getAgenOnline')->name('dashboard.agenOnline');
        Route::get('/dashboard/realtime', 'getRealtimeData')->name('dashboard.realtime');
    });

    Route::prefix('notifications')->name('notifications.')->controller(NotificationController::class)->group(function () {
        Route::get('/partial', 'partial')->name('partial');
        Route::post('/mark-all-read', 'markAllRead')->name('markAllRead');
        Route::post('/{id}/mark-read', 'markRead')->name('markRead');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('tiket')->name('tiket.')->group(function () {
        Route::controller(TiketController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('destroy');

            Route::post('/{id}/verification', 'verification')->name('verification');
            Route::post('/{id}/return', 'return')->name('return');
            Route::post('/{id}/close', 'close')->name('close');

            Route::get('/{id}/timeline', 'getTimeline')->name('timeline');

            Route::post('/actionTiketAgent', 'actionTiketAgent')->name('actionTiketAgent');
            Route::post('/ticketResolution', 'ticketResolution')->name('ticketResolution');
            Route::post('/exportTiket', 'exportTiket')->name('exportTiket');

            Route::get('/getAllChat/{ticketId}', 'getAllChat')->name('getAllChat');
            Route::post('/sendChat', 'sendChat')->name('sendChat');
        });

        Route::prefix('api')->name('api.')->controller(ApitiketController::class)->group(function () {
            Route::get('/getKategori', 'getKategori')->name('getKategori');
            Route::get('/getTiket', 'getTiket')->name('getTiket');
            Route::get('/getDetailTiket/{id}', 'getDetailTiket')->name('getDetailTiket');
            Route::get('/status-summary', 'statusSummary')->name('statusSummary');
            Route::get('/checkDuplicateTiket/{id}/{title}', 'checkDuplicateTiket')->name('checkDuplicateTiket');
        });
    });

    Route::prefix('laporan')->name('laporan.')->controller(LaporanController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/statistik-kinerja', 'filterStatistikKinerja')->name('filter.statistikKinerja');
        Route::get('/kinerja-bulanan', 'filterKinerjaBulanan')->name('filter.kinerjaBulanan');
        Route::get('/distribusi-kategori', 'filterDistribusiKategori')->name('filter.distribusiKategori');
        Route::get('/kinerja-agen', 'filterKinerjaAgen')->name('filter.kinerjaAgen');
        Route::get('/tren-sla', 'filterTrenSla')->name('filter.trenSla');
        Route::get('/kinerja-regional', 'filterKinerjaRegional')->name('filter.kinerjaRegional');
        Route::get('/tren-tiket-harian', 'filterTrenTiketHarian')->name('filter.trenTiketHarian');
        Route::get('/statistik', 'filterStatistik')->name('filter.statistik');
    });

    Route::prefix('help')->name('help.')->controller(HelpController::class)->group(function () {
        Route::get('/faq', 'index')->name('faq');
        Route::get('/guide', 'guide')->name('guide');
        Route::get('/kontak', 'kontak')->name('kontak');
    });

    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::resource('users', UserManagementController::class);
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::resource('faq', FaqController::class);
        Route::resource('ticket-category', TicketCategoryController::class);
    });
});

Route::view('/error', 'errors.500')->name('error.500');

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');

require __DIR__ . '/auth.php';