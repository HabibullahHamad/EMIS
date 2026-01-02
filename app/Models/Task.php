<<<<<<< HEAD
=======
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_by',
        'assigned_to',
        'priority',
        'status',
        'due_date',
    ];

    // Relation to the user who assigned the task
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Relation to the user who received the task
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }


    public function assignee()
{
    return $this->belongsTo(User::class, 'assignee_id');
}

}
>>>>>>> 2b0771bf983854dcda41ed693aa196ddad37647a
