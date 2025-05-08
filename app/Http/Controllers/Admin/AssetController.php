<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Asset;
use App\Models\Location;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function index()
    {
        $data = collect([
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
        ]);
        $data = $data->map(fn($item) => (object) $item)->toArray();
        return view('pages.admin.assets', compact(['data']));
    }

    public function data(Request $request) {}

    public function lastCode(Request $request)
    {
        try {
            $id = $request->input('idSubCategory');
            $codeSubCategory = SubCategory::where('id', $id)->pluck('code')->first();

            // // Ambil kode terakhir dari Scope yang memiliki prefix sesuai dengan codeGroup
            // $codeScope = Scope::where('code', 'like', "{$codeGroup}%")
            //     ->where('group_id', $id)
            //     ->latest('code')
            //     ->pluck('code')
            //     ->first();

            $codeAsset = '1.00.00.00.01';

            if ($codeAsset) {
                // Ambil dua angka terakhir setelah titik terakhir
                preg_match('/\.(\d+)$/', $codeAsset, $matches);

                // Ambil angka terakhir, jika ada
                $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;


                // Tambahkan 1 dan pastikan format tetap '00', '01', '02', ...
                $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

                $code = "{$codeSubCategory}{$newNumber}";
            } else {
                $code = "{$codeSubCategory}00";
            }

            return response()->json(['success' => 'true', 'code' => $code]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    public function create()
    {
        $subCategories = SubCategory::all();
        return view('pages.admin.add-asset', compact(['subCategories']));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'asset_code' => [
                    'required',
                    'regex:/^\d+(\.\d+)*\.$/',
                    'unique:assets,asset_code'
                ],
                'procurement' => 'required|date_format:Y', // Tahun saja (contoh: 2023)
                'acquisition' => 'required|date', // Format tanggal (YYYY-MM-DD)
                'type' => 'required|string|max:100', // VARCHAR dengan maksimal 255 karakter

                'asset_identity' => 'required|string', // TEXT
                'qty' => 'required|integer|min:0', // Integer minimal 1
                'unit' => 'required|string|max:50', // VARCHAR dengan maksimal 50 karakter
                'description' => 'required|string', // TEXT
                'filename' => 'required|image|mimes:jpg,png,jpeg|max:1024' // Gambar dengan format jpg/png/jpeg maksimal 1MB (1024KB)
            ], [
                'asset_code.required' => 'Kode aset wajib diisi.',
                'asset_code.unique' => 'Kode aset ini sudah terdaftar di sistem.',
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

                'file_name.required' => 'File gambar wajib diunggah.',
                'file_name.image' => 'File harus berupa gambar.',
                'file_name.mimes' => 'Format gambar yang diperbolehkan: jpg, png, jpeg.',
                'file_name.max' => 'Ukuran gambar maksimal 1MB.'
            ]);

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
                $validated['file_ename'] = $filename; // Sesuaikan dengan nama field di form ('filename' bukan 'pr
            }

            Asset::create([
                'asset_code' => $validated['asset_code'],
                'location_code' =>  Location::findOrFail(1)->code,
                'procurement' => $validated['procurement'],
                'acquisition' => $validated['acquisition'],
                'program_id' => $validated['program_id'],
                'type' => $validated['type'],
                'asset_identity' => $validated['asset_identity'],
                'qty' => $validated['qty'],
                'unit' => $validated['unit'],
                'description' => $validated['description'],
                'file_name' => $validated['file_name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan aset'
            ]);
        } catch (\Throwable $th) {
            Log::error("Gagal menambahkan aset " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan aset'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $asset = Asset::findOrFail($id);

            $validated = $request->validate([
                'asset_code' => [
                    'required',
                    'regex:/^\d+(\.\d+)*\.$/',
                    Rule::unique('assets')->ignore($id)
                ],
                'procurement' => 'required|date_format:Y', // Tahun saja (contoh: 2023)
                'acquisition' => 'required|date', // Format tanggal (YYYY-MM-DD)
                'type' => 'required|string|max:100', // VARCHAR dengan maksimal 255 karakter

                'asset_identity' => 'required|string', // TEXT
                'qty' => 'required|integer|min:0', // Integer minimal 1
                'unit' => 'required|string|max:50', // VARCHAR dengan maksimal 50 karakter
                'description' => 'required|string', // TEXT
                'filename' => 'required|image|mimes:jpg,png,jpeg|max:1024' // Gambar dengan format jpg/png/jpeg maksimal 1MB (1024KB)
            ], [
                'asset_code.required' => 'Kode aset wajib diisi.',
                'asset_code.unique' => 'Kode aset ini sudah terdaftar di sistem.',
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

                'file_name.required' => 'File gambar wajib diunggah.',
                'file_name.image' => 'File harus berupa gambar.',
                'file_name.mimes' => 'Format gambar yang diperbolehkan: jpg, png, jpeg.',
                'file_name.max' => 'Ukuran gambar maksimal 1MB.'
            ]);

            $updateData = [
                'asset_code' => $validated['asset_code'],
                'procurement' => $validated['procurement'],
                'acquisition' => $validated['acquisition'],
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

            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui aset'
            ]);
        } catch (\Throwable $th) {
            Log::error("Gagal memperbarui aset " . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui aset'
            ], 500);
        }
    }

    public function updateStatus($id, Request $request)
    {
        $status = $request->input('status');
        return redirect()->back()->with('success', 'Berhasil ' . ($status ? 'mengaktifkan' : 'menonaktifkan') . ' Asset');
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
