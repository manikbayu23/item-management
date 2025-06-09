<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Room;
use App\Models\Borrow;
use App\Models\RoomItem;
use App\Models\UserRoom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ItemCondition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomInventroyController extends Controller
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

        return view('pages.admin.room-inventory', compact(['rooms', 'items']));
    }

    public function data(Request $request)
    {
        try {
            $columns = ['id', 'room.name', 'item.code', 'item.name'];

            $query = RoomItem::query();

            $query->with([
                'room:id,name', // Sintaks singkat untuk select id dan name
                'item:id,name,category_id,code,unit', // Sertakan category_id untuk relasi
                'item.category:id,name',   // Ambil nama kategori
                'conditions:id,room_item_id,condition,qty',// Sertakan room_item_id
                'borrowings' => function ($q) {
                    $q->whereIn('status', ['approved', 'in_progress'])
                        ->select('id', 'room_item_id', 'qty');
                }
            ]);

            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('item', function ($r) use ($search) {
                        $r->where('name', 'like', "%" . Str::upper($search) . "%")
                            ->orWhere('code', 'like', "%{$search}%")
                            ->orWhere(DB::raw('UPPER(unit)'), 'like', "%" . Str::upper($search) . "%");
                    })
                        ->orWhereHas('item.category', function ($r) use ($search) {
                            $r->where('name', 'like', "%" . Str::upper($search) . "%");
                        });
                });
            }

            if ($request->input('room') !== 'ALL') {
                $room = $request->input('room');
                $query->whereHas('room', function ($q) use ($room) {
                    $q->where('id', $room);
                });
            }

            if ($request->input('item') !== 'ALL') {
                $item = $request->input('item');
                $query->whereHas('item', function ($q) use ($item) {
                    $q->where('id', $item);
                });
            }

            $totalFiltered = $query->count();

            // Ordering
            // $orderCol = $columns[$request->input('order.0.column')];
            // $orderDir = $request->input('order.0.dir');

            // $query->orderBy($orderCol, $orderDir);

            // Pagination
            $start = $request->input('start');
            $length = $request->input('length');
            $data = $query->offset($start)
                ->limit($length)
                ->get();

            // Total semua data (tanpa filter)
            $totalData = RoomItem::count();

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room' => 'required',
            'item' => 'required',
            'qty_good' => 'required|min:0',
            'qty_demaged' => 'required|min:0',
            'qty_missing' => 'required|min:0',
        ], [
            'room.required' => 'Ruangan wajib dipilih.',
            'item.required' => 'Barang wajib dipilih.',
            'qty_good.required' => 'Jumlah baik wajib diisi',
            'qty_good.min' => 'Jumlah baik harus min 0',
            'qty_demaged.required' => 'Jumlah rusak wajib diisi',
            'qty_demaged.min' => 'Jumlah rusak harus min 0',
            'qty_missing.required' => 'Jumlah hilang wajib diisi',
            'qty_missing.min' => 'Jumlah hilang harus min 0',
        ]);

        try {
            $existingItem = RoomItem::where('room_id', $validated['room'])
                ->where('item_id', $validated['item'])
                ->first();

            if ($existingItem) {
                return response()->json([
                    'success' => false,
                    'message' => $existingItem->item->name . ' sudah ada pada ruangan ' . $existingItem->room->name
                ], 409);
            }
            $totalQty = (int) $validated['qty_good'] + (int) $validated['qty_demaged'] + (int) $validated['qty_missing'];

            DB::beginTransaction();

            $roomItem = RoomItem::create([
                'room_id' => $validated['room'],
                'item_id' => $validated['item'],
                'qty' => $totalQty
            ]);

            ItemCondition::create([
                'room_item_id' => $roomItem->id,
                'condition' => 'baik',
                'qty' => $validated['qty_good'],
            ]);

            ItemCondition::create([
                'room_item_id' => $roomItem->id,
                'condition' => 'rusak',
                'qty' => $validated['qty_demaged'],
            ]);

            ItemCondition::create([
                'room_item_id' => $roomItem->id,
                'condition' => 'hilang',
                'qty' => $validated['qty_missing'],
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambah barang.'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Gagal menambah barang " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah barang ' . $th->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'qty_good' => 'required|min:0',
            'qty_demaged' => 'required|min:0',
            'qty_missing' => 'required|min:0',
        ], [
            'qty_good.required' => 'Jumlah baik wajib diisi',
            'qty_good.min' => 'Jumlah baik harus min 0',
            'qty_demaged.required' => 'Jumlah rusak wajib diisi',
            'qty_demaged.min' => 'Jumlah rusak harus min 0',
            'qty_missing.required' => 'Jumlah hilang wajib diisi',
            'qty_missing.min' => 'Jumlah hilang harus min 0',
        ]);

        try {
            $roomItem = RoomItem::find($id);

            $borrowings = Borrow::where('room_item_id', $id)
                ->whereIn('status', ['approved', 'in_progress'])
                ->sum('qty');

            if ($borrowings > 0 && $validated['qty_good'] < $borrowings) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah barang bagus (' . $validated['qty_good'] . ') tidak boleh kurang dari jumlah yang sedang dipinjam (' . $borrowings . ' item)'
                ], 409);
            }

            $totalQty = (int) $validated['qty_good'] + (int) $validated['qty_demaged'] + (int) $validated['qty_missing'];

            DB::beginTransaction();

            $roomItem->update([
                'qty' => $totalQty
            ]);

            ItemCondition::where('room_item_id', $roomItem->id)
                ->where('condition', 'baik')
                ->update([
                    'qty' => $validated['qty_good'],
                ]);

            ItemCondition::where('room_item_id', $roomItem->id)
                ->where('condition', 'rusak')
                ->update([
                    'condition' => 'rusak',
                    'qty' => $validated['qty_demaged'],
                ]);

            ItemCondition::where('room_item_id', $roomItem->id)
                ->where('condition', 'hilang')
                ->update([
                    'qty' => $validated['qty_missing'],
                ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui barang.'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Gagal memperbarui barang " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui barang ' . $th->getMessage()
            ], 500);
        }
    }
}
