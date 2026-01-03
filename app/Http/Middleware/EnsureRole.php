<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles, true)) {
            // Si querés, podés redirigir al dashboard correcto en vez de 403:
            return redirect()->route('dashboard');
            // o: abort(403);
        }

        return $next($request);
    }
}
