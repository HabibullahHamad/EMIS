<?php

// app/Models/Document.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'document_no',
        'subject',
        'sender',
        'receiver',
        'type',
        'status',
        'assigned_to',
        'deadline'
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
