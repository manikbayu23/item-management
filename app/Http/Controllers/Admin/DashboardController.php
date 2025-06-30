<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use function Laravel\Prompts\select;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard');
    }

    public function borrowingsToday(Request $request)
    {
        try {
            $today = Carbon::today()->toDateString();
            $yesterday = Carbon::yesterday()->toDateString();

            $stats = Borrow::selectRaw("
                SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as today,
                SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as yesterday,
                SUM(CASE WHEN status = 'pending' AND DATE(created_at) = ? THEN 1 ELSE 0 END) as pending_today,
                SUM(CASE WHEN status = 'completed' AND DATE(actual_return_date) = ? THEN 1 ELSE 0 END) as completed
            ", [$today, $yesterday, $today, $today])->first();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data pengajuan',
                'data' => $stats
            ]);
        } catch (\Throwable $th) {
            Log::error("Gagal menampilkan pengajuan " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan pengajuan ' . $th->getMessage()
            ], 500);
        }
    }

    public function borrowings(Request $request)
    {
        try {
            $data = Borrow::whereMonth('start_date', Carbon::now()->month)
                ->whereYear('start_date', Carbon::now()->year)
                ->selectRaw('count(*) as total, status')
                ->groupBy('status')
                ->get()
                ->pluck('total', 'status')
                ->toArray();


            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data pengajuan',
                'data' => $data,
                'total' => array_sum($data)
            ]);
        } catch (\Throwable $th) {
            Log::error("Gagal menampilkan pengajuan " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan pengajuan ' . $th->getMessage()
            ], 500);
        }
    }

    public function onlineUsers(Request $request)
    {
        try {

            $onlineUsers = DB::table('sessions')
                ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
                ->whereNotNull('user_id')
                ->count();

            $users = DB::table('users')->count();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data ',
                'total' => $onlineUsers,
                'total_user' => $users
            ]);
        } catch (\Throwable $th) {
            Log::error("Gagal menampilkan data " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan data ' . $th->getMessage()
            ], 500);
        }
    }

}
