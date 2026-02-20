<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StitchingItem extends Model
{

     protected $fillable = [
        'stitching_id',
        'lot_item_id',
        'employee_id',
        'department_id',
        'quantity',
        'price',
        'description',
        'total',
        'advance',
    ];



    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class,'department_id');
    }

  
    public function lotItem(): BelongsTo
    {
        return $this->belongsTo(LotItem::class,'lot_item_id');
    }

    public function stitching(): BelongsTo
    {
        return $this->belongsTo(Stitching::class,'stitching_id');
    }


}
