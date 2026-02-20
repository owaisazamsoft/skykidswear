<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lot extends Model
{

    protected $fillable = [
        'ref',
        'description',
        'image',
        'product_id',
        'total_quantity',
        'date',
    ];

    // Link back to the Vehicle
    public function items(): HasMany
    {
        return $this->hasMany(LotItem::class,'lot_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    

    

  
}