<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedByRole
{
//    public function handle(Request $request, Closure $next)
//    {
//        if (Auth::check()) {
//            $user = Auth::user();
//
//            // Redirection selon le rôle de l'utilisateur
//            if ($user->role === 'gestionnaire') {
//                return redirect()->route('gestionnaire.dashboardG');
//            }
//
//            if ($user->role === 'client') {
//                return redirect()->route('dashboard');
//            }
//        }
//
//        return $next($request);
//    }
}
