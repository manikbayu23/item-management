<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BorrowItemController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        if ($auth->role == 'superadmin') {
            $rooms = Room::all();
        } else {
            $rooms = Room::whereHas('userrooms', function ($query) use ($auth) {
                $query->where('user_id', $auth->id);
            })->get();
        }
        $items = Item::where('status', 'active')->get();

        return view('pages.admin.borrow-items', compact(['rooms', 'items']));
    }
}
