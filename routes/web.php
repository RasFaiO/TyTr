<?php

// use App\Http\Controllers\HikingController;

use App\Http\Controllers\HeaderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductItemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas generales
Route::get('/', [LandingController::class, 'index'])->name('home'); //index
Route::get('/about', [LandingController::class, 'about'])->name('about');
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::post('/contactme', [LandingController::class, 'contactme'])->name('contactme.send');

// Rutas específicas de services
Route::prefix('services')->name('services.')->group(function () {
  Route::get('/', [LandingController::class, 'services'])->name('index');

  // Subcategory Tours
  Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
  Route::get('/{slug}/{item}', [ServiceController::class, 'item'])->name('item');

});

Route::prefix('products')->name('products.')->group(function () {
  Route::get('/', [LandingController::class, 'products'])->name('products');
  
  // SubCategory Products
  Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
  Route::get('/{slug}/{item}', [ProductController::class, 'item'])->name('item');
});

// Rutas Autenticadas
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

  Route::resource('/header', HeaderController::class);
  Route::resource('/catService', ServiceController::class);
  Route::resource('/service_item', ServiceItemController::class);
  Route::resource('/catProduct', ProductController::class);
  Route::resource('/product_item', ProductItemController::class);
  Route::resource('/users', UserController::class);
});

// use Illuminate\Support\Facades\Route;
// use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';