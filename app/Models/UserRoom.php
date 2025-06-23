<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRoom extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'room_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
