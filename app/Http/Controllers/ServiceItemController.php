<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceItemRequest;
use App\Models\ItemGallery;
use App\Models\ServiceItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ServiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ServiceItem::with('service')->orderBy('start_date')->paginate(7);

        return Inertia::render('service_item/Index', [
            'item_services' => $items, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('service_item/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceItemRequest $request)
    {
        $service_item = $request->validated();
        
        if ($request->hasFile('image_file') && $service_item) {
            $image_file = $service_item['image_file'];
            $image_uri = $service_item['caption_image'];
            $slug_img = Str::slug($image_uri, '-');
            $image_uri = substr($slug_img, 0, 50);
            $slug_img = $image_uri;
            $ext = $image_file->getClientOriginalExtension();
            $image_uri = "{$image_uri}.{$ext}";
            $image_file->storeAs('images/services', $image_uri, 'public');

            $serviceItem = ServiceItem::create([
                'service_id' => $service_item['service_id'],
                'slug' => $service_item['slug'],
                'description' => $service_item['description'],
                'excerpt' => $service_item['excerpt'],
                'price' => $service_item['price'],
                'included' => $service_item['included'],
                'duration' => $service_item['duration'],
                'state' => $service_item['state'],
                'image_uri' => $image_uri,
                'caption_image' => $service_item['caption_image'],
                'location' => $service_item['location'],
                'capacity' => $service_item['capacity'],
                'start_date' => $service_item['start_date'],
                'featured' => $service_item['featured'],
                'position' => $service_item['position'],
            ]);


            // Archivos subidos a la galería
            $galleryFiles = $request->file('gallery', []);
            // Galería local, enviada por el usuario
            $localGallery = collect($request->input('gallery', [])); 

            // Recorremos el array
            foreach ($localGallery as $index => $img) {
                // Nos aseguramos que no esté vacío el file agregado
                if (empty($img['id']) && isset($galleryFiles[$index]['file']) && $galleryFiles[$index]['file']->isValid()) {
                    // asignamos el file
                    $file = $galleryFiles[$index]['file'];
                    
                    $name = Str::slug($img['caption']);
                    $name = Str::limit($name, 30, '');
                    $ext = $file->getClientOriginalExtension();
                    $filename = "{$name}".uniqid().".{$ext}";
                    // Guardamos el fichero en el disco
                    $file->storeAs('images/services/gallery', $filename, 'public');
                    // Guardamos el registro en la DB
                    $serviceItem->gallery()->create([
                        'image_uri' => $filename,
                        'caption' => $img['caption'],
                    ]);
                }
            }

            return to_route('service_item.index')->with('message', 'created');
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
        $service_item = ServiceItem::with('gallery')->findOrFail($id);

        // dd($service_item);
        return inertia('service_item/Edit', [
            'service_item' => $service_item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceItemRequest $request, string $id)
    {
        // Validación del request
        $validated = $request->validated();
        // Sub servicio junto con su galería correspondiente
        $service_item = ServiceItem::with('gallery')->findOrFail($id);
        // Archivos subidos a la galería
        $galleryFiles = $request->file('gallery');
        // Image_uri de la DB
        $image_uri = $service_item['image_uri'];
        // En caso de haber archivos para el sub servicio y estar validado...
        if ($request->hasFile('image_file') && $validated) {
            $image_file = $validated['image_file'];
            $image_uri = $validated['caption_image'];
            $slug_img = Str::slug($image_uri, '-');
            $image_uri = substr($slug_img, 0, 50);
            $slug_img = $image_uri;
            $ext = $image_file->getClientOriginalExtension();
            $image_uri = "{$image_uri}.{$ext}";
            // Si existe el registro image_uri en la DB
            if ($service_item->image_uri) {
                // Eliminamos la imagen anterior 
                Storage::disk('public')->delete("images/services/{$service_item->image_uri}");
                // Y guardamos la nueva en el disco
                $image_file->storeAs('images/services', $image_uri, 'public');
            }

        }

        // Galería de la DB
        $dbGallery = $service_item->gallery->keyBy('id');
        // Galería local, enviada por el usuario
        $localGallery = collect($validated['gallery'] ?? []);
        // Tomamos los id locales
        $localIds = $localGallery
            ->pluck('id')
            ->filter()
            ->map(fn ($id) => (int) $id);

        // Guardamos los id locales que se van a eliminar en caso de ya estar en la DB
        $deleted = $dbGallery->keys()->diff($localIds);
        // Recorremos el arreglo delos id a eliminar
        foreach ($deleted as $id) {
            // instanciamos el id de la imagen de la DB a eliminar
            $img = $dbGallery[$id];
            // La eliminamos del disco
            Storage::disk('public')
                ->delete("images/services/gallery/{$img->image_uri}");

            // Y la eliminamos de la DB
            $img->delete();
        }

        // Asignamos un array con las imagenes locales que vienen con id null que serían las recién agregadas
        $newImages = $localGallery->filter(fn ($img) => empty($img['id']));
        // Recorremos el array
        foreach ($newImages as $index => $img) {
            // Nos aseguramos que no esté vacío el file agregado
            if (! empty($galleryFiles[$index]['file'])) {
                // asignamos el file
                $file = $galleryFiles[$index]['file'];
                
                $name = Str::slug($img['caption']);
                $name = Str::limit($name, 30, '');
                $ext = $file->getClientOriginalExtension();
                $filename = "{$name}".uniqid().".{$ext}";
                // Guardamos el fichero en el disco
                $file->storeAs('images/services/gallery', $filename, 'public');
                // Guardamos el registro en la DB
                $service_item->gallery()->create([
                    'image_uri' => $filename,
                    'caption' => $img['caption'],
                ]);
            }
        }

        // Asignamos los valores del subservicio, solamente los campos que sean actualizados
        $service_item->fill([
            'service_id' => $validated['service_id'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'excerpt' => $validated['excerpt'],
            'price' => $validated['price'],
            'included' => $validated['included'],
            'duration' => $validated['duration'],
            'state' => $validated['state'],
            'image_uri' => $image_uri,
            'caption_image' => $validated['caption_image'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'start_date' => $validated['start_date'],
            'featured' => $validated['featured'],
            'position' => $validated['position'],
        ]);
        // guardamos los datos en DB
        $service_item->save();

        return redirect()->route('service_item.index')->with('message', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service_item = ServiceItem::with('gallery')->findOrFail($id);
        $dbGallery = $service_item->gallery->keyBy('id');
        $deleted = $dbGallery->keys();        
        foreach($deleted as $id) {
            $img = $dbGallery[$id];
            // echo($img->image_uri);
            Storage::disk('public')->delete("images/services/gallery/{$img->image_uri}");
            $img->delete();
        }
        if ($service_item['image_uri']) {
            Storage::disk('public')->delete('images/services/'.$service_item['image_uri']);
        }
        $service_item->delete();
        return to_route('service_item.index')->with('message', 'deleted');
    }

    public function getItemGallery(string $id)
    {
        return ItemGallery::where('item_id', $id)->orderByRaw('id')->get();
        // return response(json_encode($gallery));
        // dd($gallery);
    }
}
