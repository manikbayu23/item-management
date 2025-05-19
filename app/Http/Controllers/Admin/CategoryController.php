<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Group;
use App\Models\Scope;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{ /**
  * Display a listing of the resource.
  */
    public function index()
    {
        $categories = Category::all();
        return view(
            'pages.admin.master-categories',
            compact(['categories'])
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'unique:categories,name'
            ],
            'description' => 'required',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
        ]);

        Category::create([
            'name' => Str::upper($data['name']),
            'description' => $data['description']
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah kategori.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('categories', 'name')->ignore($id)
            ],
            'description' => 'required',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kode ini sudah terdaftar di sistem.',
            'description' => 'Deskripsi wajib diisi.',
        ]);

        $category = Category::findOrFail($id);
        $category->name = Str::upper($data['name']);
        $category->description = $data['description'];
        $category->updated_at = Carbon::now();
        $category->save();

        return redirect()->back()->with('success', 'Berhasil memperbarui kategori.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus kategori ' . $category->name);
    }
}
