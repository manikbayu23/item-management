<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }
    public function register(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            // Buat user baru
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->save();


            return 'success';

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
