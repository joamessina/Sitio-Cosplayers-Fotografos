<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;

class FotografoController extends Controller
{
    public function index()
    {
        $fotografos = User::query()
            ->where('role', 'fotografo')
            ->orderBy('name')
            ->get(['id','name']);

        return view('public.fotografos.index', compact('fotografos'));
    }

    public function show(User $user)
{
    abort_unless($user->role === 'fotografo', 404);

    // Cargar el perfil del fotógrafo
    $user->load('photographerProfile');

    // Cargar álbumes públicos del fotógrafo
    $albums = $user->albums()
        ->where('is_public', true)
        ->latest()
        ->get();

    return view('public.fotografos.show', compact('user', 'albums'));
}
}
