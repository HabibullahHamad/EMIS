<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Outgoing extends Model
{
    use HasFactory;

    protected $table = 'outgoing';

    protected $fillable = [
        'letter_no',
        'subject',
        'recipient',
        'sent_date',
        'priority',
        'status',
        'attachment',
        'attachment_names',
    ];
    public function attachments()
{
    return $this->morphMany(
        \App\Models\Attachment::class,
        'attachable'
    );
}
}   
