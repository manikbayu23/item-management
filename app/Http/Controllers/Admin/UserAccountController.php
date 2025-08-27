<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\User;
use App\Models\Division;
use App\Models\Position;
use App\Models\UserRoom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BorrowingLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $data = User::where(function ($query) use ($auth) {
            $query->where('created_by', $auth->username)
                ->orWhereHas('userrooms', function ($query2) use ($auth) {
                    $query2->whereIn('room_id', $auth->userrooms->pluck('room_id'));
                })->orWhere('id', $auth->id);
        });

        if ($auth->role !== 'admin') {
            $data->whereIn('role', ['staff', 'pic']);
        }
        $data = $data->orderBy('id', 'desc')
            ->get();

        return view('pages.admin.user-accounts', compact('data'));
    }
    public function create()
    {
        $divisions = Division::all();
        $positions = Position::all();
        return view('pages.admin.create-user-account', compact(['divisions', 'positions']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|unique:users,username',
            'division' => 'required', // Sesuaikan dengan nama tabel divisions
            'position' => 'required', // Sesuaikan dengan nama tabel divisions
            'role' => 'required|in:admin,pic,staff', // Asumsi value role 1 dan 2
            'phone' => 'required|numeric|digits_between:10,15|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:users,email|max:255', // Sesuaikan dengan tabel users
            'password' => 'required|string|min:8|max:255',

        ], [
            'name.required' => 'Nama wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karrakter',
            'username.unique' => 'Username sudah digunakan',
            'division.required' => 'Divisi wajib dipilih',
            'position.required' => 'Posisi wajib dipilih',
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
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = new User;
        $user->name = $validated['name'];
        $user->username = Str::upper($validated['username']);
        $user->phone_number = $validated['phone'];
        $user->division_id = $validated['division'];
        $user->position_id = $validated['position'];
        $user->role = $validated['role'];
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->created_at = Carbon::now();
        $user->created_by = Auth::user()->username;
        $user->updated_at = Carbon::now();
        $user->updated_by = Auth::user()->username;
        $user->save();
        return redirect()->route('admin.user-account')->with('success', 'Berhasil membuat akun pengguna.');

    }

    public function edit(string $id)
    {
        $user = User::find($id);
        $divisions = Division::all();
        $positions = Position::all();
        return view('pages.admin.edit-user-account', compact(['divisions', 'positions', 'user']));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|unique:users,username,' . $user->id,
            'division' => 'required',
            'position' => 'required',
            'role' => 'required|in:admin,pic,staff',
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
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role yang dipilih tidak valid',
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
        $user->role = $validated['role'];
        $user->email = $validated['email'];
        $user->updated_at = Carbon::now();
        $user->updated_by = Auth::user()->username;

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();
        return redirect()->route('admin.user-account')
            ->with('success', 'Berhasil memperbarui akun pengguna.');

    }

    public function destroy(string $id)
    {
        $borrowingLogs = BorrowingLog::where('admin_id', Auth::user()->id)
            ->orWhere('user_id', Auth::user()->id)
            ->first();
        if ($borrowingLogs) {
            return back()->with('error', 'Tidak bisa hapus akun karena sudah ada transaksi!');
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus');
    }

    public function rooms($id)
    {
        try {
            $auth = Auth::user();
            if ($auth->role == 'admin') {
                $rooms = Room::all();
            } else {
                $rooms = Room::whereHas('userrooms', function ($query) use ($auth) {
                    $query->whereIn('room_id', $auth->userrooms->pluck('room_id'));
                })->get();
            }
            $userRooms = UserRoom::where('user_id', $id)
                ->pluck('room_id');
            return response()->json([
                'success' => true,
                'rooms' => $rooms,
                'user_rooms' => $userRooms
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan data ruangan.',
                'errors' => $th->getMessage()
            ]);
        }
    }

    public function updateRooms(Request $request, string $id)
    {
        $userId = $id;
        $roomIds = $request->input('rooms', []);

        if (!empty($roomIds)) {
            $dataToUpsert = array_map(function ($roomId) use ($userId) {
                return [
                    'user_id' => $userId,
                    'room_id' => $roomId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }, $roomIds);

            UserRoom::upsert(
                $dataToUpsert,
                ['user_id', 'room_id'],
                ['updated_at']
            );
        }

        UserRoom::where('user_id', $userId)
            ->whereNotIn('room_id', $roomIds ?: [0]) // Hindari SQL error jika $roomIds kosong
            ->delete();

        return redirect()->back()->with('success', 'Akses ruangan berhasil diupdate.');
    }
}
