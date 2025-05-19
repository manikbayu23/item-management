<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        return view('pages.admin.master-positions', compact(['positions']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'unique:positions,name'
            ],
            'description' => 'required',
        ], [
            'name.required' => 'Nama jabatan wajib diisi.',
            'name.unique' => 'Nama jabatan ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
        ]);

        Position::create([
            'name' => Str::upper($data['name']),
            'description' => $data['description'],
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah jabatan.');
    }

    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('positions', 'name')->ignore($id)
            ],
            'description' => 'required'

        ], [
            'name.required' => 'Nama jabatan wajib diisi.',
            'name.unique' => 'Nama jabatan ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib dipilih.',
        ]);

        $position = Position::findOrFail($id);
        $position->name = Str::upper($data['name']);
        $position->description = $data['description'];
        $position->updated_at = Carbon::now();
        $position->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui jabatan.');
    }

    public function destroy(string $id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus jabatan ' . $position->name);
    }
}
