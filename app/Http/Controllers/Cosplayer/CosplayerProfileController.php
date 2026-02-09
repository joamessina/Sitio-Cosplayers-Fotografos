<?php

namespace App\Http\Controllers\Cosplayer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CosplayerProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        if (!$user->cosplayerProfile) {
            $user->cosplayerProfile()->create([
                'display_name' => $user->name,
            ]);
            $user->load('cosplayerProfile');
        }

        $profile = $user->cosplayerProfile;
        $photos = $user->cosplayerPhotos()->latest()->get();

        return view('cosplayer.perfil.edit', compact('user', 'profile', 'photos'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ], [
            'display_name.required' => 'El nombre a mostrar es obligatorio.',
            'display_name.max' => 'El nombre no puede superar los 255 caracteres.',
            'bio.max' => 'La biografía no puede superar los 500 caracteres.',
            'instagram.max' => 'El usuario de Instagram no puede superar los 100 caracteres.',
            'portfolio_url.url' => 'El portfolio debe ser una URL válida.',
            'portfolio_url.max' => 'La URL del portfolio no puede superar los 255 caracteres.',
            'location.max' => 'La ubicación no puede superar los 255 caracteres.',
        ]);

        $user = auth()->user();

        if (!$user->cosplayerProfile) {
            $user->cosplayerProfile()->create($validated);
        } else {
            $user->cosplayerProfile()->update($validated);
        }

        return redirect()->route('cosplayer.perfil.edit')->with('status', 'Perfil actualizado correctamente.');
    }

    public function updatePhotos(Request $request)
    {
        $request->validate([
            'visible_photos' => ['nullable', 'array'],
            'visible_photos.*' => ['integer', 'exists:photos,id'],
        ]);

        $user = auth()->user();
        $visibleIds = $request->input('visible_photos', []);

        // Poner todas las fotos del usuario como no públicas
        $user->cosplayerPhotos()->update(['is_public' => false]);

        // Marcar como públicas solo las seleccionadas (verificando que pertenezcan al usuario)
        if (!empty($visibleIds)) {
            $user->cosplayerPhotos()->whereIn('id', $visibleIds)->update(['is_public' => true]);
        }

        return redirect()->route('cosplayer.perfil.edit')->with('status', 'Visibilidad de fotos actualizada.');
    }
}
