<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task_code',
        'title',
        'description',
        'employee_id',
        'source_type',
        'source_reference',
        'priority',
        'status',
        'deadline',
        'assigned_by',
        'remarks',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function tasks()
{
    return $this->hasMany(Task::class, 'employee_id');
}
public function workflowTransactions()
{
    return $this->morphMany(\App\Models\WorkflowTransaction::class, 'workflowable');
}
}
