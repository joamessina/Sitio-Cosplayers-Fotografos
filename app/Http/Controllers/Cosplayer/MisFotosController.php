<?php

namespace App\Http\Controllers\Cosplayer;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MisFotosController extends Controller
{
    public function index()
    {
        $photos = auth()->user()->cosplayerPhotos()
            ->latest()
            ->paginate(12);

        return view('cosplayer.mis-fotos', compact('photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photos' => ['required', 'array', 'min:1', 'max:10'],
            'photos.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // 5MB
            'description' => ['nullable', 'string', 'max:120'], // 120 por el límite de caption
        ], [
            'photos.required' => 'Debés seleccionar al menos una foto',
            'photos.*.image' => 'Todos los archivos deben ser imágenes',
            'photos.*.mimes' => 'Las imágenes deben ser JPG, PNG o WEBP',
            'photos.*.max' => 'Cada imagen no puede superar los 5MB',
            'photos.max' => 'Podés subir hasta 10 fotos a la vez',
        ]);

        $uploadedCount = 0;

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('cosplayer-photos', 'public');

            auth()->user()->cosplayerPhotos()->create([
                'path' => $path,
                'caption' => $request->description,
            ]);

            $uploadedCount++;
        }

        return redirect()
            ->route('cosplayer.fotos.index')
            ->with('success', "¡{$uploadedCount} " . ($uploadedCount === 1 ? 'foto subida' : 'fotos subidas') . " exitosamente!");
    }

    public function destroy(Photo $photo)
    {
        // Verificar que la foto pertenece al usuario
        if ($photo->user_id !== auth()->id()) {
            abort(403);
        }

        // Eliminar archivo del storage
        Storage::disk('public')->delete($photo->path);

        // Eliminar registro
        $photo->delete();

        return redirect()
            ->route('cosplayer.fotos.index')
            ->with('success', 'Foto eliminada correctamente');
    }
}