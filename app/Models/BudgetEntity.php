<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetEntity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'budget_entities';

    protected $fillable = [
        'entity_code',
        'name_en',
        'name_ps',
        'name_fa',
        'short_name',
        'entity_type',
        'parent_id',
        'phone',
        'email',
        'address',
        'status',
        'description',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            BudgetEntity::class,
            'parent_id'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            BudgetEntity::class,
            'parent_id'
        )->orderBy('name_en')
         ->orderBy('name_fa');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function introductions(): HasMany
    {
        return $this->hasMany(
            FocalPointIntroduction::class,
            'budget_entity_id'
        );
    }

    public function focalPoints(): HasMany
    {
        return $this->hasMany(
            FocalPoint::class,
            'budget_entity_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDisplayNameAttribute(): string
    {
        return match (app()->getLocale()) {
            'ps' => $this->name_ps
                ?: $this->name_fa
                ?: $this->name_en
                ?: $this->entity_code,

            'fa' => $this->name_fa
                ?: $this->name_ps
                ?: $this->name_en
                ?: $this->entity_code,

            default => $this->name_en
                ?: $this->name_fa
                ?: $this->name_ps
                ?: $this->entity_code,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status
            ? 'Active'
            : 'Inactive';
    }
}