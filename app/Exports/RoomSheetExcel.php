<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RoomSheetExcel implements FromView, WithDrawings
{
    protected $room;
    public function __construct($room)
    {
        $this->room = $room;
    }
    public function view(): View
    {
        return view('exports.room-inventory', [
            'room' => $this->room,
            'user' => Auth::user()
        ]);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath(public_path('assets/img/panca-mahottama.png')); // Pastikan file ada
        $drawing->setHeight(120);
        $drawing->setWidth(120);
        $drawing->setCoordinates('A2');

        return [$drawing];
    }

    public function title(): string
    {
        return $this->room->name; // Nama sheet = nama ruangan
    }
}
