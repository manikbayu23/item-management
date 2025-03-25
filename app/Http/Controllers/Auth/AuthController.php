<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {

            return Auth::user()->account->role == 'admin' ? redirect()->route('admin.dashboard') : redirect('/'); // Ubah ke route tujuan
        }
        return view('pages.auth.login');
    }
    public function do_login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Kode wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cek apakah pengguna login dengan email atau username

        if (Auth::attempt(['email' => $validate['email'], 'password' => $validate['password']])) {
            return Auth::user()->account->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect('/');
        }

        return back()->withErrors(['failed' => 'Email / Password Salah.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
