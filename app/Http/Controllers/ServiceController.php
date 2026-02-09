<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = Service::orderBy('id')->paginate(7);

        return Inertia::render('services/Index', [
            'services' => $service,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('services/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        /** @var \Illuminate\Http\Request $request */
        $service = $request->validated();
        if ($request->hasFile('image_file') && $service) {
            $image_file = $service['image_file'];
            $image_uri = $service['name'];
            $slug = Str::slug($image_uri, '_');
            $image_uri = substr($slug, 0, 25);
            $slug = $image_uri;
            $ext = $image_file->getClientOriginalExtension();
            $image_uri = "{$image_uri}.{$ext}";
            $image_file->storeAs('images/services', $image_uri, 'public');

            Service::create([
                'name' => $service['name'],
                'slug' => $slug,
                'excerpt' => $service['excerpt'],
                'description' => $service['description'],
                'image_uri' => $image_uri,
                'caption_image' => $service['caption_image'],
                'state' => $service['state'],
            ]);

            return to_route('catService.index')->with('message', 'created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $service = Service::where('slug', $slug)
        ->with(['items' => function ($query) {
            $query->where('state', 1);
        }])
        ->firstOrFail();
        return Inertia::render('landing/services/Show', [
            'service' => $service,
        ]);
    }

    public function item($slug, $itemSlug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        
        $item = ServiceItem::with('gallery')
        ->where('slug', $itemSlug)
        ->firstOrFail();
        
        // Muestra la página de la Landing del servicio principal trayendo los subservicios disponibles
        return Inertia::render('landing/services/Item', [
            'service' => $service,
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);

        return inertia('services/Edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        /** @var \Illuminate\Http\Request $request */
        $service = Service::findOrFail($id);
        $validated = $request->validated();
        $image_uri = $service['image_uri'];
        
        if ($request->hasFile('image_file') && $validated) {
            
            $image_file = $validated['image_file'];
            $image_uri = $validated['name'];
            $slug = Str::slug($image_uri, '_');
            $image_uri = substr($slug, 0, 25);
            $ext = $image_file->getClientOriginalExtension();
            $image_uri = "{$image_uri}.{$ext}";
            
            if ($service->image_uri) {
                Storage::disk('public')->delete("images/services/{$service->image_uri}");
                $image_file->storeAs('images/services', $image_uri, 'public');
            }
        }
        $slug = Str::slug(substr($validated['name'], 0, 25), '_');
        
        $service->fill([
            'name' => $validated['name'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'description' => $validated['description'],
            'image_uri' => $image_uri,
            'caption_image' => $validated['caption_image'],
            'state' => $validated['state'],
        ]);
        $service->save();
        return redirect()->route('catService.index')->with('message', 'updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        if ($service['image_uri']) {
            Storage::disk('public')->delete('images/services/'.$service['image_uri']);
        }
        $service->delete();
        return to_route('catService.index')->with('message','deleted');
    }

    public function getServices() {
        return Service::where('state',1)->orderByRaw('name')->get();
    }
}
