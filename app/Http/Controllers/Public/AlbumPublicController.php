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

        // NUEVOS FILTROS AVANZADOS

        // Búsqueda por texto en título y descripción
        if ($request->filled('buscar')) {
            $searchTerm = '%' . $request->buscar . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('event', 'like', $searchTerm);
            });
        }

        // Filtro por fecha exacta
        if ($request->filled('fecha_exacta')) {
            $query->whereDate('event_date', $request->fecha_exacta);
        }

        // Filtro por rango de fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('event_date', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('event_date', '<=', $request->fecha_hasta);
        }

        // Ordenamiento personalizado
        $orden = $request->get('orden', 'recientes');
        switch ($orden) {
            case 'antiguos':
                $query->oldest('created_at');
                break;
            case 'evento_az':
                $query->orderBy('event', 'asc');
                break;
            case 'evento_za':
                $query->orderBy('event', 'desc');
                break;
            case 'fecha_evento':
                $query->orderBy('event_date', 'desc');
                break;
            default: // 'recientes'
                $query->latest('created_at');
                break;
        }

        $albums = $query->paginate(12);

        // Lista de fotógrafos para el filtro
        $fotografos = User::where('role', 'fotografo')
            ->whereHas('albums', function($q) {
                $q->where('is_public', true);
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        // Cargar información de favoritos para el usuario actual si está loggeado
        $user = auth()->user();
        if ($user && $user->role === 'cosplayer') {
            $favoriteAlbumIds = $user->favoriteAlbums()->pluck('albums.id')->toArray();
            foreach ($albums as $album) {
                $album->is_favorited_by_user = in_array($album->id, $favoriteAlbumIds);
            }
        } else {
            foreach ($albums as $album) {
                $album->is_favorited_by_user = false;
            }
        }

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