<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Carbon\Carbon;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Scope;

class CategoryController extends Controller
{ /**
  * Display a listing of the resource.
  */
    public function index()
    {
        $data = Category::all();
        $scopes = Scope::all();
        return view(
            'pages.admin.master-category',
            [
                'data' => $data,
                'scopes' => $scopes
            ]
        );
    }

    public function lastCode(Request $request)
    {
        try {
            $id = $request->input('idScope');
            $codeGroup = Scope::where('id', $id)->pluck('code')->first();

            // Ambil kode terakhir dari Scope yang memiliki prefix sesuai dengan codeGroup
            $codeScope = Category::where('code', 'like', "{$codeGroup}%")
                ->where('scope_id', $id)
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

                $code = "{$codeGroup}{$newNumber}.";
            } else {
                $code = "{$codeGroup}00.";
            }

            return response()->json(['success' => 'true', 'code' => $code]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                'regex:/^\d+(\.\d+)*\.$/',
                'unique:categories,code'
            ],
            'description' => 'required',
            'period' => 'required',
            'idScope' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
            'idScope' => 'Bidang wajib dipilih.'
        ]);


        Category::create([
            'code' => $request->input('code'),
            'description' => strtoupper($request->input('description')),
            'period' => $request->input('period'),
            'scope_id' => $request->input('idScope')
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah kelompok.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'code' => [
                'required',
                'regex:/^\d+(\.\d+)*\.$/',
                Rule::unique('categories', 'code')->ignore($id)
            ],
            'description' => 'required',
            'period' => 'required',
            'idScope' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.regex' => 'Format kode tidak valid.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
            'idScope' => 'Bidang wajib dipilih.'
        ]);

        $group = Category::findOrFail($id);
        $group->scope_id = $request->input('idScope');
        $group->code = $request->input('code');
        $group->description = strtoupper($request->input('description'));
        $group->period = $request->input('period');
        $group->updated_at = Carbon::now();
        $group->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui kelompok.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Category::findOrFail($id);
        $group->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus kelompok');
    }
}
