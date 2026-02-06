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
    
    // 1. Buscar por nombre o email
    $user = User::where(function($query) use ($username) {
        $query->where('name', $username)
              ->orWhere('name', 'LIKE', $username)
              ->orWhere('email', 'LIKE', $username . '@%');
    })->first();

    // 2. Si no encuentra, buscar por la parte del email (antes del @)
    if (!$user) {
        $user = User::whereRaw('SUBSTRING_INDEX(email, "@", 1) = ?', [$username])->first();
    }

    // 3. Si no encuentra, buscar por Instagram en photographer_profiles
    if (!$user) {
        $user = User::whereHas('photographerProfile', function($query) use ($username) {
            $query->where('instagram', $username);
        })->first();
    }

    // 4. Si no encuentra, buscar por Instagram en cosplayer_profiles
    if (!$user) {
        $user = User::whereHas('cosplayerProfile', function($query) use ($username) {
            $query->where('instagram', $username);
        })->first();
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

        return view('public.portfolio.fotografo', compact('user', 'albums'));
        
    } elseif ($user->role === 'cosplayer') {
        $user->load('cosplayerProfile');
        
        // Fotos del cosplayer
        $photos = collect(); // Por ahora vacío

        return view('public.portfolio.cosplayer', compact('user', 'photos'));
    }

    abort(404, 'Perfil no disponible');
}
}