<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RoomInventoryExcel implements WithMultipleSheets
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->data as $key => $row) {
            $sheets[] = new RoomSheetExcel($row);
        }

        return $sheets;
    }
}
