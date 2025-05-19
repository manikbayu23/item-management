<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCondition extends Model
{
    use HasFactory;

    protected $fillable = ['room_item_id', 'condition', 'qty'];
}
