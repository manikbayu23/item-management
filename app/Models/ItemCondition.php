<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCondition extends Model
{
    use HasFactory;

    protected $fillable = ['room_item_id', 'condition', 'qty'];

    public function roomitem()
    {
        return $this->belongsTo(RoomItem::class, 'room_item_id');
    }
}
