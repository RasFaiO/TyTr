<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderGallery extends Model
{
	protected $fillable = [
		'description',
		'image_uri',
		'caption',
	];
}
