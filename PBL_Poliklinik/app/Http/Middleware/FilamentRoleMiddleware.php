<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilamentRoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ) {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('filament.admin.auth.login');
        }

        if (
            ! in_array(
                $user->role?->nama_role,
                ['superadmin', 'admin']
            )
        ) {
            abort(403);
        }

        return $next($request);
    }
}