<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{

    protected $fillable = [
        'name',
        'father_name',
        
        'group_id',
        'department_id',
        'designation_id',
        'phone',
        'gender',
        'nic',
        'email',
        'status',
        'joined_date',
    ];

    // Link back to the Vehicle
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

}