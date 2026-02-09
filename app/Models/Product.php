<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'description',
        'image_uri',
        'caption_image',
        'state'
    ];

    public function items(): HasMany {
        return $this->hasMany(ProductItem::class);
    }
}
