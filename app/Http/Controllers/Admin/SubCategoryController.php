<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Carbon\Carbon;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Scope;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{ /**
  * Display a listing of the resource.
  */
    public function index()
    {
        $data = SubCategory::orderBy('code', 'asc')->get();
        $categories = Category::orderBy('code', 'asc')->get();
        return view(
            'pages.admin.master-sub-category',
            [
                'data' => $data,
                'categories' => $categories
            ]
        );
    }

    public function lastCode(Request $request)
    {
        try {
            $id = $request->input('idCategory');
            $codeGroup = Category::where('id', $id)->pluck('code')->first();

            // Ambil kode terakhir dari Scope yang memiliki prefix sesuai dengan codeGroup
            $codeScope = SubCategory::where('code', 'like', "{$codeGroup}%")
                ->where('category_id', $id)
                ->latest('code')
                ->pluck('code')
                ->first();


            if ($codeScope) {
                // Ambil dua angka terakhir setelah titik terakhir
                preg_match('/\.(\d+)\.$/', $codeScope, $matches);

                // Ambil angka terakhir, jika ada
                $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;

                // Tambahkan 1 dan pastikan format tetap '00', '01', '02', ...
                $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

                $code = "{$codeGroup}{$newNumber}";
            } else {
                $code = "{$codeGroup}00";
            }

            return response()->json(['success' => 'true', 'code' => $code]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'code' => rtrim($request->input('code'), '.') . '.'
        ]);
        $request->validate([
            'code' => [
                'required',
                'regex:/^\d+(\.\d+)*\.$/',
                'unique:sub_categories,code'
            ],
            'description' => 'required',
            'period' => 'required',
            'idCategory' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
            'idCategory' => 'Kelompok wajib dipilih.'
        ]);

        SubCategory::create([
            'code' => $request->input('code'),
            'description' => strtoupper($request->input('description')),
            'period' => $request->input('period'),
            'category_id' => $request->input('idCategory')
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah sub kelompok.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'code' => rtrim($request->input('code'), '.') . '.'
        ]);
        $request->validate([
            'code' => [
                'required',
                'regex:/^\d+(\.\d+)*\.$/',
                Rule::unique('sub_categories', 'code')->ignore($id)
            ],
            'description' => 'required',
            'period' => 'required',
            'idCategory' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.regex' => 'Format kode tidak valid.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
            'idCategory' => 'Kelompok wajib dipilih.'
        ]);

        $group = SubCategory::findOrFail($id);
        $group->category_id = $request->input('idCategory');
        $group->code = $request->input('code');
        $group->description = strtoupper($request->input('description'));
        $group->period = $request->input('period');
        $group->updated_at = Carbon::now();
        $group->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui sub kelompok.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = SubCategory::findOrFail($id);
        $group->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus sub kelompok');
    }
}
