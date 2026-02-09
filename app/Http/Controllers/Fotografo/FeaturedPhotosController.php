<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class FeaturedPhotosController extends Controller
{
    public function edit(Album $album)
    {
        // Verificar que el álbum pertenece al fotógrafo autenticado
        abort_unless($album->user_id === auth()->id(), 403);

        return view('fotografo.albums.featured', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        // Verificar que el álbum pertenece al fotógrafo autenticado
        abort_unless($album->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'featured_urls' => ['nullable', 'array', 'max:5'],
            'featured_urls.*' => ['required', 'url', 'max:500'],
        ], [
            'featured_urls.max' => 'Máximo 5 fotos destacadas permitidas.',
            'featured_urls.*.required' => 'Cada URL de foto es obligatoria.',
            'featured_urls.*.url' => 'Cada entrada debe ser una URL válida.',
            'featured_urls.*.max' => 'Cada URL no puede superar los 500 caracteres.',
        ]);

        // Filtrar URLs vacías
        $featuredUrls = array_filter($validated['featured_urls'] ?? [], function($url) {
            return !empty(trim($url));
        });

        // Actualizar el álbum
        $album->update([
            'featured_photo_urls' => array_values($featuredUrls), // reindexar array
            'featured_photos_count' => count($featuredUrls),
        ]);

        $message = count($featuredUrls) > 0
            ? 'Fotos destacadas guardadas correctamente ✅'
            : 'Fotos destacadas removidas ✅';

        return redirect()->route('fotografo.albums.featured.edit', $album)
            ->with('status', $message);
    }
}