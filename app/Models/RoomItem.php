<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomItem extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'item_id', 'qty'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function conditions()
    {
        return $this->hasMany(ItemCondition::class, 'room_item_id');
    }
    public function borrowings()
    {
        return $this->hasMany(Borrow::class, 'room_item_id');
    }

}
