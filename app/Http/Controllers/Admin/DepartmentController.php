<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        $data = Department::orderBy('code', 'asc')->get();
        return view('pages.admin.master-departments', compact('data'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'code' => strtoupper(string: $request->input('code'))
        ]);
        $request->validate([
            'code' => [
                'required',
                'unique:departments,code'
            ],
            'name' => 'required',
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'name' => 'Nama wajib diisi.',
        ]);

        Department::create([
            'code' => $request->input('code'),
            'name' => strtoupper($request->input('name')),
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah Departemen.');
    }

    public function update(Request $request, string $id)
    {
        $request->merge([
            'code' => strtoupper(string: $request->input('code'))
        ]);
        $request->validate([
            'code' => [
                'required',
                Rule::unique('departments', 'code')->ignore($id)
            ],
            'name' => 'required',
        ], [
            'code.required' => 'Kode wajib diisi.',
            'code.unique' => 'Kode ini sudah terdaftar di sistem.',
            'name' => 'Nama wajib diisi.',
        ]);

        $department = Department::findOrFail($id);
        $department->code = $request->input('code');
        $department->name = strtoupper($request->input('name'));
        $department->updated_at = Carbon::now();
        $department->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui departemen.');
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus departemen.');
    }
}
