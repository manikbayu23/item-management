<?php

namespace App\Http\Controllers\User;

use App\Models\Room;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BorrowingLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'ALL');
        $periode = $request->input('periode', Carbon::now()->day(-7)->toDateString() . ' - ' . Carbon::now()->toDateString());
        [$startDateRaw, $endDateRaw] = explode('-', $periode);

        $auth = Auth::user();
        $rooms = Room::all();
        $query = Borrow::with([
            'room_item.item:id,name,category_id,code,unit',
            'room_item.item.category:id,name',
            'room_item.room:id,name',
            'user:id,name',
            'admin:id,name',
            'borrowing_logs:id,borrowing_id,status,admin_id,user_id,notes,created_at',
            'borrowing_logs.admin:id,name',
            'borrowing_logs.user:id,name',
        ])->where('user_id', $auth->id)
            ->whereBetween('start_date', [
                Carbon::parse($startDateRaw)->startOfDay(),
                Carbon::parse($endDateRaw)->endOfDay()
            ]);



        $borrowings = $query->orderByRaw("CASE 
                WHEN status = 'pending' THEN 0
                WHEN status = 'approved' THEN 1
                WHEN status = 'in_progress' THEN 2
                ELSE 3
            END")
            ->orderBy('created_at', 'asc')
            ->paginate(25);

        $roomName = 'Ruangan 1';
        return view('pages.user.history', compact(['roomName', 'rooms', 'borrowings', 'startDateRaw', 'endDateRaw']));
    }

    public function cancelForm(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $borrow = Borrow::find($id);
            $borrow->status = 'cancel';
            $borrow->updated_at = Carbon::now();
            $borrow->updated_by = Auth::user()->username;
            $borrow->save();

            BorrowingLog::create([
                'borrowing_id' => $borrow->id,
                'status' => 'cancel',
                'user_id' => Auth::user()->id,
                'notes' => $request->input('notes'),
            ]);

            DB::commit();
            return back()->with('success', "Berhasil membatalkan pengajuan peminjaman no : {$borrow->borrow_number}");

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', $th->getMessage()); // Tampilkan error ke user
        }
    }
}
