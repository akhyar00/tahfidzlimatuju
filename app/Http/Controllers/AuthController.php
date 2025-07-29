<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Session::has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if ($request->password === 'admin123') {
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }
        return back()->with('error', 'Password salah! Coba lagi.');
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Berhasil logout!');
    }
}