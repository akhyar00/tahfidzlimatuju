<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}