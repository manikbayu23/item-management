<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'division_id', 'slug', 'capacity', 'description'];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function userrooms()
    {
        return $this->hasMany(UserRoom::class);
    }
}
