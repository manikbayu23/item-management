<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'code', 'description', 'period'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
