<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $product = Product::orderBy('id')->paginate(7);

    return Inertia::render('products/Index', [
      'products' => $product,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return inertia('products/Create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProductRequest $request)
  {
    $product = $request->validated();
    if ($request->hasFile('image_file') && $product) {
      // dd($product);
      $image_file = $product['image_file'];
      $image_uri = $product['name'];
      $image_uri = Str::slug($image_uri, '_');
      $slug = $image_uri;
      $ext = $image_file->getClientOriginalExtension();
      $image_uri = "{$image_uri}.{$ext}";
      $image_file->storeAs('images/products', $image_uri, 'public');

      Product::create([
        'name' => $product['name'],
        'slug' => $slug,
        'excerpt' => $product['excerpt'],
        'description' => $product['description'],
        'image_uri' => $image_uri,
        'caption_image' => $product['caption_image'],
        'state' => $product['state'],
      ]);

      return to_route('catProduct.index')->with('message', 'created');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show($slug)
  {
    $product = Product::where('slug', $slug)->with(['items' => function ($query){
      $query->where('state',1);
    }])->firstOrFail();

    return Inertia::render('landing/products/Show', [
      'product' => $product,
    ]);
  }

  public function item($slug, $itemSlug)
  {
    $product = Product::where('slug', $slug)->where('state', 1)->firstOrFail();
    $item = ProductItem::where('slug', $itemSlug)->where('state',1)->firstOrFail();

    return Inertia::render('landing/products/Item', [
      'product' => $product,
      'item' => $item,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $product = Product::findOrFail($id);

    // dd($product);
    return inertia('products/Edit', [
      'product' => $product,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  // public function update(Request $request, string $id)
  public function update(ProductRequest $request, string $id)
  {
        // dd($request->validated());
    /** @var \Illuminate\Http\Request $request */
    $product = Product::findOrFail($id);
    $validated = $request->validated();
    $image_uri = $product['image_uri'];

    if ($request->hasFile('image_file') && $validated) {

      $image_file = $validated['image_file'];
      $image_uri = $validated['name'];
      $image_uri = Str::slug($image_uri, '_');
      $slug = $image_uri;
      $ext = $image_file->getClientOriginalExtension();
      $image_uri = "{$image_uri}.{$ext}";

      if ($product->image_uri) {
        Storage::disk('public')->delete("images/products/{$product->image_uri}");
        $image_file->storeAs('images/products', $image_uri, 'public');
      }
    }
    $slug = Str::slug($validated['name'], '_');

    $product->fill([
      'name' => $validated['name'],
      'slug' => $slug,
      'excerpt' => $validated['excerpt'],
      'description' => $validated['description'],
      'image_uri' => $image_uri,
      'caption_image' => $validated['caption_image'],
      'state' => $validated['state'],
    ]);
    $product->save();

    return redirect()->route('catProduct.index')->with('message', 'updated');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $product = Product::findOrFail($id);
    if ($product['image_uri']) {
      Storage::disk('public')->delete('images/products/' . $product['image_uri']);
    }
    $product->delete();

    return to_route('catProduct.index')->with('message', 'deleted');
  }

  public function getProducts() {
    return Product::where('state',1)->orderByRaw('name')->get();
  }
}
