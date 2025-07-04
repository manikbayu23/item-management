<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = Borrow::selectRaw("
         COALESCE(SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END), 0) as last30,
    COALESCE(SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END), 0) as today,
    COALESCE(SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END), 0) as in_progress,
    COALESCE(SUM(CASE WHEN status = 'in_progress' AND end_date < ? THEN 1 ELSE 0 END), 0) as late
    ", [now()->subDays(30), now()->toDateString(), now()])
            ->where('user_id', $user->id)
            ->first();

        return view('pages.user.dashboard', compact('stats'));
    }
}
