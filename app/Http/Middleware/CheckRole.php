<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;



class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to login first.');
        }

        // Check if user's role is in the allowed roles
        $userRole = auth()->user()->roles;
        if (!in_array($userRole, $roles)) {
            // If not, redirect with an error message
            return redirect()->route('/')->with('error', 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}