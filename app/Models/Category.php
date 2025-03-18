<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['scope_id', 'code', 'description', 'period'];

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
