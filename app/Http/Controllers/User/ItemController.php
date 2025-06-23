<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Borrow;
use App\Models\RoomItem;
use App\Models\BorrowingLog;
use Illuminate\Http\Request;
use App\Models\ItemCondition;
use App\Mail\BorrowingSubmission;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $room = $request->input('room');
        $slug = $request->input('slug');

        $rooms = Room::all();

        $query = RoomItem::with([
            'borrowings' => function ($query) {
                $query->whereIn('status', ['approved', 'in_progress']);
            }
        ]);

        if ($slug) {
            $query->whereHas('room', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        } else {
            $query->where('room_id', $room);
        }

        // buat email pengajuan
        $roomItems = $query->get();

        $roomName = !empty($roomItems[0]) ? $roomItems[0]->room->name : '';
        if ($slug && ($roomName == '')) {
            $roomName = Room::where('slug', $slug)->select('name')->value('name');
        }
        return view('pages.user.items', compact(['roomName', 'rooms', 'roomItems']));
    }

    public function form($id)
    {
        $roomItem = RoomItem::with([
            'borrowings' => function ($q) {
                $q->whereIn('status', ['approved', 'in_progress']);
            },
            'conditions' => function ($q) {
                $q->where('condition', 'baik');
            }
        ])->find($id);

        return view('pages.user.form-submission', compact(['roomItem']));
    }

    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:1', // Tahun saja (contoh: 2023)
            'start_date' => 'required|date', // Format tanggal (YYYY-MM-DD)
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'required|string', // TEXT
        ], [
            'qty.required' => 'Jumlah peminjaman wajib diisi.',
            'qty.integer' => 'Jumlah harus berupa angka',
            'qty.min' => 'Jumlah peminjaman minimal 1 unit.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal kemabali harus setelah atau sama dengan tanggal pinjam',
            'notes.required' => 'Keterangan wajib diisi.',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $roomItem = RoomItem::with([
            'room.userrooms.user' => function ($q) {
                $q->where('role', 'pic');
            }
        ])->find($id);

        try {
            DB::beginTransaction();

            $year = Carbon::now()->year;

            $lastNumber = DB::table('borrowings')
                ->whereYear('created_at', $year)
                ->orderBy('sq_borrow_number', 'desc')
                ->lockForUpdate()
                ->value('sq_borrow_number');

            $nextNumber = $lastNumber ? $lastNumber + 1 : 1;
            // Format nomor: PJM/2025/00001
            $borrowNumber = sprintf("PJM/%d/%05d", $year, $nextNumber);

            $itemCondition = DB::table('item_conditions')
                ->where('room_item_id', $id)
                ->where('condition', 'baik')
                ->lockForUpdate()
                ->first();

            if (!$itemCondition) {
                throw new \Exception('Barang tidak tersedia');
            }

            // 2. Hitung stok yang tersedia
            $borrowedQty = DB::table('borrowings')
                ->where('room_item_id', $id)
                ->whereIn('status', ['approved', 'in_progress'])
                ->sum('qty');

            $qtyReady = $itemCondition->qty - ($borrowedQty ?? 0);

            if ($validated['qty'] > $qtyReady) {
                throw new \Exception('Pengajuan gagal: Barang tersedia hanya [' . $qtyReady . ']. Jumlah pengajuan [' . $validated['qty'] . ']');
            }

            $newBorrow = Borrow::create([
                'room_item_id' => $roomItem->id,
                'user_id' => Auth::user()->id,
                'sq_borrow_number' => $nextNumber,
                'borrow_number' => $borrowNumber,
                'qty' => $validated['qty'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'notes' => $validated['notes'],
                'created_by' => Auth::user()->username,
                'updated_by' => Auth::user()->username
            ]);

            BorrowingLog::create([
                'borrowing_id' => $newBorrow->id,
                'status' => 'pending',
                'user_id' => Auth::user()->id,
                'notes' => $validated['notes'],
            ]);

            $emailTo = null;
            $emailsCc = [];
            foreach ($roomItem->room->userrooms as $key => $userrooms) {
                if ($userrooms->user && $userrooms->user->email) {
                    if (!$emailTo) {
                        $emailTo = $userrooms->user->email;
                    }
                    $emailsCc[] = $userrooms->user->email ?? '';
                }
            }

            $emailAdmin = User::where('role', 'admin')
                ->value('email');

            if (!$emailTo) {
                $emailTo = $emailAdmin;
            } else {
                $emailsCc[] = $emailAdmin;
            }

            if (!$emailTo) {
                throw new \Exception('Pengajuan gagal: email approval belum di set.');
            }

            try {
                Mail::to($emailTo)
                    ->cc($emailsCc)
                    ->send(new BorrowingSubmission($newBorrow, $roomItem));
            } catch (\Throwable $th) {
                throw $th;
            }

            DB::commit();
            return redirect()->route('user.history')->with('success', 'Berhasil membuat pengajuan peminjaman barang.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', $th->getMessage()); // Tampilkan error ke user
        }
    }
}
