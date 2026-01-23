<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\User;

 //
    class Task extends Model
{
    protected $fillable = [
        'task_code',
        'title',
        'description',
        'assigned_to',
        'assigned_by',
        'priority',
        'status',
        'due_date'
    ];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}

