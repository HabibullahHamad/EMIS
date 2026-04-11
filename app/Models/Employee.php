<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Employee extends Model
{
  protected $fillable = [
    'user_id',
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
    public function user()
{
    return $this->belongsTo(User::class);
}
public function tasks()
{
    return $this->hasMany(Task::class, 'employee_id');
}
}