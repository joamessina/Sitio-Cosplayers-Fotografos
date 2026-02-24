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
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12);

        return view('cosplayer.mis-fotos', compact('photos'));
    }

    public function store(Request $request)
    {
        // DEBUG 1: Inicio del método
        \Log::info('=== MisFotosController@store iniciado ===');
        \Log::info('Usuario: ' . auth()->id());
        \Log::info('Archivos recibidos: ' . count($request->file('photos') ?? []));

        try {
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

            // DEBUG 2: Validación pasada
            \Log::info('✅ Validación pasada correctamente');

        } catch (\Exception $e) {
            // DEBUG: Error de validación
            \Log::error('❌ Error de validación: ' . $e->getMessage());
            throw $e;
        }

        $uploadedCount = 0;

        foreach ($request->file('photos') as $index => $photo) {
            // DEBUG 3: Procesando cada archivo
            \Log::info("📁 Procesando archivo #{$index}:");
            \Log::info("  - Nombre: " . $photo->getClientOriginalName());
            \Log::info("  - Tamaño: " . $photo->getSize() . " bytes");
            \Log::info("  - Tipo: " . $photo->getMimeType());

            try {
                $path = $photo->store('cosplayer-photos', 's3');
                \Log::info("  ✅ Archivo guardado en: " . $path);

                $photoRecord = auth()->user()->cosplayerPhotos()->create([
                    'path' => $path,
                    'caption' => $request->description,
                ]);

                \Log::info("  ✅ Registro BD creado con ID: " . $photoRecord->id);
                $uploadedCount++;

            } catch (\Exception $e) {
                \Log::error("  ❌ Error procesando archivo #{$index}: " . $e->getMessage());
                throw $e;
            }
        }

        // DEBUG 4: Final exitoso
        \Log::info("🎉 Proceso completado. Total subidas: {$uploadedCount}");

        return redirect()
            ->route('cosplayer.fotos.index')
            ->with('success', "¡{$uploadedCount} " . ($uploadedCount === 1 ? 'foto subida' : 'fotos subidas') . " exitosamente!");
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'exists:photos,id'],
        ]);

        $userId = auth()->id();

        foreach ($request->order as $index => $photoId) {
            Photo::where('id', $photoId)
                ->where('user_id', $userId)
                ->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Orden actualizado']);
    }

    public function destroy(Photo $photo)
    {
        // Verificar que la foto pertenece al usuario
        if ($photo->user_id !== auth()->id()) {
            abort(403);
        }

        // Eliminar archivo del storage
        Storage::disk('s3')->delete($photo->path);

        // Eliminar registro
        $photo->delete();

        return redirect()
            ->route('cosplayer.fotos.index')
            ->with('success', 'Foto eliminada correctamente');
    }
}