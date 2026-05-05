<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'title',
        'subject',
        'organization',
        'type',
        'status',
        'received_date',
        'due_date',
        'completed_at',
        'created_by',
        'assigned_to',
        'file_path',
        'priority',
        'remarks'
    ];

    protected $casts = [
        'received_date' => 'date',
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Creator (Executive user)
    // app/Models/Document.php

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function assignedUser()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

    // Assigned user (department/user)
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Document history (tracking)
    public function histories()
    {
        return $this->hasMany(DocumentHistory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (VERY USEFUL)
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDelayed($query)
    {
        return $query->where('due_date', '<', now())
                     ->where('status', '!=', 'completed');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isDelayed()
    {
        return $this->due_date && now()->gt($this->due_date) && $this->status !== 'completed';
    }
}