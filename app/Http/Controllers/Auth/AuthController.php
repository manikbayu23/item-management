<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return in_array(Auth::user()->role, ['admin', 'pic']) ? redirect()->route('admin.dashboard') : redirect('/'); // Ubah ke route tujuan
        }
        return view('pages.auth.login');
    }
    public function do_login(Request $request)
    {
        $validate = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ], [
            'login.required' => 'Email/Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginType = filter_var($validate['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => ($loginType == 'username' ? Str::upper($validate['login']) : $validate['login']), 'password' => $validate['password']])) {
            return in_array(Auth::user()->role, ['admin', 'pic'])
                ? redirect()->route('admin.dashboard')
                : redirect('/');
        }

        return back()->withErrors([
            'failed' => 'Email/Username atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
