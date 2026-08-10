<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FocalPointCard extends Model
{
    use HasFactory;

    protected $table = 'focal_point_cards';

    /**
     * Fields allowed for mass assignment.
     */
    protected $fillable = [
        'focal_point_id',
        'card_number',
        'verification_uuid',
        'fiscal_year',
        'issue_date',
        'expiry_date',
        'card_status',

        'printed_at',
        'printed_by',

        'issued_at',
        'issued_by',
        'received_by_name',
        'received_at',
        'receiver_signature_path',

        'pdf_path',

        'reprint_count',
        'reprint_reason',

        'revoked_at',
        'revoked_by',
        'revocation_reason',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',

            'printed_at' => 'datetime',
            'issued_at' => 'datetime',
            'received_at' => 'datetime',
            'revoked_at' => 'datetime',

            'reprint_count' => 'integer',
        ];
    }

    /**
     * The focal point who owns this card.
     */
    public function focalPoint(): BelongsTo
    {
        return $this->belongsTo(
            FocalPoint::class,
            'focal_point_id'
        );
    }

    /**
     * User who printed the card.
     */
    public function printedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'printed_by'
        );
    }

    /**
     * User who issued the card.
     */
    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'issued_by'
        );
    }

    /**
     * User who revoked the card.
     */
    public function revokedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'revoked_by'
        );
    }

    /**
     * Human-readable status.
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst(
            str_replace('_', ' ', $this->card_status)
        );
    }

    /**
     * Determine whether the card is currently valid.
     */
    public function getIsValidAttribute(): bool
    {
        if ($this->card_status === 'revoked') {
            return false;
        }

        if (
            $this->expiry_date &&
            now()->startOfDay()->gt($this->expiry_date->endOfDay())
        ) {
            return false;
        }

        return in_array(
            $this->card_status,
            [
                'approved',
                'printed',
                'issued',
            ],
            true
        );
    }
}