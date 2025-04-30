<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;

class AssetController extends Controller
{
    public function index()
    {
        $data = collect([
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'id' => 1,
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
        ]);
        $data = $data->map(fn($item) => (object) $item)->toArray();
        return view('pages.admin.assets', compact(['data']));
    }

    public function lastCode(Request $request)
    {
        try {
            $province = '51';
            $regency = '03';
            $subdistrict = '05';
            $village = '2002';
            $id = $request->input('idSubCategory');
            $codeSubCategory = SubCategory::where('id', $id)->pluck('code')->first();

            // // Ambil kode terakhir dari Scope yang memiliki prefix sesuai dengan codeGroup
            // $codeScope = Scope::where('code', 'like', "{$codeGroup}%")
            //     ->where('group_id', $id)
            //     ->latest('code')
            //     ->pluck('code')
            //     ->first();

            $codeAsset = '1.00.00.00.01';

            if ($codeAsset) {
                // Ambil dua angka terakhir setelah titik terakhir
                preg_match('/\.(\d+)$/', $codeAsset, $matches);

                // Ambil angka terakhir, jika ada
                $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;


                // Tambahkan 1 dan pastikan format tetap '00', '01', '02', ...
                $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

                $code = "{$codeSubCategory}{$newNumber}";
            } else {
                $code = "{$codeSubCategory}00";
            }

            return response()->json(['success' => 'true', 'code' => $code]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    public function create()
    {
        $subCategories = SubCategory::all();
        return view('pages.admin.add-asset', compact(['subCategories']));
    }

    public function store()
    {

    }

    public function update()
    {

    }
    public function updateStatus($id, Request $request)
    {
        $status = $request->input('status');
        return redirect()->back()->with('success', 'Berhasil ' . ($status ? 'mengaktifkan' : 'menonaktifkan') . ' Asset');
    }

    public function printPdf(Request $request)
    {
        $assets = $request->input('assets');
        $customPaper = [0, 0, 170.08, 56.69];

        $pdf = PDF::loadView('export.pdf.barcode-assets', ['assets' => $assets])
            ->setPaper($customPaper, 'portrait');

        return $pdf->stream('export.pdf.barcode-assets'); // langsung tampilkan di browser
    }
}
