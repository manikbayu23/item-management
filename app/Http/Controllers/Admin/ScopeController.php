<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Scope;

class ScopeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Scope::orderBy('code', 'asc')->get();
        $groups = Group::orderBy('code', 'asc')->get();
        return view(
            'pages.admin.master-scopes',
            [
                'data' => $data,
                'groups' => $groups
            ]
        );
    }

    public function lastCode(Request $request)
    {
        try {
            $id = $request->input('idGroup');
            $codeGroup = Group::where('id', $id)->pluck('code')->first();

            // Ambil kode terakhir dari Scope yang memiliki prefix sesuai dengan codeGroup
            $codeScope = Scope::where('code', 'like', "{$codeGroup}%")
                ->where('group_id', $id)
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
        $request->merge([
            'code' => rtrim($request->input('code'), '.') . '.'
        ]);
        $request->validate([
            'code' => [
                'required',
                'regex:/^\d+(\.\d+)*\.$/',
                'unique:scopes,code'
            ],
            'description' => 'required',
            'period' => 'required',
            'idGroup' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
            'idGroup' => 'Golongan wajib dipilih.'
        ]);


        Scope::create([
            'code' => $request->input('code'),
            'description' => strtoupper($request->input('description')),
            'period' => $request->input('period'),
            'group_id' => $request->input('idGroup')
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah golongan.');
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
                Rule::unique('scopes', 'code')->ignore($id)
            ],
            'description' => 'required',
            'period' => 'required',
            'idGroup' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.regex' => 'Format kode tidak valid.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
            'idGroup' => 'Golongan wajib dipilih.'
        ]);

        $group = Scope::findOrFail($id);
        $group->group_id = $request->input('idGroup');
        $group->code = $request->input('code');
        $group->description = strtoupper($request->input('description'));
        $group->period = $request->input('period');
        $group->updated_at = Carbon::now();
        $group->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui golongan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Scope::findOrFail($id);
        $group->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus bidang');
    }
}
