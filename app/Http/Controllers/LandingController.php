<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactmeRequest;
use App\Mail\ContactMailable;
use App\Models\HeaderGallery;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class LandingController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$headerImages = HeaderGallery::all();
		$featuredItems = ServiceItem::with('service')->featured()->orderBy('id')->limit(5)->get();
		$featuredProductItems = ProductItem::with('product')->featured()->orderBy('id')->limit(5)->get();
		return Inertia::render('landing/Welcome', [
			'featuredItems' => $featuredItems,
			'headerImages' => $headerImages,
			'featuredProductItems' => $featuredProductItems
		]);
	}

	/**
	 * Show the about us resource.
	 */
	public function about()
	{
		return inertia('landing/AboutUs');
	}

	/**
	 * Show the services resource.
	 */
	public function services()
	{
		$services = Service::where('state',1)->orderByRaw('id')->paginate(6);
		return Inertia::render('landing/Services', [
			'services' => $services,
		]);
	}

	/**
	 * Show the products resource.
	 */
	public function products()
	{
		$products = Product::orderByRaw('id')->where('state', true)->paginate(6);
		return Inertia::render('landing/Products', [
			'products' => $products,
		]);
	}

	/**
	 * Show the Contact resource.
	 */
	public function contact()
	{
		return inertia('landing/Contact');
	}


	public function contactme(ContactmeRequest $request) {
		$validated = $request->validated();
		Mail::to('Administrador@tyguatravel.com')
		->queue(new ContactMailable($validated));
		return redirect('/')->with('message','send');
	}
	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
