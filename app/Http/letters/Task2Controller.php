<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['income_letter_id', 'title', 'assigned_to', 'status', 'due_date', 'created_by'];

    public function letter()
    {
        return $this->belongsTo(IncomeLetter::class, 'income_letter_id');
    }

    public function assignedToUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

