<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'inbox';

    protected $fillable = [
        'letter_no', 'subject', 'sender', 'receiver',
        'received_date', 'summary', 'attachment',
        'priority', 'status', 'assigned_to'
    ];
}



