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
        'department_id',
        'status',
        'type',
        'asset_identity',
        'qty',
        'unit',
        'description',
        'file_name'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
