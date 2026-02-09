<?php

namespace App\Http\Controllers\Cosplayer;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $favoriteAlbums = $user->favoriteAlbums()
            ->with('user.photographerProfile')
            ->latest('favorites.created_at')
            ->paginate(12);

        return view('cosplayer.favorites.index', compact('favoriteAlbums'));
    }

    public function store(Request $request, Album $album)
    {
        $user = auth()->user();

        // Verificar que el álbum sea público
        abort_unless($album->is_public, 404);

        // Verificar que el usuario es cosplayer
        abort_unless($user->role === 'cosplayer', 403);

        // Crear favorito si no existe
        $favorite = Favorite::firstOrCreate([
            'user_id' => $user->id,
            'album_id' => $album->id,
        ]);

        if ($favorite->wasRecentlyCreated) {
            return response()->json([
                'success' => true,
                'message' => 'Álbum agregado a favoritos ❤️',
                'action' => 'added'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Este álbum ya está en tus favoritos',
                'action' => 'exists'
            ]);
        }
    }

    public function destroy(Album $album)
    {
        $user = auth()->user();

        // Verificar que el usuario es cosplayer
        abort_unless($user->role === 'cosplayer', 403);

        $deleted = Favorite::where([
            'user_id' => $user->id,
            'album_id' => $album->id,
        ])->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Álbum removido de favoritos',
                'action' => 'removed'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Este álbum no está en tus favoritos',
                'action' => 'not_found'
            ]);
        }
    }
}