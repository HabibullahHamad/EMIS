<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutgoingDocument extends Model
{
    use HasFactory;

    protected $table = 'outgoingd'; // 👈 your real table name

    protected $fillable = [
        'doc_number',
        'subject',
        'sender',
        'receiver',
        'doc_date',
        'priority',
        'assigned_to',
        'department',
        'description',
        'attachment'
    ];
    public function workflowTransactions()
{
    return $this->morphMany(\App\Models\WorkflowTransaction::class, 'workflowable');
}
}