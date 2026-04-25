<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'doc_number',
        'doc_date',
        'receiver',
        'subject',
        'description',
        'attachment'
    ];
    public function workflowTransactions()
{
    return $this->morphMany(\App\Models\WorkflowTransaction::class, 'workflowable');
}
}