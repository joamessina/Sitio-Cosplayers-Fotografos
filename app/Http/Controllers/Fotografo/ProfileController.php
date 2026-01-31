<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
public function edit()
{
    $user = auth()->user();
    
    // Si no tiene perfil, crear uno vacío
    if (!$user->photographerProfile) {
        $user->photographerProfile()->create([
            'display_name' => $user->name,
        ]);
        $user->load('photographerProfile');
    }

    $profile = $user->photographerProfile;

    return view('fotografo.perfil.edit', compact('profile'));
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

        // Si no tiene perfil, crearlo
        if (!$user->photographerProfile) {
            $user->photographerProfile()->create($validated);
        } else {
            $user->photographerProfile()->update($validated);
        }

        return redirect()->route('fotografo.perfil.edit')->with('status', 'Perfil actualizado ✅');
    }
}