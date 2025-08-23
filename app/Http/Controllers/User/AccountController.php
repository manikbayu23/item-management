<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Division;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $divisions = Division::all();
        $positions = Position::all();
        return view('pages.user.edit-account', compact(['user', 'divisions', 'positions']));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|unique:users,username,' . $user->id,
            'division' => 'required',
            'position' => 'required',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:255',
        ], [
            'name.required' => 'Nama wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karrakter',
            'username.unique' => 'Username sudah digunakan',
            'division.required' => 'Divisi wajib dipilih',
            'position.required' => 'Posisi wajib dipilih',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.numeric' => 'Hanya boleh berisi angka',
            'phone.digits_between' => 'Panjang nomor 10-15 digit',
            'phone.regex' => 'Format nomor tidak valid',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
        ]);


        $user->name = $validated['name'];
        $user->username = Str::upper($validated['username']);
        $user->phone_number = $validated['phone'];
        $user->division_id = $validated['division'];
        $user->position_id = $validated['position'];
        $user->email = $validated['email'];
        $user->updated_at = Carbon::now();
        $user->updated_by = Auth::user()->username;

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();
        return redirect()->back()
            ->with('success', 'Berhasil memperbarui akun.');

    }
}
