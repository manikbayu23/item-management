<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'status', 'category_id', 'unit', 'brand', 'notes', 'created_by', 'updated_by'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function roomitems()
    {
        return $this->hasMany(RoomItem::class);
    }
}
