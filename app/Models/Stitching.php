<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stitching extends Model
{

     protected $fillable = [
        'ref',
        'image',
        'description',
        'total_quantity',
        'date',
    ];

    //

    public function items(): HasMany
    {
        return $this->hasMany(StitchingItem::class,'stitching_id');
    }


    

}
