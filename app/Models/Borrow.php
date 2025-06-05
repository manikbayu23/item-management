<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrowings';
    protected $fillable = ['room_item_id', 'user_id', 'admin_id', 'qty', 'status', 'start_date', 'end_date', 'actual_return_date', 'notes', 'created_by', 'updated_by'];

    public function roomitem()
    {
        return $this->belongsTo(RoomItem::class, 'room_item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
