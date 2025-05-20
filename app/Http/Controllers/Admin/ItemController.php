<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Room;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
                    $q->select('id', 'name');
                },
            ]);

            // Search filter
            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%")
                        ->orWhere('unit', 'like', "%{$search}%");
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'regex:/^\d{1,2}(\.\d{1,2})*$/',
                'unique:items,code'
            ],
            'category' => 'required', // TEXT
            'name' => 'required|string', // TEXT
            'brand' => 'required|string', // TEXT
            'unit' => 'required|string|max:50', // VARCHAR dengan maksimal 50 karakter
            'notes' => 'required|string', // TEXT
        ], [
            'code.required' => 'Kode barang wajib diisi.',
            'code.unique' => 'Kode barang ini sudah terdaftar di sistem, mohon load ulang kode.',
            'code.regex' => 'Format kode barang tidak valid.',
            'category.required' => 'Kategori wajib dipilih.',
            'brand.required' => 'Merk wajib diisi.',
            'name.required' => 'Nama barang wajib diisi.',
            'name.string' => 'Nama barnag harus berupa teks.',
            'unit.required' => 'Satuan wajib diisi.',
            'unit.string' => 'Satuan harus berupa teks.',
            'unit.max' => 'Satuan maksimal 50 karakter.',
            'notes.required' => 'Keterangan wajib diisi.',
            'notes.string' => 'Keterangan harus berupa teks.',
        ]);

        try {
            DB::beginTransaction();

            $exists = Item::where('code', $validated['code'])
                ->lockForUpdate()
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Kode barang ini sudah terdaftar di sistem, mohon load ulang kode.',
                    'errors' => [
                        'code' => [
                            'Kode barang ini sudah terdaftar di sistem, mohon load ulang kode.'
                        ]
                    ]
                ], 422);
            }

            Item::create([
                'code' => $validated['code'],
                'name' => Str::upper($validated['name']),
                'category_id' => $validated['category'],
                'status' => 1,
                'brand' => $validated['brand'],
                'unit' => $validated['unit'],
                'notes' => $validated['notes'],
                'created_at' => Carbon::now(),
                'created_by' => Auth::user()->username,
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::user()->username
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan barang'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Gagal menambahkan barang " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan barang ' . $th->getMessage()
            ], 500);
        }
    }

    public function edit(string $id)
    {
        $item = Item::find($id);
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
        return view('pages.admin.edit-item', compact(['item', 'categories', 'units']));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'regex:/^\d{1,2}(\.\d{1,2})*$/',
                Rule::unique(table: 'items')->ignore($id)
            ],
            'category' => 'required', // TEXT
            'name' => 'required|string', // TEXT
            'brand' => 'required|string', // TEXT
            'unit' => 'required|string|max:50', // VARCHAR dengan maksimal 50 karakter
            'notes' => 'required|string', // TEXT
        ], [
            'code.required' => 'Kode barang wajib diisi.',
            'code.unique' => 'Kode barang ini sudah terdaftar di sistem, mohon load ulang kode.',
            'code.regex' => 'Format kode barang tidak valid.',
            'category.required' => 'Kategori wajib dipilih.',
            'name.required' => 'Nama barang wajib diisi.',
            'name.string' => 'Nama barang harus berupa teks.',
            'unit.required' => 'Satuan wajib diisi.',
            'brand.required' => 'Merk wajib diisi.',
            'unit.string' => 'Satuan harus berupa teks.',
            'unit.max' => 'Satuan maksimal 50 karakter.',
            'notes.required' => 'Keterangan wajib diisi.',
            'notes.string' => 'Keterangan harus berupa teks.',
        ]);

        try {
            DB::beginTransaction();

            $exists = Item::where('code', $validated['code'])
                ->whereNot('id', $id)
                ->lockForUpdate()
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Kode barang ini sudah terdaftar di sistem, mohon load ulang kode.',
                    'errors' => [
                        'code' => [
                            'Kode barang ini sudah terdaftar di sistem, mohon load ulang kode.'
                        ]
                    ]
                ], 422);
            }

            $item = Item::find($id)
                ->update([
                    'code' => $validated['code'],
                    'name' => Str::upper($validated['name']),
                    'category_id' => $validated['category'],
                    'brand' => $validated['brand'],
                    'unit' => $validated['unit'],
                    'notes' => $validated['notes'],
                    'updated_at' => Carbon::now(),
                ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui barang : ' . $validated['name']
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


    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $asset = Item::findOrFail($id);
        $asset->status = $status ? 'active' : 'notactive';
        $asset->updated_by = Auth::user()->username;
        $asset->save();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ' . ($status ? 'mengaktifkan' : 'menonaktifkan') . ' asset ' . $asset->code
        ]);
    }

}
