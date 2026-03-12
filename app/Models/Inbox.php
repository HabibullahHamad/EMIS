<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'inbox'; // FIXED

    protected $fillable = [
        'letter_no', 
        'subject', 
        'sender', 
        'receiver',
        'received_date',
         'summary', 
    
         'attachment',
        
    ];

}
class Documents extends Model
{
  protected $table = 'documents'; // 
  
    protected $fillable = [
    'doc_number',
    'subject',
    'receiver',
    'doc_date',
    'attachment'
];
}



