<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'status', 'room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
