<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function index()
    {
        $data = collect([
            [
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
            [
                'code' => '00.00.00.00',
                'name' => 'Traktor'
            ],
        ]);
        $data = $data->map(fn($item) => (object) $item)->toArray();
        return view('pages.admin.assets', compact(['data']));
    }

    public function store()
    {

    }

    public function update()
    {

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
