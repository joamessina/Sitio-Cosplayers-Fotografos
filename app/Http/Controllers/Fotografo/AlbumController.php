<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = auth()->user()->albums()
            ->latest()
            ->paginate(12);

        return view('fotografo.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('fotografo.albums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'drive_url' => ['nullable', 'url', 'max:500'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_public' => ['boolean'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'event.max' => 'El nombre del evento no puede superar los 255 caracteres.',
            'event_date.date' => 'La fecha del evento debe ser una fecha válida.',
            'location.max' => 'La ubicación no puede superar los 255 caracteres.',
            'description.max' => 'La descripción no puede superar los 1000 caracteres.',
            'drive_url.url' => 'El link de Drive debe ser una URL válida.',
            'drive_url.max' => 'El link de Drive no puede superar los 500 caracteres.',
            'thumbnail.image' => 'El archivo debe ser una imagen.',
            'thumbnail.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'thumbnail.max' => 'La imagen no puede superar los 2MB.',
        ]);

        // Manejar upload de thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('albums', 'public');
        }

        // Convertir is_public a boolean (checkbox)
        $validated['is_public'] = $request->has('is_public');

        auth()->user()->albums()->create($validated);

        return redirect()->route('fotografo.albums.index')
            ->with('status', 'Álbum creado exitosamente ✅');
    }

    public function edit(Album $album)
    {
        // Verificar que el álbum pertenece al fotógrafo autenticado
        abort_unless($album->user_id === auth()->id(), 403);

        return view('fotografo.albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        // Verificar que el álbum pertenece al fotógrafo autenticado
        abort_unless($album->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'drive_url' => ['nullable', 'url', 'max:500'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_public' => ['boolean'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'event.max' => 'El nombre del evento no puede superar los 255 caracteres.',
            'event_date.date' => 'La fecha del evento debe ser una fecha válida.',
            'location.max' => 'La ubicación no puede superar los 255 caracteres.',
            'description.max' => 'La descripción no puede superar los 1000 caracteres.',
            'drive_url.url' => 'El link de Drive debe ser una URL válida.',
            'drive_url.max' => 'El link de Drive no puede superar los 500 caracteres.',
            'thumbnail.image' => 'El archivo debe ser una imagen.',
            'thumbnail.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'thumbnail.max' => 'La imagen no puede superar los 2MB.',
        ]);

        // Manejar upload de nueva thumbnail
        if ($request->hasFile('thumbnail')) {
            // Eliminar thumbnail anterior si existe
            if ($album->thumbnail && Storage::disk('public')->exists($album->thumbnail)) {
                Storage::disk('public')->delete($album->thumbnail);
            }
            
            $validated['thumbnail'] = $request->file('thumbnail')->store('albums', 'public');
        }

        // Convertir is_public a boolean (checkbox)
        $validated['is_public'] = $request->has('is_public');

        $album->update($validated);

        return redirect()->route('fotografo.albums.index')
            ->with('status', 'Álbum actualizado exitosamente ✅');
    }

    public function destroy(Album $album)
    {
        // Verificar que el álbum pertenece al fotógrafo autenticado
        abort_unless($album->user_id === auth()->id(), 403);

        // Eliminar thumbnail si existe
        if ($album->thumbnail && Storage::disk('public')->exists($album->thumbnail)) {
            Storage::disk('public')->delete($album->thumbnail);
        }

        $album->delete();

        return redirect()->route('fotografo.albums.index')
            ->with('status', 'Álbum eliminado exitosamente ✅');
    }
}