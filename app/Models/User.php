<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   protected $fillable = [
      'name',
    'email',
    'password',
    'role_id',
    'failed_login_attempts',
    'is_blocked',
    'blocked_at',
    'last_login_ip',
'last_login_at',
'blocked_reason',
];

protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
        'blocked_at' => 'datetime',
        'last_login_at' => 'datetime',
'blocked_at' => 'datetime',
'is_blocked' => 'boolean',
    ];
}

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($roleName)
    {
        return optional($this->role)->name === $roleName;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
public function canAccess($permissionName)
{
    return $this->role?->permissions?->contains('name', $permissionName) ?? false;
}
// notification

public function notifications()
{
    return $this->hasMany(\App\Models\Notification::class);
}

public function unreadNotifications()
{
    return $this->hasMany(\App\Models\Notification::class)
        ->where('is_read', false);
}

}