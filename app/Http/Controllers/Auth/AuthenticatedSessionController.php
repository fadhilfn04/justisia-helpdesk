<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-in/general.js');

        return view('pages/auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp(),
        ]);

        switch ($user->role_id) {
            case 1:
                $redirectUrl = RouteServiceProvider::ADMIN;
                break;
            case 2:
                $redirectUrl = RouteServiceProvider::AGENT;
                break;
            case 3:
                $redirectUrl = RouteServiceProvider::USER;
                break;
            default:
                $redirectUrl = RouteServiceProvider::USER;
                break;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect_url' => $redirectUrl,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role_id' => $user->role_id,
                    'email' => $user->email,
                ],
            ]);
        }

        return redirect()->intended($redirectUrl);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function ssoLogin(Request $request)
    {
        $token = $request->query('token');
        $secret = env('SSO_SHARED_SECRET');

        try {
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            $user = User::where('email', $decoded->email)->first();

            if (!$user) {
                return redirect('/login')->withErrors('User tidak ditemukan.');
            }

            Auth::login($user);
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->getClientIp(),
            ]);

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Token tidak valid atau sudah kedaluwarsa.');
        }
    }
}
