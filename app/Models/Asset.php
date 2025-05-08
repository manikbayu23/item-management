<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_code',
        'location_code',
        'procurement',
        'acquisition',
        'program_id',
        'type',
        'asset_identity',
        'qty',
        'unit',
        'description',
        'file_name'
    ];
}
