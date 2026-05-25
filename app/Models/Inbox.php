<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'inbox';

    protected $fillable = [
        'letter_no',
        'order_number',
        'subject',
        'sender',
        'receiver',
        'received_date',
        'summary',
        'priority',
        'status',
        'attachment',
        'attachment_names',
    ];

    protected $casts = [
        'attachment_names' => 'array',
    ];
}