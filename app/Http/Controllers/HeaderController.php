<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeaderRequest;
use App\Models\HeaderGallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = HeaderGallery::orderBy('id')->paginate(7);

        return Inertia::render('header/Index', [
            'headers' => $headers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('header/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeaderRequest $request)
    {
        /** @var \Illuminate\Http\Request $request */

        $header = $request->validated();
        if ($request->hasFile('image_file') && $header) {
            $image_file = $header['image_file'];
            $image_uri = $header['caption'];
            $slug = Str::slug($image_uri, '_');
            $image_uri = substr($slug, 0, 25);
            $ext = $image_file->getClientOriginalExtension();
            $image_uri = "{$image_uri}.{$ext}";
            $image_file->storeAs('images/header', $image_uri, 'public');

            HeaderGallery::create([
                'description' => $header['description'],
                'image_uri' => $image_uri,
                'caption' => $header['caption'],
            ]);
        }

        // return redirect()->route('header.index');
        return to_route('header.index')->with('message', 'created');
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
        $header = HeaderGallery::findOrFail($id);

        return inertia('header/Edit', [
            'header' => $header,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeaderRequest $request, HeaderGallery $header)
    {
        /** @var \Illuminate\Http\Request $request */
        
        $headerGallery = HeaderGallery::findOrFail($header->id);
        $validated = $request->validated();
        // descripción del formulario
        $description = $validated['description'];
        // caption del formulario
        $caption = $validated['caption'];
        // nombre de imagen actual
        $image_uri = $headerGallery->image_uri;
        // Si el usuario cargó una nueva imagen
        if ($request->hasFile('image_file')) {
            // instanciamos el archivo de imagen
            $image_file = $validated['image_file'];
            // dd($image_file);
            // asignamos nombre a la nueva uri con el caption del formulario
            $image_uri = $caption;
            // remplazamos los espacios por _
            $slug = Str::slug($image_uri, '_');
            // limitamos a 25
            $image_uri = substr($slug, 0, 25);
            // Si hay imagen existente
            if ($header->image_uri) {
                // tomamos la extensión de la imagen
                $ext = $image_file->getClientOriginalExtension();
                // y le asignamos el nombre de la uri previamente preparada
                // concatenándole la extensión
                $image_uri = "{$image_uri}.{$ext}";
                // dd($image_uri);
                // eliminamos la imagen a cambiar
                Storage::disk('public')->delete("images/header/{$header->image_uri}");
                // almacenamos la nueva imagen con el nombre que preparamos
                $image_file->storeAs('images/header', $image_uri, 'public');
            }
        }
        $headerGallery->fill([
            'description' => $description,
            'caption' => $caption,
            'image_uri' => $image_uri,
        ]);
        $headerGallery->save();

        return redirect()->route('header.index')->with('message', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeaderGallery $header)
    {
        // dd($header);
        if ($header->image_uri) {
            Storage::disk('public')->delete('images/header/'.$header->image_uri);
        }
        $header->delete();
        return to_route('header.index')->with('message', 'deleted');
    }
}
