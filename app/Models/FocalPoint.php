<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FocalPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_entity_id',
        'introduction_id',
        'user_id',
        'focal_point_code',

        'full_name_en',
        'full_name_ps',
        'full_name_fa',
        'father_name',
        'grandfather_name',
        'employee_number',
        'national_id',

        'job_title',
        'directorate',
        'department',
        'official_position',

        'phone',
        'alternate_phone',
        'email',

        'photo_path',
        'signature_path',

        'appointment_date',
        'valid_from',
        'valid_until',

        'status',
        'remarks',

        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'valid_from' => 'date',
            'valid_until' => 'date',
            'approved_at' => 'datetime',
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

    public function introduction(): BelongsTo
    {
        return $this->belongsTo(
            FocalPointIntroduction::class,
            'introduction_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function cards(): HasMany
    {
        return $this->hasMany(
            FocalPointCard::class,
            'focal_point_id'
        )->latest('id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute(): string
    {
        return match (app()->getLocale()) {
            'ps' => $this->full_name_ps
                ?: $this->full_name_fa
                ?: $this->full_name_en
                ?: $this->focal_point_code,

            'fa' => $this->full_name_fa
                ?: $this->full_name_ps
                ?: $this->full_name_en
                ?: $this->focal_point_code,

            default => $this->full_name_en
                ?: $this->full_name_fa
                ?: $this->full_name_ps
                ?: $this->focal_point_code,
        };
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === 'active'
            && $this->approved_at !== null;
    }

    public function getCurrentCardAttribute(): ?FocalPointCard
    {
        if ($this->relationLoaded('cards')) {
            return $this->cards->sortByDesc('id')->first();
        }

        return $this->cards()
            ->latest('id')
            ->first();
    }
}