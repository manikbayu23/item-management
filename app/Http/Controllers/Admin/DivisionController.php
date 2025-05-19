<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::all();
        return view('pages.admin.master-divisions', compact(['divisions']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'unique:divisions,name'
            ],
            'description' => 'required',
        ], [
            'name.required' => 'Nama divisi wajib diisi.',
            'name.unique' => 'Nama divisi ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
        ]);

        Division::create([
            'name' => Str::upper($data['name']),
            'description' => $data['description'],
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah divisi.');
    }

    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('divisions', 'name')->ignore($id)
            ],
            'description' => 'required'

        ], [
            'name.required' => 'Nama divisi wajib diisi.',
            'name.unique' => 'Nama divisi ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib dipilih.',
        ]);

        $division = Division::findOrFail($id);
        $division->name = Str::upper($data['name']);
        $division->description = $data['description'];
        $division->updated_at = Carbon::now();
        $division->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui divisi.');
    }

    public function destroy(string $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus divisi ' . $division->name);
    }
}
