<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Borrow;
use App\Models\RoomItem;
use Illuminate\Http\Request;
use App\Models\ItemCondition;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::all();
        $roomItems = RoomItem::where('room_id', $request->input('room'))
            ->with('borrowings', function ($query) {
                $query->where('status', 'approved');
            })
            ->get();
        $roomName = 'Ruangan 1';
        return view('pages.user.items', compact(['roomName', 'rooms', 'roomItems']));
    }

    public function form($id)
    {
        $roomItem = RoomItem::find($id);
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
        $roomItem = RoomItem::find($id);

        try {
            DB::beginTransaction();
            // 1. LOCK row item_conditions terlebih dahulu
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
                ->where('status', 'approved')
                ->sum('qty');

            $qtyReady = $itemCondition->qty - ($borrowedQty ?? 0);

            if ($validated['qty'] > $qtyReady) {
                throw new \Exception('Pengajuan gagal: Barang tersedia hanya [' . $qtyReady . ']. Jumlah pengajuan [' . $validated['qty'] . ']');
            }

            Borrow::create([
                'room_item_id' => $roomItem->id,
                'user_id' => Auth::user()->id,
                'qty' => $validated['qty'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'notes' => $validated['notes'],
                'created_by' => Auth::user()->username,
                'updated_by' => Auth::user()->username
            ]);

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
