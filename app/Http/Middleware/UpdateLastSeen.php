<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UpdateLastSeen
{
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user) {
            $user->update(['last_seen' => now()]);
        }

        return $next($request);
    }
}