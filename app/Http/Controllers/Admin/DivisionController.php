<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function index()
    {
        $data = Division::orderBy('code', 'asc')->get();
        $departments = Department::orderBy('code', 'asc')->get();
        return view('pages.admin.master-divisions', compact(['data', 'departments']));
    }

    public function store(Request $request)
    {
        $request->merge([
            'code' => strtoupper(string: $request->input('code'))
        ]);
        $request->validate([
            'code' => [
                'required',
                'unique:divisions,code'
            ],
            'name' => 'required',
            'idDepartment' => 'required'
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'name' => 'Nama wajib diisi.',
            'idDepartment' => 'Departemen wajib dipilih.',
        ]);

        Division::create([
            'department_id' => $request->input('idDepartment'),
            'code' => $request->input('code'),
            'name' => strtoupper($request->input('name')),
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah Divisi.');
    }

    public function update(Request $request, string $id)
    {
        $request->merge([
            'code' => strtoupper(string: $request->input('code'))
        ]);
        $request->validate([
            'code' => [
                'required',
                Rule::unique('divisions', 'code')->ignore($id)
            ],
            'name' => 'required',
            'idDepartment' => 'required'

        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'name' => 'Nama wajib diisi.',
            'idDepartment' => 'Departemen wajib dipilih.',
        ]);

        $division = Division::findOrFail($id);
        $division->department_id = $request->input('idDepartment');
        $division->code = $request->input('code');
        $division->name = strtoupper($request->input('name'));
        $division->updated_at = Carbon::now();
        $division->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui divisi.');
    }

    public function destroy(string $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus divisi.');
    }
}
