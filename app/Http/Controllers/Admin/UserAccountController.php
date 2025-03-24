<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Account;
use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\String_;
use Illuminate\Support\Facades\Storage;

class UserAccountController extends Controller
{
    public function index()
    {
        $data = User::orderBy('id', 'desc')->get();
        return view('pages.admin.user-accounts', compact('data'));
    }
    public function create()
    {
        $divisions = Division::all();
        return view('pages.admin.create-user-account', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Validasi Foto Profil
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validasi Nama
            'name' => 'required|string|max:255',

            // Validasi Divisi
            'division' => 'required', // Sesuaikan dengan nama tabel divisions
            // 'division' => 'required|exists:divisions,id', // Sesuaikan dengan nama tabel divisions

            // Validasi Role (saya perhatikan ada duplikasi name="division", seharusnya name="role")
            'role' => 'required|in:admin,user', // Asumsi value role 1 dan 2

            // Validasi No Telepon
            'phone' => 'required|numeric|digits_between:10,15|regex:/^[0-9]+$/',

            // Validasi Email
            'email' => 'required|email|unique:users,email|max:255', // Sesuaikan dengan tabel users

            // Validasi Password
            'password' => 'required|string|min:8|max:255',

            // Validasi Alamat
            'address' => 'required|string|max:1000'
        ], [
            // Pesan error kustom
            'profile_picture.required' => 'Foto profil wajib diupload',
            'profile_picture.image' => 'File harus berupa gambar',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB',
            'name.required' => 'Nama wajib diisi',
            'division.required' => 'Divisi wajib dipilih',
            'division.exists' => 'Divisi yang dipilih tidak valid',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role yang dipilih tidak valid',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.numeric' => 'Hanya boleh berisi angka',
            'phone.digits_between' => 'Panjang nomor 10-15 digit',
            'phone.regex' => 'Format nomor tidak valid',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'address.required' => 'Alamat wajib diisi'
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Format nama file: [nama]-[random].ext
            $filename = Str::slug($validated['name']) // Ambil dari input name
                . '-' . Str::random(5) // Tambahkan random string untuk unik
                . '.' . $file->getClientOriginalExtension(); // Pertahankan ekstensi

            $path = $file->storeAs('profile_pictures', $filename); // Simpan di storage

            $validated['profile_picture'] = $path; // Simpan path di database
        }

        $validated['password'] = bcrypt($validated['password']);

        try {
            DB::beginTransaction();

            $user = new User;
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = $validated['password'];
            $user->save();

            $account = new Account;
            $account->user_id = $user->id;
            $account->division_id = $validated['division'];
            $account->name = $validated['name'];
            $account->role = $validated['role'];
            $account->phone = $validated['phone'];
            $account->address = $validated['address'];
            $account->profile_picture = $validated['profile_picture'];
            $account->save();

            DB::commit();
            return redirect()->route('admin.user-accounts.index')->with('success', 'Berhasil membuat akun pengguna.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->nack()->with('error', 'Gagal memperbarui akun pengguna.');
        }
    }

    public function edit(String $id)
    {
        $user = User::find($id);
        $divisions = Division::all();
        return view('pages.admin.edit-user-account', compact(['divisions', 'user']));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'division' => 'required',
            'role' => 'required|in:admin,user',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:255',
            'address' => 'required|string|max:1000'
        ], [
            'profile_picture.image' => 'File harus berupa gambar',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB',
            'name.required' => 'Nama wajib diisi',
            'division.required' => 'Divisi wajib dipilih',
            'role.required' => 'Role wajib dipilih',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.numeric' => 'Hanya boleh berisi angka',
            'phone.digits_between' => 'Panjang nomor 10-15 digit',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
            'address.required' => 'Alamat wajib diisi'
        ]);

        DB::beginTransaction();
        try {
            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old picture if exists
                if ($user->account && $user->account->profile_picture) {
                    Storage::delete($user->account->profile_picture);
                }

                $file = $request->file('profile_picture');
                $filename = Str::slug($validated['name']) . '-' . Str::random(5) . '.' . $file->extension();
                $path = $file->storeAs('profile_pictures', $filename);
                $validated['profile_picture'] = $path;
            }

            // Update user data
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            $user->save();

            // Update or create account
            $accountData = [
                'division_id' => $validated['division'],
                'name' => $validated['name'],
                'role' => $validated['role'],
                'phone' => $validated['phone'],
                'address' => $validated['address']
            ];

            if (isset($validated['profile_picture'])) {
                $accountData['profile_picture'] = $validated['profile_picture'];
            }

            $user->account()->updateOrCreate(['user_id' => $user->id], $accountData);

            DB::commit();

            return redirect()->route('admin.user-accounts.index')
                ->with('success', 'Berhasil memperbarui akun pengguna.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(String $id)
    {

        $user = User::with('account')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Hapus file gambar jika ada
            if ($user->account && $user->account->profile_picture) {
                Storage::delete($user->account->profile_picture);
            }

            // Hapus relasi account terlebih dahulu
            $user->account()->delete();

            // Hapus user
            $user->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Akun berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }
}
