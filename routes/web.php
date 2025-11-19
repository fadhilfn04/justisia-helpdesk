<?php

use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Api\ApiTiketController;
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
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;
use PHPUnit\Util\Json;

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

        // $request->authenticate();

        $request->session()->regenerate();

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

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/agen-online', [DashboardController::class, 'getAgenOnline'])->name('dashboard.agenOnline');
    Route::get('/dashboard/realtime', [DashboardController::class, 'getRealtimeData'])->name('dashboard.realtime');

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
        Route::post('/{id}/return', [TiketController::class, 'return'])->name('tiket.return');
        Route::post('/{id}/close', [TiketController::class, 'close'])->name('tiket.close');
        Route::get('/{id}/timeline', [TiketController::class, 'getTimeline']);
        Route::post('/actionTiketAgent', [TiketController::class, 'actionTiketAgent'])->name('tiket.actionTiketAgent');
        Route::post('/ticketResolution', [TiketController::class, 'ticketResolution'])->name('tiket.ticketResolution');
        Route::post('/exportTiket', [TiketController::class, 'exportTiket'])->name('tiket.exportTiket');

        Route::get('/getAllChat/{ticketId}', [TiketController::class, 'getAllChat']);
        Route::post('/sendChat', [TiketController::class, 'sendChat']);

        Route::prefix('api')->group(function () {
            Route::get('/getKategori', [ApiTiketController::class, 'getKategori'])->name('tiket.getKategori');
            Route::get('/getTiket', [ApiTiketController::class, 'getTiket'])->name('tiket.getTiket');
            Route::get('/getDetailTiket/{id}', [ApiTiketController::class, 'getDetailTiket'])->name('tiket.getDetailTiket');
            Route::get('/status-summary', [ApiTiketController::class, 'statusSummary'])->name('tiket.statusSummary');
            Route::get('/checkDuplicateTiket/{id}/{title}', [ApiTiketController::class, 'checkDuplicateTiket'])->name('tiket.checkDuplicateTiket');
        });
    });

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/statistik-kinerja', [LaporanController::class, 'filterStatistikKinerja'])->name('laporan.filter.statistikKinerja');
    Route::get('/laporan/kinerja-bulanan', [LaporanController::class, 'filterKinerjaBulanan'])->name('laporan.filter.kinerjaBulanan');
    Route::get('/laporan/distribusi-kategori', [LaporanController::class, 'filterDistribusiKategori'])->name('laporan.filter.distribusiKategori');
    Route::get('/laporan/kinerja-agen', [LaporanController::class, 'filterKinerjaAgen'])->name('laporan.filter.kinerjaAgen');
    Route::get('/laporan/tren-sla', [LaporanController::class, 'filterTrenSla'])->name('laporan.filter.trenSla');
    Route::get('/laporan/kinerja-regional', [LaporanController::class, 'filterKinerjaRegional'])->name('laporan.filter.kinerjaRegional');
    Route::get('/laporan/tren-tiket-harian', [LaporanController::class, 'filterTrenTiketHarian'])->name('laporan.filter.trenTiketHarian');
    Route::get('/laporan/statistik', [LaporanController::class, 'filterStatistik'])->name('laporan.filter.statistik');

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
