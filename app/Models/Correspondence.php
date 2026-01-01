<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correspondence extends Model
{
    protected $fillable = [
        'sender',
        'subject',
        'status',
        'assigned_to',
        'deadline',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
