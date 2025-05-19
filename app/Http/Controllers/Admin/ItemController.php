<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        return view('pages.admin.items');
    }

    public function data(Request $request)
    {
        try {
            $columns = ['created_at', 'id', 'asset_code', 'name', 'procurement'];

            $query = Item::query();

            $query->with([
                'category' => function ($q) {
                    $q->select('id', 'name', 'description');
                },
                'room' => function ($q) {
                    $q->select('id', 'name', 'description');
                }
            ]);

            // Search filter
            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            }

            $totalFiltered = $query->count();

            // Ordering
            $orderCol = $columns[$request->input('order.0.column')];
            $orderDir = $request->input('order.0.dir');
            $query->orderBy($orderCol, $orderDir);

            // Pagination
            $start = $request->input('start');
            $length = $request->input('length');
            $data = $query->offset($start)
                ->limit($length)
                ->get();

            // Total semua data (tanpa filter)
            $totalData = Item::count();

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

    public function create()
    {
        $rooms = Room::all();
        $categories = Category::all();
        $units = [
            'Berat' => [
                'Kg (kilogram)',
                'Ton'
            ],
            'Isi' => [
                'L (liter)',
                'GL (gallon)',
                'M3 (meter kubik)'
            ],
            'Panjang' => [
                'M (meter)',
                'Km (kilometer)'
            ],
            'Luas' => [
                'Ha (hektar)',
                'M2 (persegi'
            ],
            'Jumlah' =>
                [
                    'Buah',
                    'Batang',
                    'Botol',
                    'Doos',
                    'Zak',
                    'Ekor',
                    'Stel',
                    'Rim',
                    'Unit',
                    'Pucuk',
                    'Set',
                    'Lembar',
                    'Box',
                    'Pasang',
                    'Roll',
                    'Lusin/Gross',
                    'Eksemplar'
                ]
        ];
        return view('pages.admin.create-item', compact(['rooms', 'categories', 'units']));
    }

}
