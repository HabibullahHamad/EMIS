<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FocalPointIntroduction extends Model
{
    use HasFactory;

    protected $table = 'focal_point_introductions';

    protected $fillable = [
        'budget_entity_id',
        'inbox_id',
        'letter_number',
        'letter_date',
        'received_date',
        'subject',
        'number_of_nominees',
        'attachment',
        'status',
        'reviewed_by',
        'reviewed_at',
        'approval_notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'letter_date' => 'date',
            'received_date' => 'date',
            'reviewed_at' => 'datetime',
            'number_of_nominees' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function budgetEntity(): BelongsTo
    {
        return $this->belongsTo(
            BudgetEntity::class,
            'budget_entity_id'
        );
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function focalPoints(): HasMany
    {
        return $this->hasMany(
            FocalPoint::class,
            'introduction_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return ucfirst(
            str_replace('_', ' ', $this->status)
        );
    }
}