<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Division;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $divisions = Division::all();
        return view('pages.admin.master-rooms', compact(['rooms', 'divisions']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'unique:rooms,name'
            ],
            'division' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Nama ruangan wajib diisi.',
            'name.unique' => 'Nama ruangan ini sudah terdaftar di sistem.',
            'division' => 'Divisi wajib dipilih.',
            'description' => 'Deskripsi wajib diisi.',
        ]);

        Room::create([
            'name' => Str::upper($data['name']),
            'division_id' => $data['division'],
            'slug' => Str::slug(Str::lower(value: $data['name'])),
            'capacity' => 10,
            'description' => $data['description'],
        ]);
        return redirect()->back()->with('success', 'Berhasil menambah Ruangan.');
    }

    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('divisions', 'name')->ignore($id)
            ],
            'division' => 'required',
            'description' => 'required'

        ], [
            'name.required' => 'Nama ruangan wajib diisi.',
            'name.unique' => 'Nama ruangan ini sudah terdaftar di sistem.',
            'division' => 'Divisi wajib dipilih.',
            'description' => 'Deskripsi wajib dipilih.',
        ]);

        $room = Room::findOrFail($id);
        $room->name = Str::upper($data['name']);
        $room->division_id = $data['division'];
        $room->slug = Str::slug(title: Str::lower($data['name']));
        $room->description = $data['description'];
        $room->updated_at = Carbon::now();
        $room->save();
        return redirect()->back()->with('success', 'Berhasil memperbarui ruangan.');
    }

    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus ' . $room->name);
    }

    public function print(Request $request)
    {
        $pdf = PDF::loadView('export.pdf.room-qr', ['data' => $request->params])
            ->setPaper('A4', 'potrait');

        return $pdf->stream('export.pdf.barcode-assets'); // langsung tampilkan di browser
    }
}
