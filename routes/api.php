<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceItemController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group( function () {
  Route::get('/services', [ServiceController::class, 'getServices']);
  Route::get('/service-gallery/{item}', [ServiceItemController::class, 'getItemGallery']);
  Route::get('/products', [ProductController::class, 'getproducts']);
});