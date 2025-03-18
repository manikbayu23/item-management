<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'description', 'period'];

    public function scopes()
    {
        return $this->hasMany(Scope::class);
    }
}
