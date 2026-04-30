<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'priority',
        'related_type',
        'related_id',
        'is_read',
        'read_at'
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
