<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
     protected $fillable = [
        'date',
        'employee_id',
        'type',
        'amount',
        'description',
    ];

      public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
    

    //
}
