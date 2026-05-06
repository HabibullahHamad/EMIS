<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
   protected $fillable = [
    'document_number',
    'title',
    'subject',
    'organization',
    'type', // ✅ VERY IMPORTANT
    'status',
    'received_date',
    'due_date',
    'created_by',
    'file_path',
    'priority',
    'remarks'
];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}