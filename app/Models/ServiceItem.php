<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_id',
        'slug',
        'description',
        'excerpt',
        'price',
        'included',
        'duration',
        'state',
        'image_uri',
        'caption_image',
        'location',
        'capacity',
        'start_date',
        'featured',
        'position'
    ];

    public function scopeFeatured($query) {
        return $query->where('featured', true)->where('state', true);
    }

    public function service(): BelongsTo {
        return $this->belongsTo(Service::class);
    }

    public function gallery(): HasMany {
        return $this->hasMany(ItemGallery::class, 'item_id');
    }
}
