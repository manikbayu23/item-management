<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Room;
use App\Models\User;
use App\Models\Borrow;
use App\Models\RoomItem;
use Illuminate\Support\Str;
use App\Models\BorrowingLog;
use Illuminate\Http\Request;
use App\Mail\ResponseSubmission;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\ReminderSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BorrowItemController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        if ($auth->role == 'admin') {
            $rooms = Room::all();
        } else {
            $rooms = Room::whereHas('userrooms', function ($query) use ($auth) {
                $query->where('user_id', $auth->id);
            })->get();
        }
        $items = Item::where('status', 'active')->get();

        return view('pages.admin.borrow-items', compact(['rooms', 'items']));
    }

    public function data(Request $request)
    {
        try {
            $columns = ['id', 'room.name', 'item.code', 'item.name'];

            $query = Borrow::query();

            $query->with([
                'room_item.item:id,name,category_id,code,unit',
                'room_item.item.category:id,name',
                'room_item.room:id,name',
                'user:id,name',
                'admin:id,name',
                'borrowing_logs:id,borrowing_id,status,admin_id,user_id,notes,created_at',
                'borrowing_logs.admin:id,name',
                'borrowing_logs.user:id,name',
            ]);

            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('room_item.item', function ($r) use ($search) {
                        $r->where('name', 'like', "%" . Str::upper($search) . "%")
                            ->orWhere('code', 'like', "%{$search}%")
                            ->orWhere(DB::raw('UPPER(unit)'), 'like', "%" . Str::upper($search) . "%");
                    })->orWhereHas('room_item.item.category', function ($r) use ($search) {
                        $r->where('name', 'like', "%" . Str::upper($search) . "%");
                    })->orWhere('borrow_number', 'like', "%" . Str::upper($search) . "%")
                        ->orWhereHas('user', function ($r) use ($search) {
                            $r->where('name', 'like', "%" . Str::upper($search) . "%");
                        });
                });
            }

            if ($request->input('room') !== 'ALL') {
                $room = $request->input('room');
                $query->whereHas('room_item', function ($q) use ($room) {
                    $q->where('room_id', $room);
                });
            }

            if ($request->input('item') !== 'ALL') {
                $item = $request->input('item');
                $query->whereHas('room_item', function ($q) use ($item) {
                    $q->where('item_id', $item);
                });
            }

            if ($request->input('status') !== 'ALL') {
                $status = $request->input('status');
                $query->where('status', $status);
            }

            $totalFiltered = $query->count();

            // Ordering
            // $orderCol = $columns[$request->input('order.0.column')];
            // $orderDir = $request->input('order.0.dir');

            // $query->orderBy($orderCol, $orderDir);

            // Pagination
            $start = $request->input('start');
            $length = $request->input('length');
            $data = $query->orderByRaw("CASE 
                    WHEN status = 'pending' THEN 0
                    WHEN status = 'approved' THEN 1
                    WHEN status = 'in_progress' THEN 2
                    ELSE 3
                END")
                ->orderBy('created_at', 'desc')
                ->orderBy('status', 'desc')
                ->offset($start)
                ->limit($length)
                ->get();

            // Total semua data (tanpa filter)
            $totalData = Borrow::count();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $status = $request->input('status');
            $notes = $request->input('notes');
            $datetime = $request->input('datetime', Carbon::now());

            $borrow = Borrow::find($id);

            if (in_array($status, ['approved', 'in_progress'])) {
                $dateNow = Carbon::now();
                $endDate = Carbon::parse($borrow->end_date);
                $text = $status == 'in_progress' ? 'ambil barang' : $status;
                if ($dateNow->format('Y-m-d') > $endDate->format('Y-m-d')) {
                    return response()->json([
                        'success' => false,
                        'message' => "Tidak dapat melakukan {$text}, tanggal kembali sudah lewat tanggal hari ini."
                    ], 409);
                }
            }

            DB::beginTransaction();

            if ($status == 'approved') {
                $itemCondition = DB::table('item_conditions')
                    ->where('room_item_id', $borrow->room_item_id)
                    ->where('condition', 'baik')
                    ->lockForUpdate()
                    ->first();

                // 2. Hitung stok yang tersedia
                $borrowedQty = DB::table('borrowings')
                    ->where('room_item_id', $borrow->room_item_id)
                    ->whereIn('status', ['approved', 'in_progress'])
                    ->sum('qty');

                $qtyReady = $itemCondition->qty - ($borrowedQty ?? 0);

                if ($borrow->qty > $qtyReady) {
                    return response()->json([
                        'success' => false,
                        'message' => "Tidak dapat melakuakan {$status}, Barang tersedia hanya [{$qtyReady}]. Jumlah pengajuan [{$borrow->qty}]"
                    ], 409);
                }
            }

            if ($status == 'in_progress') {
                $borrow->actual_collection_date = $datetime;
            } elseif ($status == 'completed') {
                $borrow->actual_return_date = $datetime;
            }

            $borrow->admin_id = Auth::user()->id;
            $borrow->status = $status;
            $borrow->admin_notes = $notes;
            $borrow->updated_at = Carbon::now();
            $borrow->updated_by = Auth::user()->username;
            $borrow->save();

            BorrowingLog::create([
                'borrowing_id' => $borrow->id,
                'status' => $status,
                'admin_id' => Auth::user()->id,
                'notes' => $notes,
            ]);

            try {
                $user = User::find($borrow->user_id);
                if ($user) {
                    Mail::to($user->email)
                        ->bcc(Auth::user()->email)
                        ->send(new ResponseSubmission($borrow));
                }
            } catch (\Throwable $th) {
                // throw $th;
            }


            DB::commit();

            if ($status == 'cancel') {
                $text = 'membatalkan';
            } elseif ($status == 'in_progress') {
                $text = 'konfirmasi ambil barang,';
            } elseif ($status == 'rejected') {
                $text = 'menolak';
            } else {
                $text = $status;
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil {$text} pengajuan peminjaman barang nomor : {$borrow->borrow_number}"
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function reminder(Request $request, $id)
    {
        try {

            try {
                $borrow = Borrow::find($id);
                $user = User::find($borrow->user_id);

                $lastDate = $borrow->last_reminder ? Carbon::parse($borrow->last_reminder) : null;
                if ($lastDate && $lastDate->diffInHours(now()) < 6) {
                    return response()->json([
                        'success' => false,
                        'message' => "Pengingat hanya boleh dikirim setiap 6 jam. Pengingat terakhir dikirim pada: " . $lastDate->format('d-m-Y H:i')
                    ], 422);
                }
                if ($user) {
                    Mail::to($user->user)
                        ->bcc(Auth::user()->email)
                        ->send(new ReminderSubmission($borrow, $user));
                }
            } catch (\Throwable $th) {
                throw $th;
            }

            $borrow->last_reminder = Carbon::now();
            $borrow->reminder_to = $borrow->reminder_to ? ($borrow->reminder_to + 1) : 1;
            $borrow->updated_at = Carbon::now();
            $borrow->updated_by = Str::upper(Auth::user()->username);
            $borrow->save();

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengirim notifikasi pengembalian peminjaman barang nomor : {$borrow->borrow_number}"
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
