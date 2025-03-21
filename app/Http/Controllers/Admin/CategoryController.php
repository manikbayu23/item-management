<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Scope;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Scope::all();
        return view('pages.admin.master-scopes', compact('data'));
    }

    public function lastCode()
    {
        try {
            $code = Group::latest('code')->pluck('code')->first();
            if ($code) {
                $code = (intval($code) + 1) . '.';
            } else {
                $code = '1.';
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
                'unique:groups,code'
            ],
            'description' => 'required',
            'period' => 'required',
            'idGroup' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
            'IdGroup' => 'Golongan wajib dipilig.'
        ]);

        Group::create([
            'code' => $request->input('code'),
            'description' => strtoupper($request->input('description')),
            'period' => $request->input('period'),
            'group_id' => $request->input('group_id')
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah golongan.');
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
                'regex:/^\d+\.$/',
                Rule::unique('groups', 'code')->ignore($id)
            ],
            'description' => 'required',
            'period' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.regex' => 'Format kode tidak valid.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
            'period' => 'Periode wajib diisi.',
        ]);

        $group = Group::findOrFail($id);
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
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus golongan');
    }
}
