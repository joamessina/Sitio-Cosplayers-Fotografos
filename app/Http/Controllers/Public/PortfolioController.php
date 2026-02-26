<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;

class PortfolioController extends Controller
{
    public function show($username)
    {
        // Decodificar espacios en la URL
        $username = urldecode($username);

        // Remover @ si viene en la URL
        $username = ltrim($username, '@');

        // 1. Buscar por Instagram (más específico, es lo que genera la URL del dashboard)
        $user = User::whereHas('photographerProfile', function($query) use ($username) {
            $query->where('instagram', $username);
        })->first();

        if (!$user) {
            $user = User::whereHas('cosplayerProfile', function($query) use ($username) {
                $query->where('instagram', $username);
            })->first();
        }

        // 2. Buscar por email prefix (fallback cuando no hay instagram)
        if (!$user) {
            $user = User::where('email', 'LIKE', $username . '@%')->first();
        }

        // 3. Buscar por nombre exacto
        if (!$user) {
            $user = User::where('name', $username)->first();
        }

        if (!$user) {
            abort(404, 'Usuario no encontrado');
        }

        // Cargar datos según el rol
        if ($user->role === 'fotografo') {
            $user->load('photographerProfile');

            // Solo álbumes públicos
            $albums = $user->albums()
                ->where('is_public', true)
                ->latest()
                ->take(6)
                ->get();

            $shopItems = $user->shopItems()
                ->whereIn('status', ['active', 'sold'])
                ->latest()
                ->take(6)
                ->get();

            return view('public.portfolio.fotografo', compact('user', 'albums', 'shopItems'));

        } elseif ($user->role === 'cosplayer') {
            $user->load('cosplayerProfile');

            // Fotos del cosplayer
            $photos = $user->cosplayerPhotos()
                ->where('is_public', true)
                ->orderBy('sort_order')
                ->latest()
                ->paginate(12);

            $shopItems = $user->shopItems()
                ->whereIn('status', ['active', 'sold'])
                ->latest()
                ->take(6)
                ->get();

            return view('public.portfolio.cosplayer', compact('user', 'photos', 'shopItems'));
        }

        abort(404, 'Perfil no disponible');
    }
}