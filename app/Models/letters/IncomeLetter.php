<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeLetter extends Model
{
    protected $fillable = ['letter_no', 'sender', 'subject', 'received_date', 'description'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}



