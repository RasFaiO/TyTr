<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductItemRequest;
use App\Models\ProductItem;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductItemController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$items = ProductItem::with('product')->orderBy('id', 'desc')->paginate(7);
		return Inertia::render('product_item/Index', [
			'item_products' => $items
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return inertia('product_item/Create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(ProductItemRequest $request)
	{
		$product_item = $request->validated();
		if ($request->hasFile('image_file') && $product_item) {
			$image_file = $product_item['image_file'];
			$image_uri = $product_item['slug'];
			$ext = $image_file->getClientOriginalExtension();
			$image_uri = "{$image_uri}.{$ext}";
			$image_file->storeAs('images/products/', $image_uri, 'public');

			$product_item = ProductItem::create([
				'product_id' => $product_item['product_id'],
				'slug' => $product_item['slug'],
				'description' => $product_item['description'],
				'excerpt' => $product_item['excerpt'],
				'price' => $product_item['price'],
				'stock' => $product_item['stock'],
				'image_uri' => $image_uri,
				'caption_image' => $product_item['caption_image'],
				'size' => $product_item['size'],
				'weight' => $product_item['weight'],
				'color' => $product_item['color'],
				'unit' => $product_item['unit'],
				'state' => $product_item['state'],
				'featured' => $product_item['featured'],
			]);

			return to_route('product_item.index')->with('message', 'created');
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$product_item = ProductItem::findOrFail($id);
		return inertia('product_item/Edit', [
			'product_item' => $product_item,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(ProductItemRequest $request, string $id)
	{
		$validated = $request->validated();
		$product_item = ProductItem::findOrFail($id);
		$image_uri = $product_item['image_uri'];
		// dd($validated);
		if ($request->hasFile('image_file') && $validated) {
			$image_file = $validated['image_file'];
			$image_uri = $validated['slug'];
			$ext = $image_file->getClientOriginalExtension();
			$image_uri = "{$image_uri}.{$ext}";
			if ($image_uri) {
				Storage::disk('public')->delete("images/products/{$product_item->image_uri}");
				$image_file->storeAs('images/products/', $image_uri, 'public');
			}
		}
		$product_item->fill([
			'product_id' => $validated['product_id'],
			'slug' => $validated['slug'],
			'description' => $validated['description'],
			'excerpt' => $validated['excerpt'],
			'price' => $validated['price'],
			'stock' => $validated['stock'],
			'image_uri' => $image_uri,
			'caption_image' => $validated['caption_image'],
			'size' => $validated['size'],
			'weight' => $validated['weight'],
			'color' => $validated['color'],
			'unit' => $validated['unit'],
			'state' => $validated['state'],
			'featured' => $validated['featured'],
		]);
		$product_item->save();
		return redirect()->route('product_item.index')->with('message', 'updated');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$product_item = ProductItem::findOrFail($id);
		if ($product_item['image_uri']){
			Storage::disk('public')->delete('images/products/'.$product_item['image_uri']);
		}
		$product_item->delete();
		return to_route('product_item.index')->with('message','deleted');
	}
}
