<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemGallery extends Model
{
    protected $table = 'item_gallery';

    protected $fillable = [
        'item_id',
        'image_uri',
        'caption'
    ];

    public function item(): BelongsTo {
        return $this->belongsTo(ServiceItem::class, 'item_id');
    }

}
