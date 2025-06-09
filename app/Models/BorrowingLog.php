<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingLog extends Model
{
    protected $table = 'borrowing_log';
    protected $fillable = ['borrowing_id', 'status', 'admin_id', 'user_id', 'notes'];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class, 'borrowing_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }


}
