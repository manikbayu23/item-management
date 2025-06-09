<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrowings';
    protected $fillable = ['room_item_id', 'user_id', 'admin_id', 'sq_borrow_number', 'borrow_number', 'qty', 'status', 'start_date', 'end_date', 'actual_return_date', 'notes', 'admin_notes', 'created_by', 'updated_by'];

    public function room_item()
    {
        return $this->belongsTo(RoomItem::class, 'room_item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function borrowing_logs()
    {
        return $this->hasMany(BorrowingLog::class, 'borrowing_id');
    }
}
