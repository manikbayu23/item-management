<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'user_id', 'admin_id', 'type', 'status', 'start_date', 'end_date', 'actual_return_date', 'notes'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
