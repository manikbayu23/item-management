<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssetSubmissionController extends Controller
{
    public function index()
    {
        return view('pages.user.history');
    }
    public function form()
    {
        $assets = collect([
            ['id' => 1, 'code' => '0.0.0.0.1', 'name' => 'Printer']
        ]);

        for ($i = 2; $i <= 500; $i++) {
            $assets->push(['id' => $i, 'code' => '0.0.0.0.' . $i, 'name' => 'Printer' . $i]);
        }

        $assets = $assets->map(fn($item) => (object) $item)->toArray();
        return view('pages.user.form-submission', [
            'assets' => $assets
        ]);
    }
}
