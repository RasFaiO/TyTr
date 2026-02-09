<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductItem extends Model
{
    protected $fillable = [
        'product_id',
        'slug',
        'description',
        'excerpt',
        'price',
        'stock',
        'image_uri',
        'caption_image',
        'size',
        'weight',
        'color',
        'unit',
        'state',
        'featured'
    ];

    public function scopeFeatured($query) {
        return $query->where('featured', true)->where('state', true);
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
