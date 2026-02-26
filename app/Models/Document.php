<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

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

    protected $casts = [
        'deadline' => 'date',
    ];
}