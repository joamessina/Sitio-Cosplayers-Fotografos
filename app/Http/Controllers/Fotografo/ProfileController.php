<?php

namespace App\Http\Controllers\Fotografo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        if (!$user->photographerProfile) {
            $user->photographerProfile()->create([
                'display_name' => $user->name,
                'primary_color' => '#6366f1',
                'secondary_color' => '#a855f7',
            ]);
            $user->load('photographerProfile');
        }

        $profile = $user->photographerProfile;

        return view('fotografo.perfil.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'primary_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'cover' => ['nullable', 'image', 'max:10240'],
        ], [
            'display_name.required' => 'El nombre a mostrar es obligatorio.',
            'display_name.max' => 'El nombre no puede superar los 255 caracteres.',
            'bio.max' => 'La biografía no puede superar los 500 caracteres.',
            'instagram.max' => 'El usuario de Instagram no puede superar los 100 caracteres.',
            'portfolio_url.url' => 'El portfolio debe ser una URL válida.',
            'portfolio_url.max' => 'La URL del portfolio no puede superar los 255 caracteres.',
            'location.max' => 'La ubicación no puede superar los 255 caracteres.',
            'primary_color.required' => 'El color primario es obligatorio.',
            'primary_color.regex' => 'El color primario debe ser un código hex válido (ej: #FF0000).',
            'secondary_color.required' => 'El color secundario es obligatorio.',
            'secondary_color.regex' => 'El color secundario debe ser un código hex válido (ej: #FF0000).',
            'avatar.image' => 'El avatar debe ser una imagen.',
            'avatar.max' => 'El avatar no puede superar los 2MB.',
            'cover.image' => 'La foto de portada debe ser una imagen.',
            'cover.max' => 'La foto de portada no puede superar los 10MB.',
        ]);

        $user = auth()->user();
        $profile = $user->photographerProfile;

        // Datos del formulario (sin archivos)
        $data = collect($validated)->except(['avatar', 'cover'])->toArray();

        // Avatar
        if ($request->hasFile('avatar')) {
            if ($profile && $profile->avatar_path) {
                Storage::disk('public')->delete($profile->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('remove_avatar')) {
            if ($profile && $profile->avatar_path) {
                Storage::disk('public')->delete($profile->avatar_path);
            }
            $data['avatar_path'] = null;
        }

        // Cover
        if ($request->hasFile('cover')) {
            if ($profile && $profile->cover_path) {
                Storage::disk('public')->delete($profile->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        } elseif ($request->boolean('remove_cover')) {
            if ($profile && $profile->cover_path) {
                Storage::disk('public')->delete($profile->cover_path);
            }
            $data['cover_path'] = null;
        }

        if (!$profile) {
            $user->photographerProfile()->create($data);
        } else {
            $profile->update($data);
        }

        return redirect()->route('fotografo.perfil.edit')->with('status', 'Perfil actualizado correctamente.');
    }
}
