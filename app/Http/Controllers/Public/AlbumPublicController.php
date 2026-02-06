<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class AlbumPublicController extends Controller
{
    public function index(Request $request)
    {
        // Consulta base: solo álbumes públicos
        $query = Album::with('user.photographerProfile')
            ->where('is_public', true);

        // Filtro por fotógrafo
        if ($request->filled('fotografo')) {
            $query->where('user_id', $request->fotografo);
        }

        // Filtro por evento (búsqueda parcial)
        if ($request->filled('evento')) {
            $query->where('event', 'like', '%' . $request->evento . '%');
        }

        // Filtro por ubicación (búsqueda parcial)
        if ($request->filled('ubicacion')) {
            $query->where('location', 'like', '%' . $request->ubicacion . '%');
        }

        // Ordenar por más recientes
        $albums = $query->latest()->paginate(12);

        // Lista de fotógrafos para el filtro
        $fotografos = User::where('role', 'fotografo')
            ->whereHas('albums', function($q) {
                $q->where('is_public', true);
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('public.albums.index', compact('albums', 'fotografos'));
    }

    public function show(Album $album)
{
    // Solo mostrar si es público
    abort_unless($album->is_public, 404, 'Este álbum no está disponible públicamente.');

    // Cargar relaciones
    $album->load('user.photographerProfile');

    // Más álbumes del mismo fotógrafo (máximo 3)
    $moreAlbums = Album::where('user_id', $album->user_id)
        ->where('is_public', true)
        ->where('id', '!=', $album->id)
        ->latest()
        ->take(3)
        ->get();

    return view('public.albums.show', compact('album', 'moreAlbums'));
}
}