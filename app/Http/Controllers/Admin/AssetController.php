<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Asset;
use App\Models\Location;
use App\Models\Department;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Group;
use App\Models\Scope;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function index()
    {
        return view('pages.admin.assets');
    }

    public function data(Request $request)
    {
        try {
            $columns = ['created_at', 'id', 'asset_code', 'procurement'];

            $query = Asset::query();

            $query->with(['department' => function ($q) {
                $q->select('id', 'code', 'name');
            }]);
            // if ($sub_category = $request->input('sub_category') !== 'ALL') {
            //     $query->where('department_id', $sub_category);
            // }

            // Search filter
            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('asset_code', 'like', "%{$search}%");
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
            $totalData = Asset::count();

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
        $groups = Group::all();
        $subCategories = SubCategory::all();
        $location = Location::findOrFail(1);
        $departments = Department::all();
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
        return view('pages.admin.create-asset', compact(['departments', 'groups', 'location', 'units']));
    }


    public function lastCode(Request $request)
    {
        try {
            $id = $request->input('idSubCategory');
            $codeSubCategory = SubCategory::where('id', $id)->pluck('code')->first();

            // // Ambil kode terakhir dari Scope yang memiliki prefix sesuai dengan codeGroup
            $codeAsset = Asset::where('asset_code', 'like', "{$codeSubCategory}%")
                ->latest('asset_code')
                ->pluck('asset_code')
                ->first();

            if ($codeAsset) {
                // Ambil dua angka terakhir setelah titik terakhir
                preg_match('/\.(\d+)$/', $codeAsset, $matches);

                // Ambil angka terakhir, jika ada
                $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;


                // Tambahkan 1 dan pastikan format tetap '00', '01', '02', ...
                $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

                $code = "{$codeSubCategory}{$newNumber}";
            } else {
                $code = "{$codeSubCategory}00001";
            }

            return response()->json(['success' => 'true', 'code' => $code]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getScopes(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data bidang.',
                'data' => Scope::where('group_id', $request->input('idGroup'))->get()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal medapatkan data bidang.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function getCategories(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data kategori.',
                'data' => Category::where('scope_id', $request->input('idScope'))->get()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal medapatkan data kategori',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function getSubCategories(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data sub kategori.',
                'data' => SubCategory::where('category_id', $request->input('idCategory'))->get()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal medapatkan sub data kategori',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_code' => [
                'required',
                'regex:/^\d{1,5}(\.\d{1,5})*$/',
                'unique:assets,asset_code'
            ],
            'procurement' => 'required|date_format:Y', // Tahun saja (contoh: 2023)
            'acquisition' => 'required|date', // Format tanggal (YYYY-MM-DD)
            'type' => 'required|string|max:100', // VARCHAR dengan maksimal 255 karakter

            'department_id' => 'required', // TEXT
            'asset_identity' => 'required|string', // TEXT
            'qty' => 'required|integer|min:0', // Integer minimal 1
            'unit' => 'required|string|max:50', // VARCHAR dengan maksimal 50 karakter
            'description' => 'required|string', // TEXT
            'file_name' => 'required|image|mimes:jpg,png,jpeg|max:1024' // Gambar dengan format jpg/png/jpeg maksimal 1MB (1024KB)
        ], [
            'asset_code.required' => 'Kode aset wajib diisi.',
            'asset_code.unique' => 'Kode aset ini sudah terdaftar di sistem, mohon load ulang kode.',
            'asset_code.regex' => 'Format kode aset tidak valid.',

            'procurement.required' => 'Tahun pengadaan wajib diisi.',
            'procurement.date_format' => 'Format tahun pengadaan tidak valid (contoh: 2025).',

            'acquisition.required' => 'Tanggal perolehan wajib diisi.',
            'acquisition.date' => 'Format tanggal perolehan tidak valid.',

            'type.required' => 'Jenis aset wajib diisi.',
            'type.string' => 'Jenis aset harus berupa teks.',
            'type.max' => 'Jenis aset maksimal 100 karakter.',

            'department_id.required' => 'Departemen wajib dipilih.',

            'asset_identity.required' => 'Identitas aset wajib diisi.',
            'asset_identity.string' => 'Identitas aset harus berupa teks.',

            'qty.required' => 'Kuantitas wajib diisi.',
            'qty.integer' => 'Kuantitas harus berupa angka bulat.',
            'qty.min' => 'Kuantitas minimal 0.',

            'unit.required' => 'Satuan wajib diisi.',
            'unit.string' => 'Satuan harus berupa teks.',
            'unit.max' => 'Satuan maksimal 50 karakter.',

            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'file_name.required' => 'File gambar wajib diunggah.',
            'file_name.image' => 'File harus berupa gambar.',
            'file_name.mimes' => 'Format gambar yang diperbolehkan: jpg, png, jpeg.',
            'file_name.max' => 'Ukuran gambar maksimal 1MB.'
        ]);

        try {
            if ($request->hasFile('file_name')) {
                // Delete old picture if exists
                $file = $request->file('file_name');

                // Format nama file: [nama asli]-[random].ext
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Nama file tanpa ekstensi
                $extension = $file->getClientOriginalExtension(); // Ekstensi file
                $filename = $originalName . '-' . uniqid() . '.' . $extension; // Gabungkan dengan ID unik

                // Simpan di storage
                $file->storeAs('asset_pictures', $filename);

                // Simpan path di database (pastikan nama kolom sesuai)
                $validated['file_name'] = $filename; // Sesuaikan dengan nama field di form ('filename' bukan 'pr
            }

            DB::beginTransaction();

            $exists = Asset::where('asset_code', $validated['asset_code'])
                ->lockForUpdate()
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Kode aset ini sudah terdaftar di sistem, mohon load ulang kode.',
                    'errors' => [
                        'asset_code' => [
                            'Kode aset ini sudah terdaftar di sistem, mohon load ulang kode.'
                        ]
                    ]
                ], 422);
            }


            $location = Location::findOrFail(1)->code;
            $locationCode = $location . '.1.' . $validated['procurement'];
            Asset::create([
                'asset_code' => $validated['asset_code'],
                'location_code' => $locationCode,
                'procurement' => $validated['procurement'],
                'acquisition' => Carbon::parse($validated['acquisition']),
                'department_id' => $validated['department_id'],
                'type' => $validated['type'],
                'status' => 1,
                'asset_identity' => $validated['asset_identity'],
                'qty' => $validated['qty'],
                'unit' => $validated['unit'],
                'description' => $validated['description'],
                'file_name' => $validated['file_name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan aset'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Gagal menambahkan aset " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan aset ' . $th->getMessage()
            ], 500);
        }
    }

    public function edit(string $id)
    {
        $asset = Asset::find($id);
        $groups = Group::all();
        $subCategories = SubCategory::all();
        $location = Location::findOrFail(1);
        $departments = Department::all();
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
        return view('pages.admin.edit-asset', compact(['asset', 'departments', 'groups', 'location', 'units']));
    }
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'asset_code' => [
                'required',
                'regex:/^\d{1,5}(\.\d{1,5})*$/',
                Rule::unique('assets')->ignore($id)
            ],
            'procurement' => 'required|date_format:Y', // Tahun saja (contoh: 2023)
            'acquisition' => 'required|date', // Format tanggal (YYYY-MM-DD)
            'type' => 'required|string|max:100', // VARCHAR dengan maksimal 255 karakter

            'asset_identity' => 'required|string', // TEXT
            'qty' => 'required|integer|min:0', // Integer minimal 1
            'unit' => 'required|string|max:50', // VARCHAR dengan maksimal 50 karakter
            'description' => 'required|string', // TEXT
            'file_name' => 'nullable|image|mimes:jpg,png,jpeg|max:1024' // Gambar dengan format jpg/png/jpeg maksimal 1MB (1024KB)
        ], [
            'asset_code.required' => 'Kode aset wajib diisi.',
            'asset_code.unique' => 'Kode aset ini sudah terdaftar di sistem, mohon load ulang kode.',
            'asset_code.regex' => 'Format kode aset tidak valid.',

            'procurement.required' => 'Tahun pengadaan wajib diisi.',
            'procurement.date_format' => 'Format tahun pengadaan tidak valid (contoh: 2025).',

            'acquisition.required' => 'Tanggal perolehan wajib diisi.',
            'acquisition.date' => 'Format tanggal perolehan tidak valid.',

            'type.required' => 'Jenis aset wajib diisi.',
            'type.string' => 'Jenis aset harus berupa teks.',
            'type.max' => 'Jenis aset maksimal 100 karakter.',

            'asset_identity.required' => 'Identitas aset wajib diisi.',
            'asset_identity.string' => 'Identitas aset harus berupa teks.',

            'qty.required' => 'Kuantitas wajib diisi.',
            'qty.integer' => 'Kuantitas harus berupa angka bulat.',
            'qty.min' => 'Kuantitas minimal 0.',

            'unit.required' => 'Satuan wajib diisi.',
            'unit.string' => 'Satuan harus berupa teks.',
            'unit.max' => 'Satuan maksimal 50 karakter.',

            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            // 'file_name.required' => 'File gambar wajib diunggah.',
            'file_name.image' => 'File harus berupa gambar.',
            'file_name.mimes' => 'Format gambar yang diperbolehkan: jpg, png, jpeg.',
            'file_name.max' => 'Ukuran gambar maksimal 1MB.'
        ]);

        try {

            DB::beginTransaction();

            $exists = Asset::where('asset_code', $validated['asset_code'])
                ->where('id', '!=', $id)
                ->lockForUpdate()
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Kode aset ini sudah terdaftar di sistem, mohon load ulang kode.',
                    'errors' => [
                        'asset_code' => [
                            'Kode aset ini sudah terdaftar di sistem, mohon load ulang kode.'
                        ]
                    ]
                ], 422);
            }

            $asset = Asset::findOrFail($id);

            $location = Location::findOrFail(1)->code;
            $locationCode = $location . '.1.' . $validated['procurement'];

            $updateData = [
                'asset_code' => $validated['asset_code'],
                'location_code' => $locationCode,
                'procurement' => $validated['procurement'],
                'acquisition' => Carbon::parse($validated['acquisition']),
                'type' => $validated['type'],
                'asset_identity' => $validated['asset_identity'],
                'qty' => $validated['qty'],
                'unit' => $validated['unit'],
                'description' => $validated['description'],
                'updated_at' => Carbon::now(),
            ];

            if ($request->hasFile('file_name')) {
                // Delete old picture if exists
                if ($asset->file_name) {
                    Storage::delete('asset_pictures/' . $asset->file_name);
                }

                $file = $request->file('file_name');
                $extension = $file->getClientOriginalExtension();
                $filename = 'asset-' . time() . '-' . uniqid() . '.' . $extension;

                // Simpan file dengan nama baru
                $file->storeAs('asset_pictures', $filename);

                // Simpan hanya nama file
                $updateData['file_name'] = $filename;
            }

            $asset->update($updateData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui aset'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Gagal memperbarui aset " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui aset'
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $asset = Asset::findOrFail($id);
        $asset->status = $status;
        $asset->save();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil ' . ($status ? 'mengaktifkan' : 'menonaktifkan') . ' asset ' . $asset->asset_code
        ]);
    }

    public function asset_picture($folder, $filename)
    {
        $path = storage_path("app/private/$folder/$filename");

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function printPdf(Request $request)
    {
        $assets = $request->input('assets');
        $customPaper = [0, 0, 170.08, 56.69];

        $pdf = PDF::loadView('export.pdf.barcode-assets', ['assets' => $assets])
            ->setPaper($customPaper, 'portrait');

        return $pdf->stream('export.pdf.barcode-assets'); // langsung tampilkan di browser
    }
}
