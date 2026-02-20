<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotItem extends Model
{

    protected $fillable = [
        'lot_id',
        'size_id',
        'color_id',
        'quantity',
        'description',
    ];


    // Link back to the Vehicle
    
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class,'size_id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class,'color_id');
    }

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class,'lot_id');
    }

    public function stitchingItem(): HasMany
    {
        return $this->hasMany(StitchingItem::class,'lot_item_id');
    }

      
}