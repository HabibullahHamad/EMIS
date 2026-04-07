<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  protected $fillable = [
    'employee_code',
    'first_name',
    'last_name',
    'full_name',
    'email',
    'phone',
    'photo',
    'status',
];
    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-user.png');
    }
}