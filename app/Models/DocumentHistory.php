<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'action',
        'from_user',
        'to_user',
        'comments'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Parent document
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    // Sender (who performed action)
  // app/Models/DocumentHistory.php

public function fromUser()
{
    return $this->belongsTo(User::class, 'from_user');
}

public function toUser()
{
    return $this->belongsTo(User::class, 'to_user');
}
    
}